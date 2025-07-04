@extends('layout')
@section('title')
ยื่นกู้
@endsection
@section('style')
    <style>

        .label {
            height: 100%;
            width: 100%;
        }

        .nav-link.active {
            background-color: #4382FB;
            -webkit-clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
            clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
            color: white !important;
        }

    </style>
@endsection
@section('content')
<section >
    <div class="card mb-3">
        <div class="card-body pb-0 mb-0">
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 1)
                        <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="{{route('borrower.register.type')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 2)
                        <a class="nav-link text-dark text-center m-0 active" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}"></i>ส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="#"><i class="bi bi-lock"></i>ส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 3)
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.result')}}"></i>สรุปการส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>สรุปการส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if($step >= 4)
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.recheck')}}"></i>ตรวจสอบเอกสารของระบบ</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>ตรวจสอบเอกสารของระบบ</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 5)
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="{{route('borrower.register.status')}}"></i>สถานะคำร้อง</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="#"><i class="bi bi-lock"></i>สถานะคำร้อง</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    @foreach($child_documents as $child_document)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{$child_document->child_document_title}} 
                @if(!$child_document['isrequired'])
                    <span class="text-warning">กรณีไม่มีให้ข้ามการอัพโหลดนี้</span>
                @endif
            </h5>
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
                @if($child_document->need_document_code)
                    @if(!isset($child_document->borrower_child_document))
                    <div class="col-md-12 row mb-4 mx-0 px-0">
                        <label for="document-code-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">รหัสเอกสาร 4 ตัวท้าย</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="document-code-{{$child_document->id}}" name="document_code" required
                            />
                            <div class="invalid-feedback">
                                กรุณากรอกรหัสเอกสาร
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-12 row mb-4 mx-0 px-0">
                        <label for="document-code-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">รหัสเอกสาร 4 ตัวท้าย</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="document-code-{{$child_document->id}}" name="document_code"
                                @required($child_document->need_loan_balance) 
                                @disabled(true)
                                value="{{$child_document->borrower_child_document->document_code}}">
                            <div class="invalid-feedback">
                                กรุณากรอกรหัสเอกสาร
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
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
                            <label for="living-exprenses{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าครองชีพรวม</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="living-exprenses{{$child_document->id}}" name="living_exprenses" oninput="formatNumber(this)" required >
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
                @if(empty($child_document['borrower_child_document']))
                    <div class="col-md-12 row mx-0 px-0">
                        <label class="col-sm-2 col-form-label text-secondary" for="file-{{$child_document->id}}" >เลือกไฟล์</label>
                        <div class="col-sm-7 mb-3">
                            <input class="form-control" type="file" name="document_file" id="file-{{$child_document->id}}" accept=".pdf" required onchange="validateFileSize(this.id, {{ $child_document->id}}, 'input')">
                            <div class="invalid-feedback">
                                กรุณาเลือกไฟล์
                            </div>
                            <div id="input-invalid-file-{{$child_document->id}}" class="invalid-feedback">
                                ขนาดไฟล์ต้องไม่เกิน 5mb
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button id="input-form-button-{{$child_document->id}}" type="button" class="btn btn-primary w-100" onclick="formValidate('store-form-{{$child_document->id}}', this.id)" ><i class="bi bi-arrow-up"></i> อัพโหลดเอกสาร</button>
                        </div>
                    </div>
                @else
                    <div class="row col-md-12 mx-0 px-0">
                        <label class="col-sm-2 col-form-label text-success fw-bold" for="component-file">อัพโหลดไฟล์แล้ว</label>
                        <div class="col-sm-8 mb-3">
                            <a href="{{route('borrower.upload.document.preview.file',['borrower_child_document_id' => $child_document->borrower_child_document->id])}}" target="_blank" rel="noopener noreferrer" class="btn btn-success w-100">คลิกเพื่อดูไฟล์ที่อัพโหลด</a>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <button type="button" class="btn btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#editModal-{{$child_document->id}}" ><i class="bi bi-pencil"></i> แก้ไข</button>
                        </div>
                    </div>
                @endif

                @if($child_document['comments'] != null)
                    @if($child_document->borrower_child_document->status == 'rejected')
                        <div class="row col-md-12 mx-0 px-0">
                            <label class="col-sm-2 col-form-label text-danger" for="component-file">ดำเนินการแก้ไขโดยด่วนที่สุด</label>
                            <div class="col-sm-10">
                                <ul class="list-group">
                                    @foreach ($child_document['comments'] as $comment)
                                        <li class="list-group-item list-group-item-danger">- {{$comment}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @elseif($child_document->borrower_child_document->status == 'response-reject')
                        <div class="row col-md-12 mx-0 px-0">
                            <label class="col-sm-2 col-form-label text-warning" for="component-file">แก้ไขแล้ว</label>
                            <div class="col-sm-10">
                                <ul class="list-group">
                                    @foreach ($child_document['comments'] as $comment)
                                        <li class="list-group-item list-group-item-warning">- {{$comment}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </form>

            {{-- edit modal --}}
            <div class="modal fade" id="editModal-{{$child_document->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">แก้ไขไฟล์ {{$child_document->child_document_title}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-form-{{$child_document->id}}" action="{{route('borrower.edit.document',['document_id' => $document->id, 'child_document_id' => $child_document->id])}}" method="POST" enctype="multipart/form-data" class="row mx-0">
                                @csrf
                                @method('PUT')
                                @if($child_document->need_document_code)
                                    @if(!isset($child_document->borrower_child_document))
                                    <div class="col-md-12 row mb-4 mx-0 px-0">
                                        <label for="document-code-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">รหัสเอกสาร 4 ตัวท้าย</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="document-code-{{$child_document->id}}" name="document_code" required
                                            />
                                            <div class="invalid-feedback">
                                                กรุณากรอกรหัสเอกสาร
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-md-12 row mb-4 mx-0 px-0">
                                        <label for="document-code-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">หัสเอกสาร 4 ตัวท้าย</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="document-code-{{$child_document->id}}" name="document_code"
                                                @required($child_document->need_loan_balance) 
                                                value="{{$child_document->borrower_child_document->document_code}}">
                                            <div class="invalid-feedback">
                                                กรุณากรอกรหัสเอกสาร
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @if($child_document->need_loan_balance)
                                    @if(!isset($child_document->borrower_child_document))
                                        <div class="col-md-12 row mb-3 mx-0 px-0">
                                            <label for="edit-education-fee-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าเล่าเรียน</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="edit-education-fee-{{$child_document->id}}" name="education_fee" oninput="formatNumber(this)" >
                                                <div class="invalid-feedback">
                                                    กรุณากรอกค่าเล่าเรียน
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 row mb-3 mx-0 px-0">
                                            <label for="edit-living-exprenses{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าครองชีพรวม</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="edit-living-exprenses{{$child_document->id}}" name="living_exprenses" oninput="formatNumber(this)">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกค่าครองชีพรวม
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12 row mb-3 mx-0 px-0">
                                            <label for="edit-education-fee-{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าเล่าเรียน</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="edit-education-fee-{{$child_document->id}}" name="education_fee" oninput="formatNumber(this)" 
                                                    @required($child_document->need_loan_balance) 
                                                    value="{{number_format($child_document->borrower_child_document->education_fee)}}">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกค่าเล่าเรียน
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 row mb-3 mx-0 px-0">
                                            <label for="edit-living-exprenses{{$child_document->id}}" class="col-sm-2 col-form-label text-secondary">ค่าครองชีพรวม</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="edit-living-exprenses{{$child_document->id}}" name="living_exprenses" oninput="formatNumber(this)" 
                                                    @required($child_document->need_loan_balance) 
                                                    value="{{number_format($child_document->borrower_child_document->living_exprenses)}}">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกค่าครองชีพรวม
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="col-md-12 row mx-0 px-0">
                                    <label class="col-sm-2 col-form-label text-secondary" for="edit-file-{{$child_document->id}}" >เลือกไฟล์</label>
                                    <div class="col-sm-7 mb-3">
                                        <input class="form-control" type="file" name="document_file" id="edit-file-{{$child_document->id}}" accept=".pdf" onchange="validateFileSize(this.id, {{$child_document->id}}, 'edit')">
                                        <div class="invalid-feedback">
                                            กรุณาเลือกไฟล์
                                        </div>
                                        <div id="edit-invalid-file-{{$child_document->id}}" class="invalid-feedback">
                                            ขนาดไฟล์ต้องไม่เกิน 5mb
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <button id="edit-form-button-{{$child_document->id}}" type="button" class="btn btn-primary w-100" onclick="formValidate('edit-form-{{$child_document->id}}', this.id)" ><i class="bi bi-arrow-down"></i> บันทึก</button>
                                    </div>
                                </div>
                                @if($child_document->need_loan_balance)
                                    <div class="col-md-12 mx-0 px-0">
                                        <span class="text-warning"> หากแก้ไขเฉพาะ รหัสเอกสาร ค่าเล่าเรียน หรือ ค่าครองชีพ ไม่ต้องอัพโหลดไฟล์</span>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end edit smodal --}}
    
        </div>
    </div>
    @endforeach

    {{-- กิจกรรมจิตอาสา --}}
    @if($document->need_useful_activity)
    <div class="card mb-3">
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
                            <th scope="col-2" class="text-center">แก้ใข/ลบ</th>
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
                                    <a class="btn btn-danger" href="{{route('borrower.show.usefulactivity.file' ,['useful_activity_id' => Crypt::encryptString($useful_activity->id)])}}" rel="noopener noreferrer" target="_blank"><i class="bi bi-journal-bookmark" ></i></a>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a class="btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <button type="button" class="dropdown-item text-warning" onclick="openEditUsefulActivityModal({{$useful_activity}})">
                                                    แก้ใข <i class="bi bi-pencil"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                    ลบ <i class="bi bi-trash"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="delete-modalLabel">ลบกิจกรรม</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                คุณต้องการลบ <span class="text-danger">{{$useful_activity->activity_name}}</span> หรือไม่
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{route('borrower.delete.usefulactivity',['useful_activity_id' => $useful_activity->id])}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light">ลบกิจกรรมนี้</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่ลบ</button>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>
                            @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#add-activitiy-modal">
                                        <i class="bi bi-plus"></i> เพิ่มข้อมูล
                                    </button>

                                </div>
                            </td>
                            <td class="text-center">{{$borrower_useful_activities_hours_sum}}/{{$useful_activities_hours}}</td>
                            <td></td>
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
             <!-- add activitiy Modal -->
            <div class="modal fade" id="add-activitiy-modal" tabindex="-1" aria-labelledby="add-activitiy-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="add-activitiy-modalLabel">เพิ่มข้อมูลกิจกรรม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-useful-activity-form" action="{{route('borrower.store.usefulactivity',['document_id' => $document->id])}}" method="post" class="row" enctype="multipart/form-data">
                            @csrf

                            <div class="col-sm-12 mb-3">
                                <label class="form-label" for="activity_name">ชื่อโครงการ/ กิจกรรมที่เป็นประโยชน์ต่อสังคมหรือสาธารณะ</label>
                                <input class="form-control" type="text" name="activity_name" id="activity_name"  required >
                                <div class="invalid-feedback">
                                    กรุณากรอกชื่อโครงการ
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label class="form-label" for="activity_location">สถานที่ดำเนินโครงการ</label>
                                <input class="form-control" type="text" name="activity_location" id="activity_location" required >
                                <div class="invalid-feedback">
                                    กรุณากรอกสถานที่ดำเนินโครงการ
                                </div>
                            </div>
                            <div class="row col-sm-12 mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="start-date" class="form-label text-secondary">วันที่เริ่ม</label>
                                    <div class="input-group date" id="">
                                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                        <input type="text" name="start_date" id="start-date" class="form-control"
                                        placeholder="วว/ดด/ปปปป ชม" required />
                                        <div class="invalid-feedback">
                                            กรุณากรอกวันที่เริ่ม
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end-date" class="form-label text-secondary">ถึงวันที่</label>
                                    <div class="input-group date" id="">
                                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                        <input type="text" name="end_date" id="end-date" class="form-control"
                                        placeholder="วว/ดด/ปปปป ชม" required />
                                        <div class="invalid-feedback">
                                            กรุณากรอกถึงวันที่
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label class="form-label" for="hour_count">จำนวนชั่วโมงรวม</label>
                                <input class="form-control" type="number" name="hour_count" id="hour_count" required>
                                <div class="invalid-feedback">
                                    กรุณากรอกจำนวนชั่วโมงรวม
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label class="form-label" for="description">ลักษณะของกิจกรรม</label>
                                <input class="form-control" type="text" name="description" id="description" required>
                                <div class="invalid-feedback">
                                    กรุณากรอกลักษณะของกิจกรรม
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="add-useful-activity-file">แนบไฟล์หลักฐาน</label>
                                <input class="form-control" type="file" name="useful_activity_file" id="add-useful-activity-file" accept=".png, .jpg, .jpeg, .pdf" required onchange="validateUsefulActivityFileSize(this.id, 'add')">
                                <div class="invalid-feedback">
                                    กรุณาแนบไฟล์หลักฐาน
                                </div>
                                <div id="add-invalid-useful-activity-file" class="invalid-feedback">
                                    ขนาดไฟล์ต้องไม่เกิน 5mb
                                </div>
                            </div>
                        </form> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button id="add-useful-activity-button" type="button" class="btn btn-primary" onclick="formValidate('add-useful-activity-form', this.id)">บันทึก</button>
                    </div>
                </div>
                </div>
            </div>
            {{-- end add activitiy Modal --}}

            {{-- edit useful activity modal --}}
            <div class="modal fade" id="editUsefulActivity" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                    <div class="modal-content" id="editUsefulActivityContent">
                        
                    </div>
                </div>
            </div>
            {{-- end edit useful activity modal --}}
            @if(count($useful_activities_comments) != 0)
            <div class="row mx-0 px-0 mt-3">
                <label class="col-sm-2 m-0 p-0 col-form-label text-dark" for="component-file">ส่วนที่ต้องแก้ไข</label>
                <div class="col-sm-10 m-0 p-0">
                    <ul class="list-group">
                        @foreach ($useful_activities_comments as $comment)
                            <li class="list-group-item list-group-item-danger">- {{$comment}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
    {{-- end กิจกรรมจิตอาสา --}}

    <div class="card">
        <div class="card-body row mx-0 mt-3">
            <div class="col-md-4 mb-2 pt-2 fs-6 fw-bold">
                จำนวนเอกสารที่ต้องส่ง 
                @if ((int) $borrower_child_document_delivered_count >= (int) $child_document_required_count)
                    <span class="badge rounded-pill bg-success text-light">{{$borrower_child_document_delivered_count}}/{{$child_document_required_count}}</span>
                @else
                    <span class="badge rounded-pill bg-danger text-light">{{$borrower_child_document_delivered_count}}/{{$child_document_required_count}}</span>
                @endif
            </div>
            <div class="col-md-5 mb-2 pt-2 fs-6 fw-bold">
                @if($document->need_useful_activity)
                    จำนวนชั่วโมงกิจกรรมจิตอาสา 
                    @if ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours)
                        <span class="badge rounded-pill bg-success text-light">{{$borrower_useful_activities_hours_sum}}/{{$useful_activities_hours}}</span>
                    @else 
                        <span class="badge rounded-pill bg-danger text-light">{{$borrower_useful_activities_hours_sum}}/{{$useful_activities_hours}}</span>
                    @endif
                    
                @endif
            </div>
            <div class="col-md-3 col-sm-12">
                
                @if(((int) $borrower_child_document_delivered_count >= (int) $child_document_required_count) && ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours))
                    <a href="{{route('borrower.register.result',['document_id' => $document->id])}}"
                        id="submitUploadDocument" class="btn btn-primary w-100" onclick="disabledLinkButton(this.id)">
                        ถัดไป <i class="bi bi-arrow-right"></i>
                    </a>
                @elseif(!$document->need_useful_activity)
                    <a href="{{route('borrower.register.result',['document_id' => $document->id])}}"
                        id="submitUploadDocument" class="btn btn-primary w-100" onclick="disabledLinkButton(this.id)">
                        ถัดไป <i class="bi bi-arrow-right"></i>
                    </a>
                @else
                    <button type="button" class="btn btn-secondary w-100" disabled> ถัดไป <i class="bi bi-arrow-right"></i></button>
                @endif
            </div>
        </div>
    </div>

</section>
@endsection

@section('script')
<script>
    var document_id = @json($document->id);
    function openEditUsefulActivityModal(useful_activity){
        const modal = new bootstrap.Modal(document.getElementById('editUsefulActivity'));
        // console.log(useful_activity);
        const modalcontent = document.getElementById('editUsefulActivityContent');
        modalcontent.innerHTML = '';
        modalcontent.innerHTML = `
                <div class="modal-header">
                    <h5 class="modal-title" id="add-activitiy-modalLabel">แก้ใขข้อมูลกิจกรรม ${useful_activity.activity_name}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-useful-activity" action="{{route('borrower.edit.usefulactivity',['useful_activity_id' => 'PLACEHOLDER_USEFUL_ACTIVITY_ID'])}}" method="post" class="row" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-sm-12 mb-3">
                            <label class="form-label" for="edit_activity_name">ชื่อโครงการ/ กิจกรรมที่เป็นประโยชน์ต่อสังคมหรือสาธารณะ</label>
                            <input class="form-control" type="text" name="activity_name" id="edit_activity_name" value="${useful_activity.activity_name}" required>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label" for="edit_activity_location">สถานที่ดำเนินโครงการ</label>
                            <input class="form-control" type="text" name="activity_location" id="edit_activity_location" value="${useful_activity.activity_location}" required>
                        </div>
                        <div class="row col-sm-12 mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="start-date" class="form-label text-secondary">วันที่เริ่ม</label>
                                <div class="input-group date" id="">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input type="text" name="start_date" id="edit-start-date" class="form-control" value="${convertIsoToCustomFormat(useful_activity.start_date)}"
                                    placeholder="วว/ดด/ปปปป ชม" required />
                                    <div class="invalid-feedback">
                                        กรุณากรอกวันที่เริ่มต้น
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end-date" class="form-label text-secondary">ถึงวันที่</label>
                                <div class="input-group date" id="">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input type="text" name="end_date" id="edit-end-date" class="form-control" value="${convertIsoToCustomFormat(useful_activity.end_date)}"
                                    placeholder="วว/ดด/ปปปป ชม" required />
                                    <div class="invalid-feedback">
                                        กรุณากรอกวันที่สิ้นสุด
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label" for="edit_hour_count">จำนวนชั่วโมงรวม</label>
                            <input class="form-control" type="number" name="hour_count" id="edit_hour_count" value="${useful_activity.hour_count}" required>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label" for="edit_description">ลักษณะของกิจกรรม</label>
                            <input class="form-control" type="text" name="description" id="edit_description" value="${useful_activity.description}" required>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="edit-useful-activity-${useful_activity.id}">แนบไฟล์หลักฐาน</label>
                            <input class="form-control" type="file" name="useful_activity_file" id="edit-useful-activity-${useful_activity.id}" accept=".png, .jpg, .jpeg, .pdf" onchange="validateUsefulActivityFileSize(this.id, 'edit')">
                            <div id="edit-invalid-useful-activity-file" class="invalid-feedback">
                                ขนาดไฟล์ต้องไม่เกิน 5mb
                            </div>
                            <div>
                                <p class="text-warning">หากไม่ได้แก้ไขไฟล์ ไม่ต้องอัพโหลดไฟล์</p>
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button id="edit-useful-activity-button" type="button" class="btn btn-primary" onclick="formValidate('edit-useful-activity', this.id)">บันทึก</button>
                </div>
   
        `;
        modalcontent.innerHTML = modalcontent.innerHTML.replace('PLACEHOLDER_USEFUL_ACTIVITY_ID', useful_activity.id);;
        modal.show();

        $("#edit-start-date").datetimepicker({
            format: 'd-m-Y H:i', 
            timepicker: true, 
            yearOffset: 543, 
            closeOnDateSelect: true,
        });

        $("#edit-end-date").datetimepicker({
            format: 'd-m-Y H:i', 
            timepicker: true, 
            yearOffset: 543, 
            closeOnDateSelect: true,
        });
    }

    $("#start-date").datetimepicker({
        format: 'd-m-Y H:i', 
        timepicker: true, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });

    $("#end-date").datetimepicker({
        format: 'd-m-Y H:i', 
        timepicker: true, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });

    function convertIsoToCustomFormat(isoDate) {
        const date = new Date(isoDate);
        
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        return `${day}-${month}-${year} ${hours}:${minutes}`;
    }

    function formatNumber(input) {
        // ลบตัวอักษรที่ไม่ใช่ตัวเลขและคอมมา
        const digits = input.value.replace(/[^\d]/g, '');

        // แบ่งกลุ่มตัวเลขเป็นสามหลักจากขวาไปซ้ายและใส่คอมมา
        const formatted = digits.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ','
        );
        input.value = formatted;
    }

    async function formValidate(form_id, button_id = ''){
        var validate = await validateData(form_id);
        const submit_button = document.querySelector(`#${button_id}`);

        if (submit_button) submit_button.disabled = true;
        if(validate){
            var form = document.getElementById(form_id);
            form.submit();
        }else{
            if (submit_button) submit_button.disabled = false;
        }
    }

    async function validateData(form_id){
        var form = document.getElementById(form_id);
        var inputs = form.querySelectorAll('input[type="text"][required]');
        var numbers = form.querySelectorAll('input[type="number"][required]');
        var inputFile = form.querySelector('input[type="file"][required]');
        var validator = true;
        await inputs.forEach(input => {
            if(input.value == ''){
                validator = false;
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        await numbers.forEach(number => {
            if(number.value == ''){
                validator = false;
                var invalid_element = number.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = number.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        if(inputFile){
            if(inputFile.files.length == 0){
                validator = false;
                var invalid_element = inputFile.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = inputFile.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        }

        return validator;
    }

    function validateFileSize(input_id, child_document_id, type_input_button){
        var input_file = document.getElementById(input_id);
        var form_button = document.getElementById(type_input_button+'-form-button-'+child_document_id);
        var invalid_element = document.getElementById(type_input_button + '-invalid-file-' + child_document_id);
        var filesize_max = 5;
        file_size_mb = input_file.files[0].size / 1000000;
        if (file_size_mb > filesize_max){
            form_button.disabled = true;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else{
            form_button.disabled = false;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }
    }

    function validateUsefulActivityFileSize(input_id, type_input_button){
        let input_file = document.getElementById(input_id);
        var form_button = document.getElementById(type_input_button + '-useful-activity-button');
        var invalid_element = document.getElementById(type_input_button + '-invalid-useful-activity-file');

        let filesize_max = 5;
        file_size_mb = input_file.files[0].size / 1000000;
        if (file_size_mb > filesize_max){
            form_button.disabled = true;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else {
            form_button.disabled = false;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }
    }

    function disabledLinkButton(buttonId) {
        const submitButton = document.querySelector(`#${buttonId}`);
        submitButton.classList.add('disabled');
    }
</script>
@endsection
