@extends('layout')
@section('title')
ยื่นกู้
@endsection
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

    /* .status{
        min-width: 100px; 
        width: 100px; 
        height: 20px; 
        border-radius: 10px !important;
    } */
</style>
@section('content')
<section >
    <div class="card mb-3">
        <div class="card-body pb-0 mb-0">
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="{{route('borrower.register')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0 active" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}" >ส่งเอกสาร</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-secondary text-center m-0" id="check-documents-tab" href="{{route('borrower.register.result')}}" @disabled(false)>ตรวจสอบเอกสาร</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-secondary text-center m-0" id="request-status-tab" href="{{route('borrower.register.status')}}" @disabled(false)>สถานะคำร้อง</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Title</h5>
            <div class="row">
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ไฟล์ประกอบไปด้วย</label>
                    <div class="col-sm-10">
                        <ul class="list-group list-borderless">
                            <li class="list-group-item">
                                - Title
                            </li>
                            <li class="list-group-item">
                                - Addon File
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ตัวอย่างเอกสาร</label>
                    <div class="col-sm-10">
                        <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger w-100">คลิกเพื่อดูไฟล์ตัวอย่าง</a>
                    </div>
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" class="row">
                @csrf
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="name" >เลือกไฟล์</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="file" name="name" id="name" accept=".jpg, .jpeg, .png, .pdf" required >
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <span class="mt-4"><b>ส่งเอกสารแล้ว 0/10 </b></span>
                <button type="button" class="btn btn-primary w-25 mt-3" onclick="nextPage('check-documents-tab')">ถัดไป</button>
            </div>
        </div>
    </div>
</section>
@endsection
