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
            <h5 class="card-title">{{$child_document['child_document_title']}}</h5>
            <div class="container-fluid m-0 p-0 mb-3">
                <iframe src="{{route("check.document.preview.borrower_child_document_file", ['borrower_child_document_id' => Crypt::encryptString($borrower_child_document['id']) ])}}"></iframe>
            </div>
            @if($child_document['need_loan_balance'] || $child_document['need_document_code'])
            <div class="row m-0 p-0 border border-1 mb-3 pt-3">
                <div class="col-12">
                    <label class="text-dark fw-bold mb-3" for="">ข้อมูลที่แนบมากับเอกสาร</label>
                </div>
                @if($child_document['need_document_code'])
                <div class="col-md-12 row mb-4 mx-0 px-0">
                    <label for="document_code" class="col-sm-2 col-form-label text-dark">รหัสเอกสาร</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="document_code" name="education_fee"
                            @disabled(true)
                            value="{{$borrower_child_document['document_code']}}"
                            />
                    </div>
                </div>
                @endif
                @if($child_document['need_loan_balance'])
                <div class="col-md-12 row mb-3 mx-0 px-0">
                    <label for="education-fee" class="col-sm-2 col-form-label text-dark">ค่าเล่าเรียน</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="education-fee" name="education_fee"
                            @disabled(true)
                            value="{{number_format($borrower_child_document['education_fee'])}}"
                            />
                    </div>
                </div>
                <div class="col-md-12 row mb-3 mx-0 px-0">
                    <label for="living-exprenses" class="col-sm-2 col-form-label text-dark">ค่าครองชีพรวม</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="living-exprenses" name="living_exprenses"
                            @disabled(true)
                            value="{{number_format($borrower_child_document['living_exprenses'])}}"
                            />
                    </div>
                </div>
                @endif
            </div>
            @endif
            <form id="form-comment" class="border border-1 mb-4" action="{{route('check_document.post.borrower_child_document', ['borrower_child_document_id' => Crypt::encryptString($borrower_child_document['id']), 'borrower_document_id' => Crypt::encryptString($borrower_document_id) ] )}}" method="POST">
                @csrf
                <fieldset class="row mx-0 p-0 my-3">
                    <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                    <div class="col-sm-10 m-0 p-0">
                        <div id="invalid-radio" class="invalid-feedback mx-4">
                            กรุณากรอกความคิดเห็น
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="status-approve" value="approve" onchange="enableCheckbox(this.value)" required
                            @checked($borrower_child_document['status'] == 'approved')
                            />
                            <label class="form-check-label" for="status-approve">
                            เอกสารถูกต้อง
                            </label>
                        </div>
    
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-reject" value="reject" onchange="enableCheckbox(this.value)" required
                            @checked($borrower_child_document['status'] == 'rejected' || $borrower_child_document['status'] == 'response-reject' )
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
                            <input class="form-check-input" type="checkbox" name="comments[]" id="comment-{{$comment['id']}}" value="{{$comment['id']}}" disabled 
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
                                    value="{{($custom_comment != null) ? $custom_comment['other_comment'] : '' }}" 
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
                    <a href="{{route('check_document.borrower_child_document.list',['borrower_document_id' => Crypt::encryptString($borrower_document_id) ])}}" class="btn btn-light w-25">ย้อนกลับ</a>
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
    var borrower_child_document_status = @json($borrower_child_document['status']);
    if(borrower_child_document_status == 'approved'){
        enableCheckbox('approve');
    }else if (borrower_child_document_status == 'rejected' || borrower_child_document_status == 'response-reject') {
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
