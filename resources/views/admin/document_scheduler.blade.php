@extends('layout')
@section('title')
admin document scheduler
@endsection
@section('content')
<section class="section dashboard">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">เพิ่มรายการส่งเอกสารสำหรับผู้กู้</h5>
                <form class="row" action="{{route('admin.doc.scheduler.putdata')}}" method="post" id="document-scheduler-put-form">
                    @csrf
                    @method('PUT')
                    <div class="col-md-3">
                        <label for="term" class="col-form-label text-secondary">เลือกปีการศึกษา</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="term" id="term" class="form-control need-custom-validate">
                        <div class="invalid-feedback">
                            กรุณากรอกภาคเรียน
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="yaer" class="col-form-label text-secondary">/</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="year" id="year" class="form-control need-custom-validate">
                        <div class="invalid-feedback">
                            กรุณากรอกปีการศึกษา
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 mt-3">
                        <label for="doctype_id" class="col-form-label text-secondary">เลือกหนังสือ</label>
                    </div>
                    <div class="col-md-6 mt-3">
                        <select id="doctype_id" name="doctype_id" class="form-select need-custom-validate" aria-label="Default select example">
                            <option selected disabled value="" >เลือกหนังสือ...</option>
                            @foreach($doc_types as $doc_type)
                            <option value="{{$doc_type->id}}">{{$doc_type->doctype_title}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            กรุณาเลือกหนังสือ
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 mt-3">
                        <label for="start-date" class="col-form-label text-secondary">เลือกเอกสาร</label>
                    </div>
                    <div class="col-md-9 mt-3">
                        <div class="list-group">
                            @foreach($child_documents as $child_document)
                            <div class="list-group-item">
                                <div class="form-check">
                                    <label class="form-check-label" for="document{{$child_document->id}}">
                                        {{$child_document->child_document_title}}
                                        @if($child_document->need_loan_balance)
                                            <span class="text-secondary">(ต้องการยอดเงินกู้)</span>
                                        @endif
                                        @if(!$child_document->isrequired)
                                            <span class="text-secondary">(ส่งหรือไม่ก็ได้)</span>
                                        @endif
                                    </label>
                                    <input class="form-check-input need-custom-validate" type="checkbox" id="document{{$child_document->id}}" name="child_documents[]" value="{{$child_document->id}}">
                                </div>
                                @foreach($child_document->addon_documents as $addon_document)
                                    <small>+ {{$addon_document->title}} {{($addon_document->for_minors) ? '(สำหรับผู้กู้อายุต่ำว่า 20 ปี)' : '' }}</small><br>
                                @endforeach
                            </div>
                            @endforeach
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="teacher-comment" name="need_teacher_comment" value="true">
                                    <label class="form-check-label" for="teacher-comment">
                                        หนังสือแสดงความคิดเห็นอาจารย์ที่ปรึกษา
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="useful-act" name="need_useful_activity" value="true">
                                    <label class="form-check-label" for="useful-act">
                                        กิจกรรมจิตอาสา {{$useful_activity_hour}} ชั่วโมง
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="checkbox-invalid-document-scheduler-put-form" class="invalid-feedback">
                            กรุณาเลือกเอกสาร
                        </div>

                        
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="start_date" class="col-form-label text-secondary">วันที่เริ่มต้น</label>
                    </div>
                    <div class="col-sm-5 mt-3">
                        <div class="input-group date" id="">
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                            <input type="text" name="start_date" id="start_date" class="form-control need-custom-validate"
                                placeholder="วว/ดด/ปปปป" required />
                            <div class="invalid-feedback">
                                กรุณากรอกวันที่เริ่มต้นการส่งเอกสาร
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-sm-3 mt-3">
                        <label for="end_date" class="col-form-label text-secondary">วันที่สิ้นสุด</label>
                    </div>
                    <div class="col-sm-5 mt-3">
                        <div class="input-group date" id="">
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                            <input type="text" name="end_date" id="end_date" class="form-control need-custom-validate"
                                placeholder="วว/ดด/ปปปป" required />
                            <div class="invalid-feedback">
                                กรุณากรอกวันที่สิ้นสุดการส่งเอกสาร
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-sm-3 mt-3">
                        <label for="description" class="col-form-label text-secondary">คำอธิบาย</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <div class="input-group mt-3" id="description">
                            <textarea class="form-control need-custom-validate" name="description" id="" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 text-end mt-3">
                        <button type="reset" class="btn btn-secondary">ล้างฟอร์ม</button>
                        <button type="button" class="w-25 btn btn-success" onclick="document_scheduler_submitform('document-scheduler-put-form')">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการกำหนดการ</h5>
                <div class="table-responsive">
                    <table class="table table-striped" id="documant-sheduler-table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">เอกสาร</th>
                            <th scope="col" class="text-center">วันที่เริ่ม</th>
                            <th scope="col" class="text-center">วันที่สิ้นสุด</th>
                            <th scope="col">เพิ่มโดย</th>
                            <th scope="col" class="text-center">แก้ใข / ลบ</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>
                                    <span>{{$document->doctype_title}}</span><br>
                                    <span class="text-secondary fw-light">{{$document->term}} / {{$document->year}}</span>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $document->start_date)->format('d-m-Y')}}</td>
                                <td class="text-center">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $document->end_date)->format('d-m-Y')}}</td>
                                <td>{{$document->last_access}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" onclick="fetchDocumnetById({{$document->id}})">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#deleteDocumentModal-{{$document->id}}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- edit modal --}}
                                    <div>
                                        <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                <div class="modal-content" id="editDocumentModalContent">
                                                    
                                                </div>
                                            </div>
                                          </div>
                                    </div>

                                    {{-- delete modal --}}
                                    <div>
                                        <div class="modal fade" id="deleteDocumentModal-{{$document->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">ลบหนังสือ</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.doc.scheduler.deletedata',['document_id' => $document->id])}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <label for="" class="form-label">ต้องการลบ <span class="text-danger">{{$document->doctype_title}} {{$document->term}} / {{$document->year}}</span> หรือไม่</label>
                                                            
                                                        {{-- </form> form must close here --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary w-25" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-light">ลบ</button>
                                                    </div>
                                                </form> 
                                                {{-- but i'm lazy and here to easy --}}
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
            </div>
        </div>
    </div>
</div>
</section>

@endsection

@section('script')
<script>

    var doc_types = {!! json_encode($doc_types) !!};
    var child_documents = {!! json_encode($child_documents) !!};


    $(document).ready(function () {
        $.datetimepicker.setLocale('th'); 
  
        $('#start_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });

        $('#end_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });

       
    })

    async function document_scheduler_submitform(formId){
        var form_validated = await validate_document_scheduler_form(formId);

        if(form_validated){
            const form = document.getElementById(formId);
            form.submit();
        }else{
            alert('ดูเหมือนว่าท่านยังกรอกข้อมูลไม่ครบ! กรุณาตรวจสอบอีกครั้ง');
            window.scrollTo(0,0);
        }
    }

    async function validate_document_scheduler_form(formId){
        var form = document.getElementById(formId);
        var inputs = form.querySelectorAll('input[type="text"].need-custom-validate');
        var select = form.querySelector('select.need-custom-validate');
        var checkbox_inputs = form.querySelectorAll('input[type="checkbox"].need-custom-validate');
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

        var checkbox_empty = true;
        await checkbox_inputs.forEach((checkbox_input) => {
                    if(checkbox_input.checked){
                        checkbox_empty = false;
                    }
                });

        if(checkbox_empty){
            validate = false;
            var invalid_checkbox = document.getElementById('checkbox-invalid-'+formId);
            invalid_checkbox.classList.add('d-inline');

        }else{
            var invalid_checkbox = document.getElementById('checkbox-invalid-'+formId);
            invalid_checkbox.classList.remove('d-inline');
        }

        if(select.value == ''){
            validate = false;
            var select = select.nextElementSibling;
            if(select)select.classList.add('d-inline');
        }else{
            var select = select.nextElementSibling;
            if(select)select.classList.remove('d-inline');
        }
        return validate;
    }

    function fetchDocumnetById(document_id){
        fetch(`/admin/document_scheduler/get/document/${document_id}`)
        .then(response => {
            if (!response.ok) {
            throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Work with JSON data here
            // console.log(data);
            generateEditmodalContent(data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    function generateEditmodalContent(document_data){
        const modal = new bootstrap.Modal(document.getElementById('editDocumentModal'));

        const modalcontent = document.getElementById('editDocumentModalContent');
        modalcontent.innerHTML = '';
        modalcontent.innerHTML = `
            <div class="modal-header">
                <h5 class="modal-title">แก้ใขเอกสาร <strong>${document_data.doctype_title} ${document_data.term}/${document_data.year}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <form class="row" action="{{route('admin.doc.scheduler.postdata',['document_id' => 'PLACEHOLDER_DOCUMENT_ID'])}}" method="post" id="document-scheduler-post-form">
                    @csrf
                    <div class="col-md-3">
                        <label for="term" class="col-form-label text-secondary">เลือกปีการศึกษา</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="term" id="term" class="form-control need-custom-validate" value="${document_data.term}">
                        <div class="invalid-feedback">
                            กรุณากรอกภาคเรียน
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label for="yaer" class="col-form-label text-secondary">/</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="year" id="year" class="form-control need-custom-validate" value="${document_data.year}">
                        <div class="invalid-feedback">
                            กรุณากรอกปีการศึกษา
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 mt-3">
                        <label for="doctype_id" class="col-form-label text-secondary">เลือกหนังสือ</label>
                    </div>
                    <div class="col-md-6 mt-3">
                        <select id="doctype_id" name="doctype_id" class="form-select need-custom-validate" aria-label="Default select example" value="${document_data.doctype_id}">
                            ${doc_types.map((doc_type)=>{
                                return `<option ${(document_data.doctype_id == doc_type.id) ? 'selected' : '' } value="${doc_type.id}">${doc_type.doctype_title}</option>`
                            }).join('')}
                        </select>
                        <div class="invalid-feedback">
                            กรุณาเลือกหนังสือ
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 mt-3">
                        <label for="start-date" class="col-form-label text-secondary">เลือกเอกสาร</label>
                    </div>
                    <div class="col-md-9 mt-3">
                        <div class="list-group">
                            ${child_documents.map((child_document)=>{
                                return `<div class="list-group-item">
                                            <div class="form-check">
                                                <label class="form-check-label" for="document">
                                                    ${child_document.child_document_title}
                                                </label>
                                                <input class="form-check-input need-custom-validate" type="checkbox"  name="child_documents[]" value="${child_document.id}" ${(document_data.child_document_id.includes(child_document.id)) ? 'checked' : ''}>
                                            </div>
                                            ${child_document.addon_documents.map((addon_document)=>{
                                                return `<small>+ ${addon_document.title} ${(addon_document.for_minors) ? '(สำหรับผู้กู้อายุต่ำว่า 20 ปี)' : '' } </small><br>`
                                            }).join('')}
                                        </div>`
                            }).join('')}
                            
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="teacher-comment" name="need_teacher_comment" value="true" ${(document_data.need_teacher_comment) ? 'checked' : ''}>
                                    <label class="form-check-label" for="teacher-comment">
                                        หนังสือแสดงความคิดเห็นอาจารย์ที่ปรึกษา
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="useful-act" name="need_useful_activity" value="true" ${(document_data.need_useful_activity) ? 'checked' : ''}>
                                    <label class="form-check-label" for="useful-act">
                                        กิจกรรมจิตอาสา {{$useful_activity_hour}} ชั่วโมง
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="checkbox-invalid-document-scheduler-post-form" class="invalid-feedback">
                            กรุณาเลือกเอกสาร
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="start_date" class="col-form-label text-secondary">วันที่เริ่มต้น</label>
                    </div>
                    <div class="col-sm-5 mt-3">
                        <div class="input-group date" id="">
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                            <input type="text" name="start_date" id="edit_start_date" class="form-control need-custom-validate"
                                placeholder="วว/ดด/ปปปป" value="${formatDate(document_data.start_date)}" />
                            <div class="invalid-feedback">
                                กรุณากรอกวันที่เริ่มต้นการส่งเอกสาร
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-sm-3 mt-3">
                        <label for="end_date" class="col-form-label text-secondary">วันที่สิ้นสุด</label>
                    </div>
                    <div class="col-sm-5 mt-3">
                        <div class="input-group date" id="">
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                            <input type="text" name="end_date" id="edit_end_date" class="form-control need-custom-validate"
                                placeholder="วว/ดด/ปปปป" value="${formatDate(document_data.end_date)}" />
                            <div class="invalid-feedback">
                                กรุณากรอกวันที่สิ้นสุดการส่งเอกสาร
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-sm-3 mt-3">
                        <label for="description" class="col-form-label text-secondary">คำอธิบาย</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <div class="input-group mt-3" id="description">
                            <textarea class="form-control need-custom-validate" name="description" id="" cols="30" rows="5">${document_data.description}</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary w-25" onclick="document_scheduler_submitform('document-scheduler-post-form')" >บันทึก</button>
            </div>
        
            `;
        modalcontent.innerHTML = modalcontent.innerHTML.replace('PLACEHOLDER_DOCUMENT_ID', document_data.id);
        modal.show();

        $('#edit_start_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });

        $('#edit_end_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });
    }

    function formatDate(inputDate) {
        // Parse the input date string into a Date object
        const parts = inputDate.split("-");
        const year = parts[0];
        const month = parts[1];
        const day = parts[2];
        const date = new Date(year, month - 1, day); // Month is 0-indexed in JavaScript Date object

        // Get the day, month, and year components from the Date object
        const formattedDay = String(date.getDate()).padStart(2, "0"); // Ensure leading zero if necessary
        const formattedMonth = String(date.getMonth() + 1).padStart(2, "0"); // Month is 0-indexed, so add 1
        const formattedYear = date.getFullYear();

        // Construct the new date string in "dd-mm-YYYY" format
        const formattedDate = `${formattedDay}-${formattedMonth}-${formattedYear}`;

        return formattedDate;
    }

    $(document).ready(function() {
            $('#documant-sheduler-table').DataTable({
                language: {
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
                },
            });
        });
</script>
@endsection