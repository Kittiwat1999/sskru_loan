@extends('layout')
@section('title')
จัดการไฟล์
@endsection()
@section('content')
<div class="main-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ไฟล์สำหรับให้ผู้กู้ดาวน์โหลด</h5>
            <form action="" method="post" class="">
                <div class="row mb-3">
                    <label for="file_download" class="col-sm-2 col-form-label">ไฟล์สำหรับดาวน์โหลด</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="file_download" id="file_download" accept="jpg,pdf,jpeg,png">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="file_download" class="col-sm-2 col-form-label">ไฟล์สำหรับดาวน์โหลด</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="file_download" id="file_download" accept="jpg,pdf,jpeg,png">
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary w-25">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection