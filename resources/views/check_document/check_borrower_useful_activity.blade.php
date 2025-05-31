@extends('layout')
@section('title')
ตรวจเอกสารผู้กู้
@endsection
@section('style')
<style>
        iframe {
        width: 100%;
        border: none;
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
            <h5 class="card-title">บันทึกกิจกรรมจิตอาสา</h5>
            <div class="container m-0 p-0 mb-3">
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
                                        <a class="btn btn-danger" href="{{route('borrower.show.usefulactivity.file' ,['useful_activity_id' => Crypt::encryptString($useful_activity->id)] )}}" rel="noopener noreferrer" target="_blank"><i class="bi bi-journal-bookmark" ></i></a>
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
                </div>
            </div>

            <form id="form-comment" class="border border-1 mb-4" action="{{route('check_document.post.borrower.useful_activity', ['borrower_document_id' => Crypt::encryptString($borrower_document['id']) ])}}" method="post">
                @csrf
                <fieldset class="row mx-0 p-0 my-3">
                    <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                    <div class="col-sm-10 m-0 p-0">
                        <div id="invalid-radio" class="invalid-feedback mx-4">
                            กรุณากรอกความคิดเห็น
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="status-approve" value="approve" onchange="enableCheckbox(this.value)" required
                            @checked($useful_activities_status['status'] == 'approved')
                            />
                            <label class="form-check-label" for="status-approve">
                            เอกสารถูกต้อง
                            </label>
                        </div>
    
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-reject" value="reject" onchange="enableCheckbox(this.value)" required
                            @checked($useful_activities_status['status'] == 'rejected' || $useful_activities_status['status'] == 'response-reject')
                            />
                            <label class="form-check-label" for="status-reject">
                            เอกสารไม่ถูกต้อง
                            </label>
                        </div>
                    </div>
                </fieldset>
    
                <div class="row m-0 p-0">
                    <div class="col-md-2"></div>
                    <div class="col-md-10 row m-0 p-0">
                        <div id="invalid-checkbox" class="invalid-feedback col-12 mx-2">
                            กรุณากรอกความคิดเห็น
                        </div>
                        @foreach($comments as $comment)
                        <div class="col-md-6 form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="comment-{{$comment['id']}}"  name="comments[]" value="{{$comment['id']}}" disabled 
                                @checked(in_array($comment['id'], $comments_db))
                            />
                            <label class="form-check-label" for="comment-{{$comment['id']}}">
                                {{$comment['comment']}}
                            </label>
                        </div>
                        @endforeach
                        <div class="col-md-6 m-0 p-0 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="more_comment_check" name="more_comment_check" value="true" onchange="enableInputText(this)" disabled
                                    @checked($custom_comment != null)
                                />
                                <label class="form-check-label" for="more_comment_check">
                                    อื่นๆ
                                </label>
                            </div>
                            <div class="input-group">
                                <label for="gpa_moreText"></label>
                                <input class="form-control" type="text" name="more_comment_text" id="more_comment_text" 
                                    @disabled($custom_comment == null) 
                                    value="{{($custom_comment != null) ? $custom_comment['custom_comment'] : '' }}" 
                                />
                                <div class="invalid-feedback">
                                    กรุณากรอกความคิดเห็น
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
            </form>
            <div class="row m-0 p-0">
                <div class="text-start col-6 m-0 p-0">
                    <a href="{{route('check_document.borrower_child_document.list',['borrower_document_id' => Crypt::encryptString($borrower_document['id']) ])}}" class="btn btn-light w-25">ย้อนกลับ</a>
                </div>
                <div class="text-end col-6 m-0 p-0">
                    <button type="button" class="btn btn-primary col-4 col-md-2" onclick="submitForm('form-comment')">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>

    var useful_activities_status = @json($useful_activities_status['status']);
    if(useful_activities_status == 'approved'){
        enableCheckbox('approve');
    }else if (useful_activities_status == 'rejected' || useful_activities_status == 'response-reject') {
        enableCheckbox('reject');
    }
    function enableCheckbox(status) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const input_text = document.getElementById('more_comment_text');
        if(status == 'approve'){
            input_text.disabled = true;
            input_text.required = false;
            checkboxes.forEach((e) => {
                e.disabled = true;
                e.required = false;
                e.checked = false;
            });
        }else{
            checkboxes.forEach((e) => {
                e.disabled = false;
                e.required = true;
            });
        }
    }

    function enableInputText(more_checkbox){
        const input_text = document.getElementById('more_comment_text');
        if(more_checkbox.checked == true){
            input_text.disabled = false;
            input_text.required = true;
        }else{
            input_text.disabled = true;
            input_text.required = false;
            input_text.value = '';
        }
    }

    async function submitForm(form_id){
        var validation = await validateForm(form_id);
        if(validation){
            const form = document.getElementById(form_id);
            form.submit();
        }else{
            alert('กรุณากรอกความเห็น');
        }
    }

    async function validateForm(form_id){
        const form = document.getElementById(form_id);
        const radios = form.querySelectorAll('input[type="radio"][required]');
        const checkboxes = form.querySelectorAll('input[type="checkbox"][required]');
        const input_text = document.querySelector('input[type="text"][required]');
        var validator = true;

        if(input_text){
            if(input_text.value == ''){
                validator = false;
                var invalid_element = input_text.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input_text.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        }

        var validate_checkbox = (checkboxes.length != 0) ? await validateCheckBox(checkboxes) : true;
        if(!validate_checkbox){
            validator = false;
            var invalid_checkbox = document.getElementById('invalid-checkbox');
            if(invalid_checkbox)invalid_checkbox.classList.add('d-inline');
        }else{
            var invalid_checkbox = document.getElementById('invalid-checkbox');
            if(invalid_checkbox)invalid_checkbox.classList.add('d-none');
        }

        var validate_radio =  await validateRadio(radios);
        if(!validate_radio){
            validator = false;
            var invalid_radio = document.getElementById('invalid-radio');
            if(invalid_radio)invalid_radio.classList.add('d-inline');
        }else{
            var invalid_radio = document.getElementById('invalid-radio');
            if(invalid_radio)invalid_radio.classList.add('d-none');
        }

        return validator;
    }

    async function validateCheckBox(checkboxes){
        var checker = false;
        for(let i = 0; i < checkboxes.length; i ++){
            if(checkboxes[i].checked == true){
                checker = true;
                break;
            }
        }   
        return checker;
    }

    async function validateRadio(radio){
        var checker = false;
        await radio.forEach((e) => {
            if(e.checked){
                checker = true;
            }
        });
        return checker;
    }

</script>
@endsection