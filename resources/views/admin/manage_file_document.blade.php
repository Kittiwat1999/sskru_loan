@extends('layout')
@section('title')
จัดการไฟล์
@endsection()
@section('content')
<div class="main-content">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">จัดการไฟล์ <u>{{$child_document->child_document_title}}</u></h5>
            {{-- ไฟล์สำหรับดาวน์โหลด --}}
            <section class="border border-secondary rounded p-2 mb-4">
                <h6 class="fw-bold mb-3">ไฟล์สำหรับให้ผู้กู้ยืมดาวน์โหลด</h6>
                @if(isset($child_document_file))
                    <div class="my2">
                        @if( $child_document_file->file_type == 'pdf')
                        <a href="{{route('admin.display.file',['file_path' => $child_document_file->file_path,'file_name' => $child_document_file->file_name])}}" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
                            <div class="row my-2 my-6">
                                <div class="col-md-12">
                                    <iframe  src="{{route('admin.display.file',['file_path' => $child_document_file->file_path,'file_name' => $child_document_file->file_name])}}" frameborder="0" class="w-100" height="500"></iframe>
                                </div>
                            </div>
                        @else
                            <div class="row my-6 mx-1  border border-2">
                                <div class="col-md-12">
                                    <img src="{{route('admin.display.file',['file_path' => $child_document_file->file_path,'file_name' => $child_document_file])}}" alt="" class="w-100">
                                </div>
                            </div>    
                            
                        @endif
                    </div>
                    <form action="{{route('admim.child.document.update.generatefile',['child_document_id' => $child_document->id])}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="checkbox" id="generate_file" name="generate_file" value="true" {{($child_document->generate_file) ? 'checked' : ''}}>
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
                                   ท่านต้องการลบไฟล์ <span class="text-danger">{{$child_document->child_document_title}}</span> หรือไม่
                                </div>
                                <div class="modal-footer">
                                    <form action="{{route('admin.delete.child.document.file',['child_document_file_id' => $child_document_file->id])}}" method="post">
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
                    <form action="{{route('admin.store.child.document.file',['child_document_id' => $child_document->id])}}" method="post" class="row" id="downloadFileForm" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-10 mb-3">
                            <div class="row">
                                <label for="child_documnet_file" class="col-sm-2 col-form-label">เลือกไฟล์</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="child_documnet_file" id="child_documnet_file" accept="jpg,pdf,jpeg,png" onchange="validateFileSize('downloadFileForm')">
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
            <section class="border border-secondary rounded p-2 mb-4">
                <h6 class="fw-bold mb-3">ไฟล์ตัวอย่าง</h6>
                @if(count($example_files) != 0)
                    <ul class="list-group mb-4">
                        @foreach($example_files as $example_file)
                        <li class="list-group-item d-flex justify-content-between">
                            <a href="{{route('admin.display.file',['file_path' => $example_file->file_path,'file_name' => $example_file->file_name])}}" target="_blank" class="mt-1" aria-current="true">
                                {{$example_file->original_name}}
                            </a>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#deleteExampleFileModal{{$example_file->id}}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                        {{-- delete example file modal --}}
                        <div class="modal fade" id="deleteExampleFileModal{{$example_file->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">ลบไฟล์</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ท่านต้องการลบไฟล์ <span class="text-danger">{{$example_file->original_name}}</span> หรือไม่
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{route('admin.delete.example.file',['example_file_id' => $example_file->id])}}" method="post">
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
                <form action="{{route('admin.store.example.file',['child_document_id'=>$child_document->id])}}" method="post" class="row" id="exampleFileForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-10 mb-3">
                        <div class="row mb-3">
                            <label for="example_file" class="col-sm-2 col-form-label">เลือกไฟล์</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="example_file" accept="jpg,pdf,jpeg,png" onchange="validateFileSize('exampleFileForm')">
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
                        <button type="button" class="btn btn-primary w-100 h-100" onclick="example_file_submit('exampleFileForm', this)">อัพโหลด</button>
                    </div>
                </form>
            </section>
            {{-- end ไฟล์ตัวอย่าง --}}
            {{-- ตัวอย่างคนอายุไม่ถึง 20 --}}
            <section class="border border-secondary rounded p-2">
                <h6 class="fw-bold mb-3">ไฟล์ตัวอย่างสำหรับผู้มีอายุต่ำกว่า 20 ปี</h6>
                @if(count($minors_example_files) != 0)
                    <ul class="list-group mb-4">
                        @foreach($minors_example_files as $minors_example_file)
                        <li class="list-group-item d-flex justify-content-between">
                            <a href="{{route('admin.display.file',['file_path' => $minors_example_file->file_path,'file_name' => $minors_example_file->file_name])}}" target="_blank" class="mt-1" aria-current="true">
                                {{$minors_example_file->original_name}}
                            </a>
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#deleteExampleFileModal{{$minors_example_file->id}}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </li>
                        {{-- delete example file modal --}}
                        <div class="modal fade" id="deleteExampleFileModal{{$minors_example_file->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">ลบไฟล์</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ท่านต้องการลบไฟล์ <span class="text-danger">{{$minors_example_file->original_name}}</span> หรือไม่
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{route('admin.delete.example.file',['example_file_id' => $minors_example_file->id])}}" method="post">
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
                <form action="{{route('admin.store.minors.example.file',['child_document_id'=>$child_document->id])}}" method="post" class="row" id="exampleFileMinorsFileForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-10 mb-3">
                        <div class="row mb-3">
                            <label for="example_file" class="col-sm-2 col-form-label">เลือกไฟล์</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="example_file" accept="jpg,pdf,jpeg,png" onchange="validateFileSize('exampleFileMinorsFileForm')">
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
                        <button type="button" class="btn btn-primary w-100 h-100" onclick="example_file_submit('exampleFileMinorsFileForm')">อัพโหลด</button>
                    </div>
                </form>
            </section>
        {{--end ตัวอย่างคนอายุไม่ถึง 20 --}}
        </div>
    </div>

    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">เลือกเอกสารแนบ</h5>
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-group">
                        @foreach($child_document_addons as $chile_document_addon)
                        <li class="list-group-item">{{$chile_document_addon->title}}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn btn-outline-primary  w-100" data-bs-toggle="modal" data-bs-target="#largeModal">
                        + เพิ่ม/แก้ใขเอกสารแนบ
                    </button>
                    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">เพิ่ม/แก้ใขเอกสารแนบ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admim.child.document.update.addon',['child_document_id' => $child_document->id])}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                        <ul class="list-group">
                                        @foreach($addon_documents as $addon_document)
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="addon-id-{{$addon_document->id}}" name="addons[]" value="{{$addon_document->id}}" {{(in_array($addon_document->id,$child_document_addon_id)) ? 'checked' : '' }}>
                                                    <label class="form-check-label text-dark" for="addon-id-{{$addon_document->id}}">
                                                        {{$addon_document->title}} <span class="text-secondary">{{($addon_document->for_minors) ? '(สำหรับผู้กู้อายุต่ำว่า 20 ปี)' : ''}}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    async function example_file_submit(formId, button){
        var formValidate = await validate_example_file(formId);
        if(formValidate){
            const form = document.getElementById(formId);
            form.submit();
        }
    }

    async function validate_example_file(formId){
        var exampleForm = document.getElementById(formId);
        var inputFile = exampleForm.querySelector('input[type="file"]');
        var inputDescription = exampleForm.querySelector('input[type="text"]');
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
        var inputFile = exampleForm.querySelector('#child_documnet_file');
        var inputDescription = exampleForm.querySelector('#description');
        var validator = true;

        if(inputFile.files.length == 0){
            validator = false;
            var invalidElement = inputFile.nextElementSibling;
            if(invalidElement)invalidElement.classList.add('d-inline');
        }else{
            var invalidElement = inputFile.nextElementSibling;
            if(invalidElement)invalidElement.classList.remove('d-inline');
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