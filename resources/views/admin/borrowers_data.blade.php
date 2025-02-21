@extends('layout')
@section('title','อัพเดตข้อมูลผู้กู้')
@section('content')
    <section class="section dashboard">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">ดาวน์โหลดข้อมูลผู้กู้</h5>
                <form action="{{route('admin.borrowers_data.export')}}" method="post" class="row" id="downloadBorrowerData">
                    @csrf
                    <div class="col-md-10">
                        <div class="row">
                            <label for="addon_document_file" class="col-sm-3 col-form-label">ดาวน์โหลดข้อมูลผู้กู้รหัส</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="begin_year">
                                <div class="invalid-feedback">
                                    กรอกหรัดขึ้นต้นนักศึกษา
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger w-100 h-100" onclick="downloadDataSubmit('downloadBorrowerData')">ดาวน์โหลด</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">อัพเดตข้อมูลผู้กู้</h5>
                <form action="{{route('admin.borrowers_data.import')}}" method="post" class="row" id="updateBorrowerData" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-10">
                        <div class="row">
                            <label for="addon_document_file" class="col-sm-2 col-form-label">เลือกไฟล์</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="borrower_csv" accept=".csv" onchange="validateFileSize('updateBorrowerData')">
                                <div class="invalid-feedback">
                                    กรุณาอัพโหลดไฟล์
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary w-100 h-100" onclick="updateDataSubmit('updateBorrowerData')">อัพโหลด</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
    async function downloadDataSubmit(formId){
        const form = document.getElementById(formId);
        const submitButton = form.querySelector('button');
        submitButton.disabled = true;
        var formValidate = await validateBeginYear(formId);
        
        if(formValidate){
            form.submit();
        }

        submitButton.disabled = false;
    }

    async function validateBeginYear(formId){
        const form = document.getElementById(formId);
        const inputText = form.querySelector('input[type="number"]');
        var validator = true;

        if(inputText.value == ''){
            validator = false;
            var invalid_element = inputText.nextElementSibling;
            if(invalid_element)
            {
                invalid_element.classList.add('d-inline');
            }
        }else{
            var invalid_element = inputText.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

        return validator;
    }

    async function updateDataSubmit(formId){
        const form = document.getElementById(formId);
        const submitButton = form.querySelector('button');
        submitButton.disabled = true;
        var formValidate = await validateFile(formId);
        
        if(formValidate){
            form.submit();
        }
        submitButton.disabled = false;
    }

    async function validateFile(formId){
        const form = document.getElementById(formId);
        const inputFile = form.querySelector('input[type="file"]');
        var validator = true;

        if(inputFile.files.length == 0){
            validator = false;
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element)
            {
                invalid_element.innerText = 'กรุณาอัพโหลดไฟล์';
                invalid_element.classList.add('d-inline');
            }
        }else{
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

        return validator;
    }

    function validateFileSize(formId){
        const form = document.getElementById(formId);
        const inputFile = form.querySelector('input[type="file"]');
        const inputButton = form.querySelector('button');
        const invalidElemnt = inputFile.nextElementSibling;
        const filesize_max = 5;

        var file_size_mb = inputFile.files[0].size / 1000000;
        if (file_size_mb > filesize_max){
            inputButton.disabled = true;
            if(invalidElemnt){
                invalidElemnt.innerText = 'ขนาดไฟล์ต้องไม่เกิน 5mb'
                invalidElemnt.classList.add('d-inline');
            }
        }else {
            inputButton.disabled = false;
            if(invalidElemnt)invalidElemnt.classList.remove('d-inline');
        }
    }
</script>
@endsection

