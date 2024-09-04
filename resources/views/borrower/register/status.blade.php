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
            @if($borrower_document['status'] == 'approved')
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="#" role="tab"><i class="bi bi-lock"></i>ประเภทผู้กู้ยืม</a>
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="#"><i class="bi bi-lock"></i>ส่งเอกสาร</a>
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>สรุปการส่งเอกสาร</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>ตรวจสอบเอกสารของระบบ</a>
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0 active" id="request-status-tab" href="{{route('borrower.register.status')}}"></i>สถานะคำร้อง</a>
                </li>
            </ul>
            @else
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 1)
                        <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="{{route('borrower.register.type')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 2)
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}"></i>ส่งเอกสาร</a>
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
                        <a class="nav-link text-dark text-center m-0 active" id="request-status-tab" href="{{route('borrower.register.status')}}"></i>สถานะคำร้อง</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="#"><i class="bi bi-lock"></i>สถานะคำร้อง</a>
                    @endif
                </li>
            </ul>
            @endif
        </div>
    </div>
    <div class="row d-flex flex-column align-items-center">
        <div class="card section dashboard col-md-8">
            <div class="card-body">
                <h5 class="card-title">สถานะการยื่นกู้</h5>
                <div class="activity">
    
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            <span class="badge bg-success w-100">เสร็จสิ้น</span>
                        </div>
                        <div class="activite-label"></div>
                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                        <div class="activity-content">
                            ผู้กู้ส่งเอกสาร
                        </div>
                    </div><!-- End activity item-->
                    @if($document['need_teacher_comment'])
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            @if($borrower_document['teacher_status'] == 'wait-approve')
                                <span class="badge bg-secondary w-100">รอดำเนินการ</span>
                            @elseif($borrower_document['teacher_status'] == 'rejected')
                                <span class="badge bg-danger w-100">ไม่อนุมัติ</span>
                            @elseif($borrower_document['teacher_status'] == 'response-reject')
                                <span class="badge bg-warning w-100">ส่งแก้ไขเอกสาร</span>
                            @elseif($borrower_document['teacher_status'] == 'approved')
                                <span class="badge bg-success w-100">อนุมัติแล้ว</span>
                            @endif
                        </div>
                        <div class="activite-label"></div>
                        <i class="bi bi-circle-fill activity-badge align-self-start {{($borrower_document['teacher_status'] == 'approved') ? 'text-success' : 'text-secondary'}}"></i>
                        <div class="activity-content">
                            อาจารย์ที่ปรึกษาให้ความเห็น
                            @if($borrower_document['teacher_status'] == 'response-reject' || $borrower_document['teacher_status'] == 'rejected')
                                <br><span class="text-danger">{{$borrower_document['teacher_reject']}}</span>
                            @endif
                        </div>
                    </div><!-- End activity item-->
                    @endif
    
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            @if($borrower_document['status'] == 'wait-approve')
                                <span class="badge bg-secondary w-100">รอดำเนินการ</span>
                            @elseif($borrower_document['status'] == 'rejected')
                                <span class="badge bg-danger w-100">ไม่อนุมัติ</span>
                            @elseif($borrower_document['status'] == 'response-reject')
                                <span class="badge bg-warning w-100">ส่งแก้ไขเอกสาร</span>
                            @elseif($borrower_document['status'] == 'approved')
                                <span class="badge bg-success w-100">อนุมัติแล้ว</span>
                            @else
                                <span class="badge bg-secondary w-100">รอดำเนินการ</span>
                            @endif
                        </div>
                        <div class="activite-label"></div>
                        <i class="bi bi-circle-fill activity-badge align-self-start {{($borrower_document['status'] == 'approved') ? 'text-success' : 'text-secondary'}}"></i>
                        <div class="activity-content">
                            ฝ่ายทุนตรวจเอกสาร
                            @if(count($child_documents) != 0)
                                <br><span class="text-danger">ต้องแก้ไขเอกสารบางรายการ</span>
                            @endif
                        </div>
                    </div><!-- End activity item-->
    
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            @if($borrower_document['status'] == 'approved')
                            <span class="badge bg-success w-100">เสร็จสิ้น</span>
                            @else
                            <span class="badge bg-secondary w-100">อยู่ระหว่างดําเนินการ</span>
                            @endif
                        </div>
                        <div class="activite-label"></div>
                        <i class="bi bi-circle-fill activity-badge align-self-start {{($borrower_document['status'] == 'approved') ? 'text-success' : 'text-secondary'}}"></i>
                        <div class="activity-content">
                            ยื่นกู้เสร็จสิ้น
                        </div>
                    </div><!-- End activity item-->
                </div>
            </div>
        </div>

        @if(count($child_documents) != 0 || count($useful_activities_comments) != 0)
        <div class="card col-md-8 m-0 p-0">
            <div class="card-body">
                <h6 class="card-title">รายการเอกสารต้องแก้ไข</h6>
                <ul class="list-group">
                    @foreach($child_documents as $child_document)
                        <li class="list-group-item">
                            <div>
                                <span>{{$child_document['title']}}</span><br/>
                                @foreach ($child_document['comments'] as $comments)
                                    <small class="text-danger px-2">- {{$comments}}</small><br/>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                    @if($document['need_useful_activity'] && $useful_activities_comments != null)
                    <li class="list-group-item">
                        <div>
                            <span>บันทึกกิจกรรมจิตอาสา</span><br/>
                                @foreach ($useful_activities_comments as $comments)
                                    <small class="text-danger px-2">- {{$comments}}</small><br/>
                                @endforeach
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        @endif

    </div>

</section>
@endsection
