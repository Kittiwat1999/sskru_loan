@extends('layout')
@section('title')
สรุปการส่งเอกสาร
@endsection
@section('content')
<section class="section Editing min-vh-100 d-flex flex-column align-items-center py-4">
    <div class="card col-md-6">
        <div class="card-body pt-3">
            <h5 class="py-2 fs-5">สรุปการส่งเอกสาร</h5>
            <div>
                    <span class="row">
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
                    </span>
            </div>
            <div class="text-end pt-3">
                <button type="button" class="btn btn-primary">ถัดไป</button>
            </div>
        </div>
    </div>
</section>
@endsection
