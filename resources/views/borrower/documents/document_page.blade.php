@extends('layout')
@section('title')
อัพโหลดเอกสาร
@endsection

@section('content')
<section>
    <div class="card mb-3 bg-success">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-3 mt-2">
                    <h5 class="fw-bold text-light">{{$document->doctype_title}}</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-md-2 mt-2">
                    <span class="text-light">ภาคเรียนที่:</span> <span class="text-light fw-bold">{{$document->term}}</span>
                </div>
                <div class="col-md-2 mt-2">
                    <span class="text-light">ปีการศึกษา:</span> <span class="text-light fw-bold">{{$document->year}}</span>
                </div>
            </div>
        </div>
    </div>

    @foreach($child_documents as $child_document)
    <div class="card mb-3 {{ !empty($child_document['borrower_child_document']) ? 'border border-2 border-success' : '' }}">
        <div class="card-body">
            <h5 class="card-title">{{$child_document->child_document_title}}</h5>
            <div class="row">
                <div class="col-md-12 row mb-3 mx-0">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ไฟล์ประกอบไปด้วย</label>
                    <div class="col-sm-10">
                        <ul class="list-group list-borderless">
                            <li class="list-group-item">
                                - {{$child_document->child_document_title}}
                            </li>
                            @foreach($child_document->addon_documents as $addon_document)
                                @if($addon_document->for_minors && $borrower_age < 20)
                                    <li class="list-group-item">
                                        - {{$addon_document->title}}
                                    </li>
                                @elseif(!$addon_document->for_minors)
                                    <li class="list-group-item">
                                        - {{$addon_document->title}}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 row mb-3 mx-0">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ตัวอย่างเอกสาร</label>
                    <div class="col-sm-10">
                        <a href="{{route('borrower.get.examplefile',['child_document_id' => $child_document->id, 'file_for' => $borrower_age > 20 ? 'everyone' : 'minors' ])}}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark w-100">คลิกเพื่อดูไฟล์ตัวอย่าง</a>
                    </div>
                </div>
            </div>
            <form id="store-form-{{$child_document->id}}" action="{{route('borrower.upload.document',['document_id' => $document->id, 'child_document_id' => $child_document->id])}}" method="POST" enctype="multipart/form-data" class="row mx-0">
                @csrf
                @if($child_document->need_loan_balance)
                    @if(!isset($child_document->borrower_child_document))
                        <div class="col-md-12 row mb-3 mx-0 px-0">
                            <label for="education-fee-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าเล่าเรียน</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="education-fee-{{$child_document->id}}" name="education_fee" oninput="formatNumber(this)" required>
                                <div class="invalid-feedback">
                                    กรุณากรอกค่าเล่าเรียน
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row mb-3 mx-0 px-0">
                            <label for="living-exprenses{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าครองชีพ</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="living-exprenses{{$child_document->id}}" name="living_exprenses" oninput="formatNumber(this)" required>
                                <div class="invalid-feedback">
                                    กรุณากรอกค่าครองชีพรวม
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12 row mb-3 mx-0 px-0">
                            <label for="education-fee-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าเล่าเรียน</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="education-fee-{{$child_document->id}}" name="education_fee" oninput="formatNumber(this)" 
                                    @required($child_document->need_loan_balance) 
                                    @disabled(true)
                                    value="{{number_format($child_document->borrower_child_document->education_fee)}}">
                                <div class="invalid-feedback">
                                    กรุณากรอกค่าเล่าเรียน
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row mb-3 mx-0 px-0">
                            <label for="living-exprenses{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าครองชีพรวม</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="living-exprenses{{$child_document->id}}" name="living_exprenses" oninput="formatNumber(this)" 
                                    @required($child_document->need_loan_balance) 
                                    @disabled(true)
                                    value="{{number_format($child_document->borrower_child_document->living_exprenses)}}">
                                <div class="invalid-feedback">
                                    กรุณากรอกค่าครองชีพรวม
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                    <div class="row col-md-12 mx-0 px-0">
                        <label class="col-sm-2 col-form-label text-success fw-bold" for="component-file">อัพโหลดไฟล์แล้ว</label>
                        <div class="col-sm-10 mb-3">
                            <a href="{{route('borrower.upload.document.preview.file',['borrower_child_document_id' => $child_document->borrower_child_document->id])}}" target="_blank" rel="noopener noreferrer" class="btn btn-success w-100">คลิกเพื่อดูไฟล์ที่อัพโหลด</a>
                        </div>
                    </div>
            </form>
    
        </div>
    </div>
    @endforeach

    {{-- กิจกรรมจิตอาสา --}}
    @if($document->need_useful_activity)
    <div class="card {{ (int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours ? 'border border-2 border-success' : '' }} mb-3">
        <div class="card-body">
            <h5 class="card-title">กิจกรรมจิตอาสา {{$useful_activities_hours}} ชั่วโมง</h5> 
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col-2">ชื่อโครงการ</th>
                            <th scope="col-2">สถานที่</th>
                            <th scope="col-2">วัน/เดือน/ปี</th>
                            <th scope="col-2">จำนวนชั่วโมง</th>
                            <th scope="col-2">ลักษณะกิจกรรม</th>
                            <th scope="col-2">ไฟล์หลักฐาน</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                            @foreach ($useful_activities as $useful_activity)
                            <tr>
                                <td>{{$useful_activity->activity_name}}</td>
                                <td>{{$useful_activity->activity_location}}</td>
                                <td>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $useful_activity->start_date)->format('d-m-Y H:i')}} <br>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $useful_activity->end_date)->format('d-m-Y H:i')}}
                                </td>
                                <td class="text-center">{{$useful_activity->hour_count}}</td>
                                <td>{{$useful_activity->description}} </td>
                                <td class="text-center">
                                    <a class="btn btn-danger" href="{{route('borrower.show.usefulactivity.file' ,['useful_activity_id' => $useful_activity->id , 'document_id' => $document->id])}}" rel="noopener noreferrer" target="_blank"><i class="bi bi-journal-bookmark" ></i></a>
                                </td>
                                
                            </tr>
                            @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3">

                            </td>
                            <td class="text-center">{{$borrower_useful_activities_hours_sum}}/{{$useful_activities_hours}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                @if ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours)
                    <span class="badge bg-success">จำนวนชั่วโมงกิจกรรมจิตอาสาครบถ้วนตามที่กำหนด</span>
                @else 
                    <span class="badge bg-danger">จำนวนชั่วโมงกิจกรรมจิตอาสาไม่ครบตามที่กำหนด</span>
                @endif
            </div>
        </div>
    </div>
    @endif
    {{-- end กิจกรรมจิตอาสา --}}

</section>
@endsection

@section('script')
<script>

</script>
@endsection