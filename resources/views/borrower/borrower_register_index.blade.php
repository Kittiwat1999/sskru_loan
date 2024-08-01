@extends('layout')
@section('title')
ลงทะเบียนผู้กู้
@endsection
<style>
    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 40vh;
        text-align: center;
    }
    .btn {
        margin-top: 80px;
    }
</style>
@section('content')
<section class="section Editing d-flex flex-column align-items-center py-4">
    <div class="card col-md-7 mt-4">
        <div class="card-body pt-3">
                <span class="">ยังไม่ได้กรอกข้อมูล</span>
                <a href="{{ url('/borrower/borrower_register') }}" class="btn btn-primary w-50">ไปหน้ากรอกข้อมูล</a>
        </div>
    </div>
</section>
@endsection
