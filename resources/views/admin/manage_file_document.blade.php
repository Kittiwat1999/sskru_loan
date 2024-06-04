@extends('layout')
@section('title')
จัดการไฟล์
@endsection()
@section('content')
<div class="main-content">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">ไฟล์<u>{{$child_document->child_document_title}}</u>สำหรับให้ผู้กู้ยืมดาวน์โหลด</h5>
            <form action="" method="post" class="" id="downloadFileForm">
                @csrf
                <div class="row mb-3">
                    <label for="file_download" class="col-sm-2 col-form-label">อัพโหลดไฟล์</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="file_download" id="file_download" accept="jpg,pdf,jpeg,png">
                        <div class="invalid-feedback">
                            กรุณาอัพโหลดไฟล์
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="system_generate" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="system_generate">
                            <label class="form-check-label" for="system_generate">
                                ระบบช่วยกรอกเอกสาร
                            </label>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary w-25" onclick="download_file_submit('downloadFileForm')">บันทึก</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ไฟล์ตัวอย่างของ<u>{{$child_document->child_document_title}}</u></h5>
            <form action="" method="post" class="" id="exampleFileForm">
                @csrf
                <div class="row mb-3">
                    <label for="file_example" class="col-sm-2 col-form-label">อัพโหลดไฟล์</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="file_example" id="file_example" accept="jpg,pdf,jpeg,png">
                        <div class="invalid-feedback">
                            กรุณาอัพโหลดไฟล์
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">คำอธิบาย</label>
                    <div class="col-sm-10">
                        <input type="text" name="description" id="description" class="form-control">
                        <div class="invalid-feedback">
                             กรุณากรอกคำอธิบาย
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary w-25" onclick="example_file_submit('exampleFileForm')">อัพโหลด</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ไฟล์ตัวอย่างสำหรับผู้มีอายุต่ำกว่า 20 ปีของ<u>{{$child_document->child_document_title}}</u></h5>
            <form action="" method="post" class="" id="exampleFileMinorsFileForm">
                @csrf
                <div class="row mb-3">
                    <label for="file_example" class="col-sm-2 col-form-label">อัพโหลดไฟล์</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="file_example" id="file_example" accept="jpg,pdf,jpeg,png">
                        <div class="invalid-feedback">
                            กรุณาอัพโหลดไฟล์
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">คำอธิบาย</label>
                    <div class="col-sm-10">
                        <input type="text" name="description" id="description" class="form-control">
                        <div class="invalid-feedback">
                            กรุณากรอกคำอธิบาย
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary w-25" onclick="example_file_submit('exampleFileMinorsFileForm')">อัพโหลด</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    async function example_file_submit(formId){
        var formValidate = await validate_example_file(formId);
        if(formValidate){
            const form = document.getElementById(formId);
            form.submit();
        }
    }

    async function validate_example_file(formId){
        var exampleForm = document.getElementById(formId);
        var inputFile = exampleForm.querySelector('#file_example');
        var inputDescription = exampleForm.querySelector('#description');
        var validator = true;

        if(inputFile.files.length == 0){
            validator = false;
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else{
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

        if(inputDescription.value == ''){
            validator = false;
            var invalid_element = inputDescription.nextElementSibling;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else{
            var invalid_element = inputDescription.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

        return validator;
    }

    async function download_file_submit(formId){
        var formValidate = await validate_download_file(formId);
        if(formValidate){
            const form = document.getElementById(formId);
            form.submit();
        }
    }

    async function validate_download_file(formId){
        var exampleForm = document.getElementById(formId);
        var inputFile = exampleForm.querySelector('#file_download');
        var inputDescription = exampleForm.querySelector('#description');
        var validator = true;

        if(inputFile.files.length == 0){
            validator = false;
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else{
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

        return validator;
    }
</script>
@endsection