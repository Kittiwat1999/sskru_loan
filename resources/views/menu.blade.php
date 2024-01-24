@extends('layout')
@section('content')
    <section>
        <div class="row">

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">กรอกข้อมูลผู้กู้</h5>
    
                      <span class="btn btn-light">
                        <i class="bi bi-pen px-2 text-secondary"></i> <a href="{{url('/borrower/information')}}">กรอกข้อมูลผู้กู้</a>
                      </span>
    
                    </div>
                  </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">รายการเอกสารที่ส่ง</h5>
    
                      <span class="btn btn-light">
                        <i class="bi bi-card-list px-2 text-secondary"></i> <a href="{{url('/borrower/index')}}">เอกสารที่ส่งแล้ว</a>
                      </span>
    
                    </div>
                  </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">ยืนกู้</h5>
        
                      <span class="btn btn-light">
                        <i class="bi bi-file-earmark-plus px-2 text-secondary"></i> <a href="{{url('/borrower/new_loan_request')}}">ยื่นกู้รายใหม่</a>
                      </span>
    
                      <span class="btn btn-light">
                        <i class="bi bi-file-arrow-up px-2 text-secondary"></i> <a href="{{url('/borrower/loan_request')}}">ยื่นกู้รายเก่าเลื่อนชั้นปี</a>
                      </span>
    
                      <span class="btn btn-light">
                        <i class="bi bi-file-earmark-diff px-2 text-secondary"></i> <a href="{{url('/borrower/loan_over_course')}}">ยื่นกู้เกินหลักสูตร</a>
                      </span>
    
                    </div>
                  </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">ส่งเอกสาร</h5>
        
                      <span class="btn btn-light">
                        <i class="bi bi-file-break px-2 text-secondary"></i> <a href="{{url('/borrower/send_contract')}}" class="st">ส่งสัญญาและแบบยืนยัน</a>
                      </span>
    
                      <span class="btn btn-light">
                        <i class="bi bi-file-check px-2 text-secondary"></i> <a href="{{url('/borrower/send_confirmation_form')}}" class="st">ส่งแบบยืนยัน</a>
                      </span>
    
                    </div>
                  </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">ขอแก้ใขข้อมูล</h5>
        
                      <span class="btn btn-light">
                        <i class="bi bi-pencil-square px-2 text-secondary"></i> <a href="{{url('/borrower/edit_borrower_information')}}" class="st">ขอแก้ใขข้อมูล</a>
                      </span>
                    </div>
                  </div>
            </div>
    </section>
@endsection