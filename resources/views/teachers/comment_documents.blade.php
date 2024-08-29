@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
@section('style')
<style>
        .accordionContainer .accordionItem {
        margin-bottom: 10px;
        }
        .accordionContainer .accordionHeader {
        border-radius: 2px;
        background-color: #F4F7FE;
        padding: 5px;
        font-weight: 700;
        }
        .accordionContainer .accordionHeader:hover {
        cursor: pointer;
        }
        .accordionContainer .accordionContent {
        overflow: hidden;
        transition: 0.3s ease;
        transform: tanslateZ(0);
        height: 0px;
        }
        .accordionContainer .accordionContentInner {
        padding: 15px 0;
        background-color: #FFFFFF;
        padding: 5px 10px;
        }
        iframe {
        width: 100%;
        border: none;

        html {
            scroll-behavior: auto;
        }

        }
        @media (max-width: 600px) {
        iframe {
            height: 400px;
        }
        }
        @media (min-width: 601px) and (max-width: 1200px) {
        iframe {
            height: 500px;
        }
        }
        @media (min-width: 1201px) {
        iframe {
            height: 1000px;
        }
        }
    </style>
@endsection

@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>
            <div class="accordion mb-3" id="accordion">
                @foreach($child_documents as $child_document)
                    @if($child_document->borrower_child_document != null)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="child-document-{{$child_document->id}}">
                            <button id="accordion-button-child-document-{{$child_document->id}}" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse-child-document-{{$child_document->id}}" 
                                aria-expanded="true" 
                                aria-controls="collapse-child-document-{{$child_document->id}}">
                                <span class="col-md-3 col-7">{{$child_document->child_document_title}}</span>
                                {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                            </button>
                        </h2>
                        <div id="collapse-child-document-{{$child_document->id}}" class="accordion-collapse collapse" aria-labelledby="child-document-{{$child_document->id}}" data-bs-parent="#accordion" style="">
                            <div class="accordion-body">
                                <iframe src="{{route('teacher.comment.preview.file',['borrower_child_document_id' => $child_document->borrower_child_document->id])}}"></iframe>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12"></div>
                                    <div class="col-md-2 col-sm-12">
                                        <button type="button" class="btn btn-secondary w-100" onclick="closeAccordion({{$child_document->id}},'child-document')">ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                {{$borrower->user_id}}
                @if($document->need_teacher_comment)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="document-103">
                            <button id="accordion-button-document-103-1" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#document-103-collapse" 
                                aria-expanded="true" 
                                aria-controls="document-103-collapse">
                                <span class="col-md-3 col-7">หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)</span>
                                {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                            </button>
                        </h2>
                        <div id="document-103-collapse" class="accordion-collapse collapse" aria-labelledby="document-103" data-bs-parent="#accordion" style="">
                            <div class="accordion-body">
                                <iframe id="pdf-103" src="{{route('teacher.comment.preview.teacher.comment',['borrower_document_id' => $borrower_document->id, 'borrower_uid' => $borrower->user_id])}}" frameborder="0" class="w-100" height="800"></iframe>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12"></div>
                                    <div class="col-md-2 col-sm-12">
                                        <button type="button" class="btn btn-secondary w-100" onclick="closeAccordion('1','document-103')" >ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($document->need_useful_activity)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="useful-activity">
                        <button id="accordion-button-useful-activity-1" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#useful-activity-collapse" 
                            aria-expanded="true" 
                            aria-controls="useful-activity-collapse">
                            <span class="col-md-3 col-7">บันทึกกิจกรรมจิตอาสา</span>
                            {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                        </button>
                    </h2>
                    <div id="useful-activity-collapse" class="accordion-collapse collapse" aria-labelledby="useful-activity" data-bs-parent="#accordion" style="">
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col-2">ชื่อโครงการ</th>
                                        <th scope="col-2">สถานที่</th>
                                        <th scope="col-2">วัน/เดือน/ปี</th>
                                        <th scope="col-2">จำนวนชั่วโมง</th>
                                        <th scope="col-2">ลักษณะกิจกรรม</th>
                                        <th scope="col-2">ไฟล์หลักฐาน</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                        @foreach ($useful_activities as $useful_activity)
                                        <tr>
                                            <td>{{$useful_activity->activity_name}}</td>
                                            <td>{{$useful_activity->activity_location}}</td>
                                            <td>
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $useful_activity->start_date)->format('d-m-Y H:i')}} <br>
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $useful_activity->end_date)->format('d-m-Y H:i')}}
                                            </td>
                                            <td class="text-center">{{$useful_activity->hour_count}}</td>
                                            <td>{{$useful_activity->description}} </td>
                                            <td class="text-center">
                                                <a class="btn btn-danger" href="{{route('borrower.show.usefulactivity.file' ,['useful_activity_id' => $useful_activity->id , 'document_id' => $document->id])}}" rel="noopener noreferrer" target="_blank"><i class="bi bi-journal-bookmark" ></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
            
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                        </td>
                                        <td class="text-center">{{$borrower_useful_activities_hours_sum}}/{{$useful_activities_hours}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-md-10 col-sm-12"></div>
                                <div class="col-md-2 col-sm-12">
                                    <button type="button" class="btn btn-secondary w-100" onclick="closeAccordion('1','useful-activity')" >ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body border mb-3">
                <h5 class="card-title">รายละอียดผู้กู้</h5>

                    <div class="row">
                        <div class="col-md-3 text-secondary fw-bold">ชื่อ-นามสกุล</div>
                        <div class="col-md-4">{{$borrower['prefix']}}{{$borrower['firstname']}} {{$borrower['lastname']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">ลักษณะผู้กู้</div>
                        <div class="col-md-4">{{$borrower['title']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">เกิดเมื่อ</div>
                        <div class="col-md-4">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $borrower['birthday'])->format('d-m-Y')}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">อายุ</div>
                        <div class="col-md-4" id="age"></div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">รหัสนักศึกษา</div>
                        <div class="col-md-4">{{$borrower['student_id']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">คณะ</div>
                        <div class="col-md-4">{{$borrower['faculty_name']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">สาขา</div>
                        <div class="col-md-4">{{$borrower['major_name']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">ชั้นปี</div>
                        <div id="grade" class="col-md-4"></div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">โทรศัพท์</div>
                        <div class="col-md-4">{{$borrower['phone']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">ผลการเรียนเฉลี่ย</div>
                        <div class="col-md-4">{{$borrower['gpa']}}</div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="border-top mt-4"></div>
                    <form id="comment-form" class="row mt-4" action="{{route('tacher.store.commnet',['borrower_document_id' => $borrower_document['id'] ])}}" method="POST">
                        @csrf
                        <div class="col-md-12 mt-3">
                            <h6 class="text-dark">ความคิดเห็นของผู้สัมภาษณ์</h6>
                        </div>
                        <div id="invalid-radio" class="invalid-feedback">
                            กรุณาระบุความเห็น
                        </div>
                        <div class="col-md-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="approve" value="approve" onchange="displayInputComment(this.value)" @checked($borrower_document['teacher_status'] == 'approved')>
                                <label class="form-check-label" for="approve">
                                    อนุมัติ
                                </label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="reject" value="reject" onchange="displayInputComment(this.value)" @checked($borrower_document['teacher_status'] == 'rejected' ||  $borrower_document['teacher_status'] == 'response-reject')>
                                <label class="form-check-label" for="reject">
                                    ไม่อนุมัติ เนื่องจาก
                                </label>
                                <input type="text" name="reject_comment" id="reject-comment" class="form-control" @disabled($borrower_document['teacher_status'] == 'wait-approve' ||  $borrower_document['teacher_status'] == 'approved') value="{{ ($teacher_reject_document != null) ? $teacher_reject_document->reject_comment : '' }}">
                                <div class="invalid-feedback">
                                    กรุณากรอกเหตุผลที่ไม่อนุมัติ
                                </div>
                            </div>
                        </div>
                        <div id="input-comment" class="col-12 row m-0 p-0 d-none">
                            <div class="col-md-12 mt-3">
                                <h6 class="text-dark">ให้ความเห็น</label>
                            </div>
                            <div id="invalid-checkbox" class="invalid-feedback">
                                กรุณาระบุความเห็น
                            </div>
                            @foreach($comments as $comment)
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="comment-{{$comment['id']}}" name="comments[]" value="{{$comment['id']}}" @checked($comment['checked'])>
                                        <label class="form-check-label text-dark" for="comment-{{$comment['id']}}">
                                            {{$comment['comment']}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="other-comment" name="more_comment_check" value="1" onchange="enableInputText()" @checked($more_comment != null)>
                                    <label class="form-check-label" for="other-comment">
                                    อื่นๆ
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-5 col-11 mx-4">
                                <input type="text" name="more_comment" id="more_comment" class="form-control" @disabled($more_comment == null) value="{{ ($more_comment != null) ? $more_comment->custom_comment : '' }}">
                                <div class="invalid-feedback">
                                    กรุณากรอกความคิดเห็น
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="col-12 row m-0 p-0">
                <div class="col-md-9 col-sm-12"></div>
                <div class="col-md-3 col-sm-12">
                    <button type="button" class="btn btn-primary w-100" onclick="submitForm('comment-form')">บันทึก</button>
                </div>
            </div>
        </div>
    </div>


</section>
@endsection

@section('script')

<script>
    var student_id = @json($borrower->student_id);
    var status = @json($borrower_document['teacher_status']);
    var birthday = @json($borrower['birthday']);

    ageCal(birthday);
    calculateGrade(student_id);
    (status == 'approved') ? displayInputComment('approve') : displayInputComment('reject');

    function calculateGrade(student_id){
        const date = new Date().getFullYear() + 543;
        let firstTwoDigits = Math.floor(date / 100);
        let buddhistCurrentYear = parseInt(Math.floor(date));
        let beginYear = parseInt(firstTwoDigits+student_id[0]+student_id[1]);
        let grade = (buddhistCurrentYear - beginYear) + 1;
        document.getElementById('grade').innerText = grade;
    }

    function closeAccordion(id, option){
        const accordion_button = document.getElementById('accordion-button-' + option + '-' + id);
        accordion_button.click();
        window.scrollTo({
            top: 0,     // Vertical scroll position
            left: 0,    // Horizontal scroll position
            behavior: 'smooth' // Smooth scroll
        });
    }
    function enableInputText(){
        const inputText = document.getElementById('more_comment');
        inputText.disabled = !inputText.disabled;
        inputText.required = !inputText.required;
    }

    async function submitForm(form_id){
        var validation = await validateForm(form_id) 

        if(validation){
            const form = document.getElementById(form_id);
            form.submit();
        }else{
            alert('กรุณากรอกความเห็น');
            window.scrollTo(0,0);
        }
    }

    async function validateForm(form_id){
        const form = document.getElementById(form_id);
        const checkbox =  form.querySelectorAll('input[type="checkbox"][required]');
        const inputs_text = form.querySelectorAll('input[type="text"][required]');
        const radio = form.querySelectorAll('input[name="status"]');
        var validator = true;

        inputs_text.forEach((input_text) => {
            if(input_text.value == ''){
                validator = false;
                var invalid_element = input_text.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input_text.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        var validate_checkbox = (checkbox.length != 0) ? await validateCheckBox(checkbox) : true;
        if(!validate_checkbox){
            validator = false;
            var invalid_checkbox = document.getElementById('invalid-checkbox');
            if(invalid_checkbox)invalid_checkbox.classList.add('d-inline');
        }

        var validate_radio =  await validateRadio(radio);
        if(validate_radio){
            validator = false;
            var invalid_radio = document.getElementById('invalid-radio');
            if(invalid_radio)invalid_radio.classList.add('d-inline');
        }

        return validator;
    }

    async function validateCheckBox(checkbox){
        var checker = false;
        for(let i = 0; i < checkbox.length; i ++){
            if(checkbox[i].checked == true){
                checker = true;
                break;
            }
        }   
        return (checker) ? true : false;
    }

    async function validateRadio(radio){
        var checker = false;
        await radio.forEach((e) => {
            if(radio.checked){
                checker = true;
            }
        });
        return checker;
    }

    function displayInputComment(checkbox_value){
        const input_comment = document.getElementById('input-comment');
        const checkbox =  document.querySelectorAll('input[type="checkbox"]');
        if(checkbox_value == 'approve'){
            input_comment.classList.remove('d-none');
            const reject_comment = document.getElementById('reject-comment');
            reject_comment.disabled = true;
            reject_comment.required = false;

            checkbox.forEach((e) => {e.required = true});
        }else{
            input_comment.classList.add('d-none');
            const reject_comment = document.getElementById('reject-comment');
            reject_comment.disabled = false;
            reject_comment.required = true;
            const inputText = document.getElementById('more_comment');
            inputText.disabled = true;
            inputText.required = false;
            checkbox.forEach((e) => {e.required = false});
        }
    }

    function ageCal(birthday) {
        var dateParts = birthday.split('-');
        var selectedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]); // Month is 0-based
        var currentDate = new Date();
        var buddhistCurrentYear = currentDate.getFullYear() + 543;
        var age = buddhistCurrentYear - (selectedDate.getFullYear());
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }
        if (age < 0) {
            document.getElementById('age').innerText = "วันเกิดไม่ถูกต้อง";
        } else {
            document.getElementById('age').innerText = age+' ปี';
        }
    }
</script>
    
@endsection
