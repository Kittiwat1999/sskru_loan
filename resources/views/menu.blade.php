@extends('layout')
@section('content')
    <section>
        <div class="row" align="center">

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-pen px-2 text-secondary"></i> <a href="{{url('/borrower/information')}}" class="st">กรอกข้อมูลผู้กู้</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-card-list px-2 text-secondary"></i> <a href="{{url('/borrower/index')}}" class="st">เอกสารที่ส่งแล้ว</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-file-earmark-plus px-2 text-secondary"></i> <a href="{{url('/borrower/new_loan_request')}}" class="st">ยื่นกู้รายใหม่</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-file-arrow-up px-2 text-secondary"></i> <a href="{{url('/borrower/loan_request')}}" class="st">ยื่นกู้รายเก่าเลื่อนชั้นปี</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-file-earmark-diff px-2 text-secondary"></i> <a href="{{url('/borrower/loan_over_course')}}" class="st">ยื่นกู้เกินหลักสูตร</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-file-break px-2 text-secondary"></i> <a href="{{url('/borrower/send_contract')}}" class="st">ส่งสัญญาและแบบยืนยัน</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-file-check px-2 text-secondary"></i> <a href="{{url('/borrower/send_confirmation_form')}}" class="st">ส่งแบบยืนยัน</a>
                </div>
            </div>

            <div class="col-sm-12 pb-2">
                <div class="col-sm-3 border bg-white rounded-3 py-2 text-start">
                    <i class="bi bi-pencil-square px-2 text-secondary"></i> <a href="{{url('/borrower/edit_borrower_information')}}" class="st">ขอแก้ใขข้อมูล</a>
                </div>
            </div>

        </div>
    </section>
@endsection