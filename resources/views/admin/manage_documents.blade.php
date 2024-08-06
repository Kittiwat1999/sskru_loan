@extends('layout')
@section('title')
แก้ใขเอกสาร
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">รายการหนังสือ</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-striped table-bordered" id="doctype-table">
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
                                                    <form class="row" action="{{route('admin.edit.document',['doc_type_id' => $doc_type->id])}}" method="post" id="editDocTypeForm{{$doc_type->id}}">
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
                                                    <form class="row" action="{{route('admin.delete.document',['doc_type_id' => $doc_type->id])}}" method="post" id="deleteDocTypeForm">
                                                        @csrf
                                                        @method('DELETE')

                                                            <label for="" class="form-label">ต้องการลบหนังสือ <span class="text-danger">{{$doc_type->doctype_title}}</span> หรือไม่</label>
                                                    {{-- </form>  must be closed here --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="sumbit" class="btn btn-light">ลบหนังสือ</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
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
                                    <form class="row" action="{{route('admin.store.document')}}" method="post" id="addDocTypeForm">
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
                    <table class="table table-striped table-bordered" id="child-document-table">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>เอกสาร</th>
                                <th class="text-center">ข้อมูลยอดเงินกู้</th>
                                <th class="text-center">จัดการไฟล์</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($child_documents as $child_document)
                            <tr>
                                <td class="text-center fw-bold">{{$loop->index+1}}</td>
                                <td>{{ Str::limit($child_document->child_document_title, $limit = 40, $end = '...') }}</td>
                                <td class="text-center">
                                    @if ($child_document->need_loan_balance)
                                        <i class="bi bi-check-circle text-success fw-bold fs-5"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{route('admin.manage.file.document',['child_document_id' => $child_document->id])}}" class="btn btn-danger">จัดการไฟล์</a>                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" onclick="openEditModal({{$child_document}})"><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light" data-bs-toggle="modal"   data-bs-target="#deleteDocChildModal{{$child_document->id}}"><i class="bi bi-trash"></i></button>
                                    </div>

                                    <div>

                                        <div class="modal fade" id="editChildDocModal" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
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
                                                        <form class="row" action="{{route('admin.delete.child_document',['child_document_id' => $child_document->id])}}" method="post" id="addDocTypeForm">
                                                            @csrf
                                                            @method('DELETE')
                                                                <label for="" class="form-label">ต้องการลบ <span class="text-danger">{{$child_document->child_document_title}}</span> หรือไม่</label>
                                                        {{-- </form>  must be closed here --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-light">ลบเอกสาร</button>
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
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
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">เพิ่มเอกสาร</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addChildDocForm"  class="row" action="{{route('admin.store.child_document')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="col-12 mb-3">
                                                <label for="child_document_title" class="form-label">เอกสาร</label>
                                                <input type="text" class="form-control need-custom-validate" id="child_document_title" name="child_document_title">
                                                <div id="child_doc_title_invalid" class="invalid-feedback">
                                                    กรุณากรอกหัวข้อเอกสาร
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
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
                                            <div class="col-12 mb-3">
                                                <label for="isrequired" class="form-label">ตัวเลือกการส่งเอกสาร</label>
                                                <select id="isrequired" class="form-select need-custom-validate" name="isrequired">
                                                    <option selected disabled value="" >เลือก...</option>
                                                    <option value="true">ต้องมี</option>
                                                    <option value="false">มีหรือไม่มีก็ได้</option>
                                                </select>
                                                <div id="required_invalid" class="invalid-feedback">
                                                    กรุณาเลือก ตัวเลือกการส่งเอกสาร
                                                </div>
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
        {{-- add-on document --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการเอกสารแนบ</h5>
                
                <div class="table-responsive mb-3">
                    <table class="table table-striped table-bordered" id="addon-document-table">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>เอกสาร</th>
                                <th class="text-center">สำหรับผู้กู้ที่อายุต่ำกว่า 20 ปี</th>
                                <th class="text-center">จัดการไฟล์</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addon_documents as $addon_document)
                            <tr>
                                <td class="text-center fw-bold">{{$loop->index+1}}</td>
                                <td>{{ Str::limit($addon_document->title, $limit = 40, $end = '...') }}</td>
                                <td class="text-center">
                                    @if ($addon_document->for_minors)
                                        <i class="bi bi-check-circle text-success fw-bold fs-5"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{route('admin.manage.addon.file.document',['addon_document_id' => $addon_document->id])}}" class="btn btn-danger">จัดการไฟล์</a>                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" onclick="openEditAddOnDocumentModal({{$addon_document}})"><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light" data-bs-toggle="modal"   data-bs-target="#deleteAddOnDocumentModal{{$addon_document->id}}"><i class="bi bi-trash"></i></button>
                                    </div>

                                    <div>

                                        <div class="modal fade" id="editAddOnDocumentModal" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ใขเอกสารแนบ</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="edit-addon-document-modal-body">
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="button" class="btn btn-primary" onclick="submitAddOnDocumentForm('editAddOnDocumentForm')">บันทึก</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- delete Modal -->
                                        <div class="modal fade" id="deleteAddOnDocumentModal{{$addon_document->id}}" tabindex="-1" aria-labelledby="deleteAddOnDocumentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteDocChildModalLabel">ลบเอกสาร</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="row" action="{{route('admin.delete.addon_document',['addon_document_id' => $addon_document->id])}}" method="post" id="addDocTypeForm">
                                                            @csrf
                                                            @method('DELETE')
                                                                <label for="" class="form-label">ต้องการลบ <span class="text-danger">{{$addon_document->title}}</span> หรือไม่</label>
                                                        {{-- </form>  must be closed here --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-light">ลบเอกสาร</button>
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
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
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addAddOnDocumnetModal">
                            + เพิ่มเอกสารส่วนเสริม
                          </button>
                    </div>
                    <div class="col-md-9"></div>
                    <div>
                        {{-- modal --}}
                        <div class="modal fade" id="addAddOnDocumnetModal" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">เพิ่มเอกสารส่วนเสริม</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addAddonDocumentForm"  class="row" action="{{route('admin.store.addon_document')}}" method="POST">
                                            @csrf
                                            <div class="col-12 mb-3">
                                                <label for="title" class="form-label">เอกสาร</label>
                                                <input type="text" class="form-control need-custom-validate" id="title" name="title">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกชื่อเอกสารส่วนเสริม
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="checkbox" id="for_minors" name="for_minors" value="true">
                                                    <label class="form-check-label" for="for_minors">
                                                        สำหรับผู้กู้ที่อายุน้อยกว่า 20 ปี
                                                    </label>
                                                </div>
                                            </div>
                                        </form>  
                                        {{-- must be closed here --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-primary" onclick="submitAddOnDocumentForm('addAddonDocumentForm')">บันทึก</button>
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
        {{-- end add-on document --}}
        {{-- useful activities --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">แก้ไขชั่วโมงกิจกรรมจิตอาสา</h5>
                    <form class="row" action="{{route('admin.update.useful.hour')}}" method="post" id="useful_activity_hour_form">
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
            var select = form.querySelectorAll('select.need-custom-validate');
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

            await select.forEach((e)=>{
                if(e.value == ''){
                validate = false;
                var invalid_element = e.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = e.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }

            });

            return validate;
        }

        function openEditModal(child_document){
            var editChildDocModal = new bootstrap.Modal(document.getElementById('editChildDocModal'));
            var editModalBody = document.getElementById('edit-modal-body');

            editModalBody.innerHTML = '';
            editModalBody.innerHTML = `
                <form class="row" action="{{route('admin.edit.child_document',['child_document_id' => 'PLACEHOLDER_CHILD_DOCUMENT_ID'])}}" method="post" id="eidtChildDocForm" enctype="multipart/form-data">
                    @csrf
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
                    <div class="col-12 mb-3">
                        <label for="isrequired" class="form-label">ตัวเลือกการส่งเอกสาร</label>
                        <select class="form-select" name="isrequired" required>
                            <option ${child_document.isrequired ? 'selected' : '' } value="true">ต้องมี</option>
                            <option ${!child_document.isrequired ? 'selected' : '' } value="false">มีหรือไม่มีก็ได้</option>
                        </select>
                    </div>
                </form> 
            
            `;
            editModalBody.innerHTML = editModalBody.innerHTML.replace('PLACEHOLDER_CHILD_DOCUMENT_ID', child_document.id);
            editChildDocModal.show();
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
            return validate;
        }

        function openEditAddOnDocumentModal(addon_document){
            var editAddOnDocumentModal = new bootstrap.Modal(document.getElementById('editAddOnDocumentModal'));
            var editModalBody = document.getElementById('edit-addon-document-modal-body');

            editModalBody.innerHTML = '';
            editModalBody.innerHTML = `
                <form id="editAddOnDocumentForm"  class="row" action="{{route('admin.edit.addon_document',['addon_document_id' => 'PLACEHOLDER_ADDON_DOCUMENT_ID'])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12 mb-3">
                        <label for="title" class="form-label">เอกสาร</label>
                        <input type="text" class="form-control need-custom-validate" id="title" name="title" value="${addon_document.title}">
                        <div class="invalid-feedback">
                            กรุณากรอกหัวข้อเอกสาร
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="for_minors" name="for_minors" value="true" ${(addon_document.for_minors) ? 'checked' : ''}>
                            <label class="form-check-label" for="for_minors">
                                สำหรับผู้กู้ที่อายุน้อยกว่า 20 ปี
                            </label>
                        </div>
                    </div>
                </form>
            
            `;
            editModalBody.innerHTML = editModalBody.innerHTML.replace('PLACEHOLDER_ADDON_DOCUMENT_ID', addon_document.id);
            editAddOnDocumentModal.show();
        }

        async function submitAddOnDocumentForm(formId){
            var form_validated = await validateAddOnDocumentForm(formId)

            if(form_validated){
                const form = document.getElementById(formId);
                form.submit();
            }
        }

        async function validateAddOnDocumentForm(formId){
            var form = document.getElementById(formId);
            var inputs = form.querySelectorAll('input[type="text"].need-custom-validate');
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
            return validate;
        }

        $(document).ready(function() {
            $('#doctype-table').DataTable({
                "language": {
                    "sProcessing": "กำลังประมวลผล...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "แรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "สุดท้าย"
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#child-document-table').DataTable({
                "language": {
                    "sProcessing": "กำลังประมวลผล...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "แรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "สุดท้าย"
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#addon-document-table').DataTable({
                "language": {
                    "sProcessing": "กำลังประมวลผล...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "แรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "สุดท้าย"
                    }
                }
            });
        });
    </script>
@endsection