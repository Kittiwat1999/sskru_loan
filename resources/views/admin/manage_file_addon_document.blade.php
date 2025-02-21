@extends('layout')
@section('title')
จัดการเอกสารแนบ
@endsection
@section('content')
<div class="main-content">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">จัดการไฟล์แนบ <u>{{$addon_document->title}}</u></h5>
            {{-- ไฟล์สำหรับดาวน์โหลด --}}
            <section class="border-bottom border-1 border-secondary p-2 mb-4">
                <h6 class="fw-bold mb-3">ไฟล์สำหรับให้ผู้กู้ยืมดาวน์โหลด</h6>
                @if(isset($addon_document_file))
                    <div class="my2">
                        @if( $addon_document_file->file_type == 'pdf')
                        <a href="{{route('admin.display.file',['file_path' => $addon_document_file->file_path,'file_name' => $addon_document_file->file_name])}}" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
                            <div class="row my-2 my-6">
                                <div class="col-md-12">
                                    <iframe  src="{{route('admin.display.file',['file_path' => $addon_document_file->file_path,'file_name' => $addon_document_file->file_name])}}" frameborder="0" class="w-100" height="500"></iframe>
                                </div>
                            </div>
                        @else
                            <div class="row my-6 mx-1 border border-2">
                                <div class="col-md-12">
                                    <img src="{{route('admin.display.file',['file_path' => $addon_document_file->file_path,'file_name' => $addon_document_file])}}" alt="" class="w-100">
                                </div>
                            </div>    
                            
                        @endif
                    </div>
                    <form action="{{route('admim.addon.document.update.generatefile',['addon_document_id' => $addon_document->id])}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="generate_file" name="generate_file" value="true" {{($addon_document->generate_file) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="generate_file">
                                        ระบบช่วยกรอกเอกสาร
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex flex-row">
                                <button type="button" class="btn btn-light w-50" data-bs-toggle="modal" data-bs-target="#deletefileModal">
                                    ลบไฟล์
                                </button>
                                <button type="submit" class="btn btn-primary w-50">บันทึก</button>
                            </div>
                        </div>
                    </form>
                    {{-- delete file modal --}}
                    <div class="modal fade" id="deletefileModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ลบไฟล์</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   ท่านต้องการลบไฟล์ <span class="text-danger">{{$addon_document->title}}</span> หรือไม่
                                </div>
                                <div class="modal-footer">
                                    <form action="{{route('admin.delete.addon.document.file',['addon_document_file_id' => $addon_document_file->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light">ลบไฟล์นี้</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end delete file modal --}}
                @else
                    <form action="{{route('admin.store.addon.document.file',['addon_document_id' => $addon_document->id])}}" method="post" class="row" id="downloadFileForm" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10 mb-3">
                            <div class="row">
                                <label for="addon_document_file" class="col-sm-2 col-form-label">เลือกไฟล์</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="addon_document_file" id="addon_document_file" accept="jpg,pdf,jpeg,png" onchange="validateFileSize('downloadFileForm')">
                                    <div class="invalid-feedback">
                                        กรุณาอัพโหลดไฟล์
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-primary w-100 h-100" onclick="download_file_submit('downloadFileForm')">อัพโหลด</button>
                        </div>
                    </form>
                @endif
            </section>
            {{-- end ไฟล์สำหรับดาวน์โหลด --}}

            {{-- ไฟล์ตัวอย่าง --}}
            <section class="border-bottom border-1 border-secondary p-2 mb-4">
                <h6 class="fw-bold mb-3">ไฟล์ตัวอย่าง</h6>
                @if(count($addon_example_files) != 0)
                    <ul class="list-group mb-4">
                        @foreach($addon_example_files as $addon_example_file)
                        <li class="list-group-item d-flex justify-content-between">
                            <a href="{{route('admin.display.file',['file_path' => $addon_example_file->file_path,'file_name' => $addon_example_file->file_name])}}" target="_blank" class="mt-1" aria-current="true">
                                {{$addon_example_file->original_name}}
                            </a>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#deleteExampleFileModal{{$addon_example_file->id}}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                        {{-- delete example file modal --}}
                        <div class="modal fade" id="deleteExampleFileModal{{$addon_example_file->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">ลบไฟล์</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ท่านต้องการลบไฟล์ <span class="text-danger">{{$addon_example_file->original_name}}</span> หรือไม่
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{route('admin.delete.example.addon.file',['example_addon_file_id' => $addon_example_file->id])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light">ลบไฟล์นี้</button>
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end delete example file modal --}}
                        @endforeach
                    </ul>
                @endif
                <form action="{{route('admin.store.example.addon.file',['addon_document_id'=>$addon_document->id])}}" method="post" class="row" id="exampleFileForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-10 mb-3">
                        <div class="row mb-3">
                            <label for="addon_example_file" class="col-sm-2 col-form-label">เลือกไฟล์</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="addon_example_file" id="addon_example_file" accept="jpg,pdf,jpeg,png" onchange="validateFileSize('exampleFileForm')">
                                <div class="invalid-feedback">
                                    กรุณาอัพโหลดไฟล์
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="description" class="col-sm-2 col-form-label">คำอธิบาย</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" id="description" class="form-control">
                                <div class="invalid-feedback">
                                    กรุณากรอกคำอธิบาย
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-primary w-100 h-100" onclick="example_file_submit('exampleFileForm')">อัพโหลด</button>
                    </div>
                </form>
            </section>
            {{-- end ไฟล์ตัวอย่าง --}}
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
        var inputFile = exampleForm.querySelector('#addon_example_file');
        var inputDescription = exampleForm.querySelector('#description');
        var validator = true;

        if(inputFile.files.length == 0){
            validator = false;
            var invalid_element = inputFile.nextElementSibling;
            if(invalid_element){
                invalid_element.innerText = 'กรุณาอัพโหลดไฟล์';
                invalid_element.classList.add('d-inline');
            }
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
        var inputFile = exampleForm.querySelector('#addon_document_file');
        var inputDescription = exampleForm.querySelector('#description');
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

        file_size_mb = inputFile.files[0].size / 1000000;
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
