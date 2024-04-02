@extends('layout')
@section('title')
แก้ใขเอกสาร
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการหนังสือ</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>หนังสือ</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doc_types as $doc_type)
                            <tr>
                                <td class="text-center fw-bold">{{$loop->index+1}}</td>
                                <td>{{$doc_type->doctype_title}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary w-50" data-bs-toggle="modal" data-bs-target="#editDocTypeModal{{$doc_type->id}}" ><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light w-50" data-bs-toggle="modal" data-bs-target="#deleteDocTypeModal{{$doc_type->id}}" ><i class="bi bi-trash"></i></button>
                                    </div>

                                    <!-- edit Modal -->
                                    <div class="modal fade" id="editDocTypeModal{{$doc_type->id}}" tabindex="-1" aria-labelledby="editDocTypeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDocTypeModalLabel">แก้ไขหนังสือ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row" action="{{route('admin.manage.documents.editdoctype',['doc_type_id' => $doc_type->id])}}" method="post" id="editDocTypeForm{{$doc_type->id}}">
                                                        @csrf
                                                        <div class="col-12">
                                                            <label for="doctype_title" class="form-label">ชื่อหนังสือ</label>
                                                            <input type="text" class="form-control need-custom-validate" id="doctype_title" name="doctype_title" value="{{$doc_type->doctype_title}}">
                                                            <div class="invalid-feedback">
                                                                กรุณากรอกชื่อหนังสือ
                                                            </div>
                                                        </div>
                                                        </form> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                    <button type="button" class="btn btn-primary" onclick="doctypeFormSubmit('editDocTypeForm{{$doc_type->id}}')">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- delete Modal -->
                                    <div class="modal fade" id="deleteDocTypeModal{{$doc_type->id}}" tabindex="-1" aria-labelledby="deleteDocTypeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteDocTypeModalLabel">ลบหนังสือ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row" action="{{route('admin.manage.documents.deletedoctype',['doc_type_id' => $doc_type->id])}}" method="post" id="deleteDocTypeForm">
                                                        @csrf
                                                        @method('DELETE')

                                                            <label for="" class="form-label">ต้องการลบหนังสือ <span class="text-danger">{{$doc_type->doctype_title}}</span> หรือไม่</label>
                                                    {{-- </form>  must be closed here --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                                    <button type="sumbit" class="btn btn-light">ลบหนังสือ</button>
                                                </div>
                                                </form> <!-- but i'm lazy and here it easy to validate-->
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addDocTypeModal">
                            + เพิ่มหนังสือ
                          </button>
                    </div>
                    <div class="col-md-9"></div>
                </div>
                <div>
                    <!-- Modal -->
                    <div class="modal fade" id="addDocTypeModal" tabindex="-1" aria-labelledby="addDocTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDocTypeModalLabel">เพิ่มหนังสือ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row" action="{{route('admin.manage.documents.storedoctype')}}" method="post" id="addDocTypeForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-12">
                                            <label for="doctype_title" class="form-label">ชื่อหนังสือ</label>
                                            <input type="text" class="form-control need-custom-validate" id="doctype_title"  name="doctype_title">
                                            <div class="invalid-feedback">
                                                กรุณากรอกชื่อหนังสือ
                                            </div>
                                        </div>
                                    </form> 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="button" class="btn btn-primary" onclick="doctypeFormSubmit('addDocTypeForm')">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการเอกสาร</h5>
                
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>เอกสาร</th>
                                <th class="text-center">ข้อมูลยอดเงินกู้</th>
                                <th class="text-center">ตัวอย่างเอกสาร</th>
                                <th class="text-center">ตัวอย่างเอกสาร<br>(ผู้มีอายุต่ำกว่า 20 ปี)</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($child_documents as $child_document)
                            <tr>
                                <td class="text-center fw-bold">{{$loop->index+1}}</td>
                                <td>{{ Str::limit($child_document->child_document_title, $limit = 35, $end = '...') }}</td>
                                <td class="text-center">
                                    @if ($child_document->need_loan_balance)
                                        <i class="bi bi-check-circle text-success fw-bold fs-5"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @foreach ($child_document->everyone_files as $everyone_file)
                                        <a class="btn btn-sm btn-outline-dark mb-2 w-100" href="{{route('admin.displayfile.page',['file_id' => $everyone_file->id ])}}">{{ Str::limit($everyone_file->description, $limit = 25, $end = '...') }}</a><br>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @if ($child_document->minors_file != null)
                                        <a class="btn btn-sm btn-outline-dark w-100" href="{{route('admin.displayfile.page',['file_id' => $child_document->minors_file->id])}}">ดูเอกสาร</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" onclick="openEditModal({{$child_document}})"><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light" data-bs-toggle="modal"   data-bs-target="#deleteDocChildModal{{$child_document->id}}"><i class="bi bi-trash"></i></button>
                                    </div>

                                    <div>
                                        <div class="modal fade" id="editChildDocModal" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ใขเอกสาร</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="edit-modal-body">
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="button" class="btn btn-primary" onclick="submitEditChildDocForm('eidtChildDocForm')">บันทึก</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- delete Modal -->
                                    <div class="modal fade" id="deleteDocChildModal{{$child_document->id}}" tabindex="-1" aria-labelledby="deleteDocChildModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteDocChildModalLabel">ลบเอกสาร</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row" action="{{route('admin.manage.documents.deletedocument',['child_document_id' => $child_document->id])}}" method="post" id="addDocTypeForm">
                                                        @csrf
                                                        @method('DELETE')
                                                            <label for="" class="form-label">ต้องการลบ <span class="text-danger">{{$child_document->child_document_title}}</span> หรือไม่</label>
                                                    {{-- </form>  must be closed here --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                                    <button type="submit" class="btn btn-light">ลบเอกสาร</button>
                                                </div>
                                                </form> <!-- but i'm lazy-->
                                            </div>
                                        </div>
                                    </div>

                                    </div>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addChildDocModal">
                            + เพิ่มเอกสาร
                          </button>
                    </div>
                    <div class="col-md-9"></div>
                    <div>
                        {{-- modal --}}
                        <div class="modal fade" id="addChildDocModal" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">เพิ่มเอกสาร</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addChildDocForm"  class="row" action="{{route('admin.manage.documents.storedocument')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="col-12 mb-3">
                                                <label for="child_document_title" class="form-label">เอกสาร</label>
                                                <input type="text" class="form-control need-custom-validate" id="child_document_title" name="child_document_title">
                                                <div id="child_doc_title_invalid" class="invalid-feedback">
                                                    กรุณากรอกหัวข้อเอกสาร
                                                </div>
                                            </div>
                                            <div class="col-12 mb-5">
                                                <label for="need_loan_balance" class="form-label">ข้อมูลยอดเงินกู้</label>
                                                <select id="need_loan_balance" class="form-select need-custom-validate" name="need_loan_balance">
                                                    <option selected disabled value="" >เลือก...</option>
                                                    <option value="true">ต้องการ</option>
                                                    <option value="false">ไม่ต้องการ</option>
                                                </select>
                                                <div id="need_loan_balance_invalid" class="invalid-feedback">
                                                    กรุณาเลือก ข้อมูลยอดเงิน
                                                </div>
                                            </div>
                                            
                                            <div id="file_everyone_area_add">
                                                <div class="col-12 mb-3">
                                                    <label for="file_everyone" class="form-label">ตัวอย่างเอกสาร 1</label>
                                                    <input type="file" class="form-control need-custom-validate" id="file_everyone" name="file_everyone[]">
                                                    <div id="file_everyone_invalid1" class="invalid-feedback">
                                                        กรุณาเลือกไฟล์ตัวอย่างเอกสาร
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="description" class="form-label">คำอธิบายสำหรับตัวอย่างเอกสาร 1</label>
                                                    <input type="text" class="form-control need-custom-validate" id="description" name="description[]" accept="jpg,jpeg,png,pdf">
                                                    <div id="description_invalid1" class="invalid-feedback">
                                                        กรุณากรอกคำอธิบายตัวอย่างเอกสาร
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <button type="button" class="btn btn-success" onclick="addfile('add')"> + เพิ่มไฟล์</button>
                                                <button type="button" class="btn btn-light" onclick="deletefile('add')"> ลบไฟล์</button>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <label for="file_minors" class="form-label">ตัวอย่างเอกสารสำหรับผู้มีอายุต่ำกว่า 20 ปี</label>
                                                <input type="file" class="form-control" id="file_minors" name="file_minors" accept="jpg,jpeg,png,pdf">
                                            </div>
                                        </form>  
                                        {{-- must be closed here --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-primary" onclick="submitAddChildDocForm('addChildDocForm')">บันทึก</button>
                                    </div>
                                    {{-- </form>  --}}
                                    <!-- but i'm lazy and here it easy to validate-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">แก้ไขชั่วโมงกิจกรรมจิตอาสา</h5>
                    <form class="row" action="{{route('admin.manage.documents.update.useful.hour')}}" method="post" id="useful_activity_hour_form">
                        @csrf
                        <label for="inputEmail3" class="col-md-2 col-form-label">ชั่วโมงกิจกรรมจิตอาสา</label>
                        <div class="col-md-6">
                            <input type="number" name="useful_activity_hour" id="" class="form-control need-custom-validate" value="{{$useful_activity_hour}}">
                            <div id="description_invalid1" class="invalid-feedback">
                                กรุณากรอกชั่วโมงกิจกรรมจิตอาสา
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="col-form-label">ชั่วโมง</label>

                        </div>
                        <div class="col-md-2">
                            <button type="button" class="w-100 btn btn-primary" onclick="useful_activity_hour_form_submit()">บันทึก</button>
                        </div>
                    </form>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        async function useful_activity_hour_form_submit(){
            var form_validated = await validateSubmitUsefulActivityHour();
            if(form_validated){
                const form = document.getElementById('useful_activity_hour_form');
                form.submit();
            }
        }

        function validateSubmitUsefulActivityHour(){
            var form = document.getElementById('useful_activity_hour_form');
            var input = form.querySelector('input[type="number"].need-custom-validate');
            var validate = true;

            if(input.value == ''){
                validate = false;
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
            return validate;
        }


        async function doctypeFormSubmit(formId){
            var form_validated = await validateSubmitDocType(formId)

            if(form_validated){
                const form = document.getElementById(formId);
                form.submit();
            }
        }

        async function validateSubmitDocType(formId){
            var form = document.getElementById(formId);
            var input = form.querySelector('input[type="text"].need-custom-validate');
            var validate = true;

            if(input.value == ''){
                validate = false;
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }

            return validate;
        }

        var fileIndexAdd = 1; //for add child document modal
        var fileIndexEdit = 1; //for edit child document modal
        
        function addfile(formtype) {
            var file_everyone_area = document.getElementById('file_everyone_area_'+formtype);
            if(formtype == 'add'){
                fileIndex = ++fileIndexAdd;
            }else{
                fileIndex = ++fileIndexEdit;
            }

            //file input
            var div_file_input = document.createElement('div');
            div_file_input.id = 'file_everyone_'+formtype+fileIndex;
            div_file_input.className = "col-12 mb-3";
            
            var label_file_input = document.createElement('label');
            label_file_input.className = 'form-label';
            label_file_input.textContent = 'ตัวอย่างเอกสาร '+fileIndex;

            var file_input = document.createElement('input');
            file_input.type = 'file';
            file_input.name = 'file_everyone[]';
            file_input.className = 'form-control need-custom-validate';
            file_input.accept="jpg,jpeg,png,pdf";

            var div_invalid_file = document.createElement('div');
            div_invalid_file.className = 'invalid-feedback';
            div_invalid_file.textContent = 'กรุณาเลือกไฟล์ตัวอย่างเอกสาร';

            div_file_input.appendChild(label_file_input);
            div_file_input.appendChild(file_input);
            div_file_input.appendChild(div_invalid_file);

            //description
            var div_description_input = document.createElement('div');
            div_description_input.id = 'description_'+formtype+fileIndex;
            div_description_input.className = "col-12 mb-3";

            var label_description_input = document.createElement('label');
            label_description_input.className = 'form-label';
            label_description_input.textContent = 'คำอธิบายสำหรับตัวอย่างเอกสาร '+fileIndex;

            var description_input = document.createElement('input');
            description_input.type = 'text';
            description_input.name = 'description[]';
            description_input.className = 'form-control need-custom-validate';

            var div_invalid_description = document.createElement('div');
            div_invalid_description.className = 'invalid-feedback';
            div_invalid_description.textContent = 'กรุณาเลือกไฟล์ตัวอย่างเอกสาร '+fileIndex;

            div_description_input.appendChild(label_description_input);
            div_description_input.appendChild(description_input);
            div_description_input.appendChild(div_invalid_description);
            
            //append to form
            file_everyone_area.appendChild(div_file_input);
            file_everyone_area.appendChild(div_description_input);
        }

        function deletefile(formtype){
            if(formtype == 'add'){
                fileIndex = fileIndexAdd;
            }else{
                fileIndex = fileIndexEdit;
            }

            var file_everyone_area = document.getElementById('file_everyone_area_'+formtype);
            var file_element = document.getElementById(`file_everyone_${formtype}${fileIndex}`);
            var text_element = document.getElementById(`description_${formtype}${fileIndex}`);
            if(file_element)file_everyone_area.removeChild(file_element);
            if(text_element)file_everyone_area.removeChild(text_element);

            if(fileIndex > 1){
                if(formtype == 'add'){
                    fileIndexAdd--;
                }else{
                    fileIndexEdit--;
                }
            }
        }

        async function submitAddChildDocForm(formId){
            var form_validated = await validateAddChildDocForm(formId)

            if(form_validated){
                const form = document.getElementById(formId);
                form.submit();
            }
        }

        async function validateAddChildDocForm(formId){
            var form = document.getElementById(formId);
            var inputs = form.querySelectorAll('input[type="text"].need-custom-validate');
            var select = form.querySelector('select.need-custom-validate');
            var file_input_elements = form.querySelectorAll('input[type="file"].need-custom-validate ');
            var validate = true;

            await inputs.forEach((input) => {
                if(input.value == ''){
                    validate = false;
                    var invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }

            });

            await file_input_elements.forEach((file_input) => {
                if(file_input.value == ''){
                    validate = false;
                    var invalid_element = file_input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = file_input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            });

            if(select.value == ''){
                validate = false;
                var invalid_element = select.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = select.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }

            return validate;

        }


        var fileLenght;

        function openEditModal(child_document){
            var editChildDocModal = new bootstrap.Modal(document.getElementById('editChildDocModal'));
            var editModalBody = document.getElementById('edit-modal-body');
            fileLenght = parseInt(child_document.everyone_files.length);

            editModalBody.innerHTML = '';
            editModalBody.innerHTML = `
                <form class="row" action="{{route('admin.manage.documents.editdocument',['child_document_id' => 'PLACEHOLDER_CHILD_DOCUMENT_ID'])}}" method="post" id="eidtChildDocForm" enctype="multipart/form-data">
                    @csrf
                    <div id="delete-file-area">
                        
                    </div>
                    <div class="col-12 mb-3">
                        <label for="child_doc_title" class="form-label">เอกสาร</label>
                        <input type="text" class="form-control need-custom-validate" name="child_document_title" value="${child_document.child_document_title}" required>
                        <div class="invalid-feedback">
                            กรุณากรอกหัวข้อเอกสาร
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="need_laon_balance" class="form-label">ข้อมูลยอดเงินกู้</label>
                        <select class="form-select" name="need_loan_balance" required>
                            <option ${child_document.need_loan_balance ? 'selected' : '' } value="true">ต้องการ</option>
                            <option ${!child_document.need_loan_balance ? 'selected' : '' } value="false">ไม่ต้องการ</option>
                        </select>
                    </div>
                    <div class="mb-2"></div>
                    <div id="child-document-file">
                        <div id="file-edit-area" class="form-group border border-1 p-2 mb-3">
                            <label for="#" class="form-label">ตัวอย่างเอกสาร</label>
                            ${child_document.everyone_files.map((everyone_file) =>{
                                return `
                                    <div class="row mb-3" id="file-description${everyone_file.id}">
                                        <div class="col-9 text-start">
                                            <input type="text" class="form-control need-custom-validate" value="${everyone_file.description}" name="edit_description[${everyone_file.id}]">
                                            <div class="invalid-feedback">
                                                กรุณากรอกคำอธิบายตัวอย่างเอกสาร
                                            </div>
                                        </div>
                                        <div class="col-3 text-end">
                                            <button type="button" id="removefile-button${everyone_file.id}" class="btn btn-light w-100" onclick="deleteFileEdit('${everyone_file.id}')">ลบไฟล์</button>
                                        </div>
                                    </div>
                            `}).join('')}
                        </div>
                    </div>
                    <div class="my-2"></div>
                    <div id="file_everyone_area_edit">
                        <div class="col-12 mb-3">
                            <label for="file_everyone" class="form-label">ตัวอย่างเอกสาร 1</label>
                            <input type="file" class="form-control" name="file_everyone[]">
                            <div id="file_everyone_invalid1" class="invalid-feedback">
                                กรุณาเลือกไฟล์ตัวอย่างเอกสาร
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">คำอธิบายสำหรับตัวอย่างเอกสาร 1</label>
                            <input type="text" class="form-control" name="description[]">
                            <div id="description_invalid1" class="invalid-feedback">
                                กรุณากรอกคำอธิบายตัวอย่างเอกสาร
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-success" onclick="addfile('edit')"> + เพิ่มไฟล์</button>
                        <button type="button" class="btn btn-light" onclick="deletefile('edit')"> ลบไฟล์</button>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="file_minors" class="form-label">ตัวอย่างเอกสารสำหรับผู้มีอายุต่ำกว่า 20 ปี</label>
                        <input type="file" class="form-control" id="file_minors" name="file_minors">
                        <div class="text-warning my-1">อัพโหลดไฟล์ใหม่หากต้องการแก้ใข</div>
                    </div>
                </form> 
            
            `;
            editModalBody.innerHTML = editModalBody.innerHTML.replace('PLACEHOLDER_CHILD_DOCUMENT_ID', child_document.id);
            editChildDocModal.show();
        }

        function deleteFileEdit(fileId){
            document.getElementById('file-description'+fileId).remove();

            var deleteFileArea = document.getElementById('delete-file-area');
            var inputHidden = document.createElement('input');
            inputHidden.type = 'hidden';
            inputHidden.name = 'delete_file[]';
            inputHidden.value = fileId;
            deleteFileArea.appendChild(inputHidden);
            fileLenght--;

            if(fileLenght == 0){
                fileEditArea = document.getElementById('file-edit-area');
                fileEditArea.remove();
                var inputs = document.querySelectorAll('[name="description[]"]');
                var file_input_elements = document.querySelectorAll('[name="file_everyone[]"]');
                inputs.forEach((input) => {
                    if(!input.classList.contains('need-custom-validate'))input.classList.add('need-custom-validate');
                });

                file_input_elements.forEach((file_input_element) => {
                    if(!file_input_element.classList.contains('need-custom-validate'))file_input_element.classList.add('need-custom-validate');
                });

            }
            
        }

        async function submitEditChildDocForm(formId){
            var form_validated = await validateEditChildDocForm(formId)

            if(form_validated){
                const form = document.getElementById(formId);
                form.submit();
            }
        }

        async function validateEditChildDocForm(formId){
            var form = document.getElementById(formId);
            var inputs = form.querySelectorAll('input[type="text"].need-custom-validate');
            var file_input_elements = form.querySelectorAll('input[type="file"].need-custom-validate');
            var validate = true;

            inputs.forEach((input) => {
                if(input.value == ''){
                    validate = false;
                    var invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }

            });

            await file_input_elements.forEach((file_input) => {
                if(file_input.value == ''){
                    validate = false;
                    var invalid_element = file_input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    var invalid_element = file_input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            });

            return validate;
        }
    </script>
@endsection