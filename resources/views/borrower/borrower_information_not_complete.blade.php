@extends('layout')
@section('title')
ท่านยังไม่ได้กรอกข้อมูล
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
                <span class="">ท่านยังไม่ได้กรอกข้อมูล หรือกรอกข้อมูลยังไม่ครบ</span>
                <a href="{{ url('/borrower/information/information_list') }}" class="btn btn-primary w-50">ไปหน้ากรอกข้อมูล</a>
        </div>
    </div>
</section>
@endsection
