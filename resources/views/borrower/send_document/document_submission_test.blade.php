@extends('layout')
@section('title')
สรุปการส่งเอกสาร
@endsection
@section('content')
<section class="">
    <div class="card">
        <div class="card-body">
            <h5 class="py-2 fs-5">สรุปการส่งเอกสาร</h5>
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <ul class="list-group list-borderless">
                            <li class="list-group-item list-group-item-success d-flex justify-content-between">
                                <span>- child_document_title</span>
                                <i class="bi bi-check-square-fill"></i>
                            </li>
                            <li class="list-group-item">
                                - addon_document-title
                            </li>
                            <li class="list-group-item">
                                - addon_document-title
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <button type="button" class="btn btn-outline-dark w-100"><i class="bi bi-arrow-left"></i> ย้อนกลับ </button>
                        {{-- {{route('borrower.upload.document.page',['document_id'=>$document->id])}} --}}
                    </div>
                    <div class="col-md-7 col-sm-12 mb-3"></div>
                    <div class="col-md-3 col-sm-6">
                        <button type="button" class="btn btn-primary w-100"> ส่งเอกสาร</button>
                    </div>
                </div>
                    {{-- <span class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-7">สำเนาบัตรประชาชน</div>
                        <div class="col-md-4 text-success">ตรวจแล้ว &nbsp; <img src="{{ asset('assets/img/doc/pngwing.com.png') }}" alt="" height="20px"></div>
                    </span>
                    <br>
                    <span class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-7">รายงานผลการเรียน</div>
                        <div class="col-md-4 text-success">ตรวจแล้ว &nbsp; <img src="{{ asset('assets/img/doc/pngwing.com.png') }}" alt="" height="20px"></div>
                    </span>
                    <br>
                    <span class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-7">แบบยืนยันเบิกเงินกู้ยืม</div>
                        <div class="col-md-4 text-success">ตรวจแล้ว &nbsp; <img src="{{ asset('assets/img/doc/pngwing.com.png') }}" alt="" height="20px"></div>
                    </span> --}}
            </div>
        </div>
    </div>
</section>
@endsection
