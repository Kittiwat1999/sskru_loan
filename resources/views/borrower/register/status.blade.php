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
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="{{route('borrower.register')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if($borrower_register_type == null)
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="#"><i class="bi bi-lock"></i>ส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}"></i>ส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if(((int) $borrower_child_document_delivered_count >= (int) $child_document_required_count) && ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours))
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.result')}}"></i>ตรวจสอบเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>ตรวจสอบเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if($have_register_document && $delivered_borrower_document)
                        <a class="nav-link text-dark text-center m-0 active" id="request-status-tab" href="{{route('borrower.register.status')}}"></i>สถานะคำร้อง</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="#"><i class="bi bi-lock"></i>สถานะคำร้อง</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <div class="row d-flex flex-column align-items-center">
        <div class="card section dashboard col-md-6">
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
    
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            <span class="badge bg-warning w-100">รอดำเนินการ</span>
                        </div>
                        <div class="activite-label"></div>
                        <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                        <div class="activity-content">
                            อาจารย์ที่ปรึกษาให้ความเห็น
                        </div>
                    </div><!-- End activity item-->
    
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            <span class="badge bg-warning w-100">รอดำเนินการ</span>
                        </div>
                        <div class="activite-label"></div>
                        <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                        <div class="activity-content">
                            ฝ่ายทุนตรวจเอกสาร
                        </div>
                    </div><!-- End activity item-->
    
                    <div class="activity-item d-flex">
                        <div class="col-2 pt-1">
                            <span class="badge bg-warning w-100">รอดำเนินการ</span>
                        </div>
                        <div class="activite-label"></div>
                        <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                        <div class="activity-content">
                            ยื่นกู้เสร็จสิ้น
                        </div>
                    </div><!-- End activity item-->
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
