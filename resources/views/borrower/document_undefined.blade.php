@extends('layout')
@section('title')
ยื่นกู้รายใหม่
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
    <div class="card col-md-7 col-12 mt-4">
        <div class="card-body pt-3">
                <span class="">ระบบยังไม่เปิดให้ดำเนินการยื่นกู้</span>
                <a href="{{ url('/borrower/borrower_document/index') }}" class="btn btn-primary w-50">กลับหน้าหลัก</a>
        </div>
    </div>
</section>
@endsection
