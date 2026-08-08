@extends('layouts.app')
@section('title')
แก้ไขนโยบาย
@endsection
@section('content')
    <div class="section dashboard">
        <h4>
            แก้ไขนโยบาย
        </h4>
        <form id="edit-policy-form" method="POST" action="{{ route('admin.policies.update', $policy) }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body mt-4 row">
                    <input type="hidden" name="type" class="form-control" value="{{ $policy->type }}"> 

                    <div class="col-12 mb-3">
                        <label>
                            ชื่อนโยบาย
                        </label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $policy->title) }}" required>
                        <div class="invalid-feedback">
                            กรุณากรอกชื่อนโยบาย
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label>
                            เวอร์ชั่น
                        </label>
                        <input type="text" name="version" class="form-control" value="{{ old('version', $policy->version) }}" required>
                        <div class="invalid-feedback">
                            กรุณากรอกเวอร์ชัน
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label>
                            เนื้อหา
                        </label>
                        <textarea name="content_html" id="editor" class="form-control" required>
    
                            {{ old('content_html', $policy->content_html ?? '') }}

                        </textarea>
                        <div class="invalid-feedback invalid-text-area">
                            กรุณากรอกเนื้อหา
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.policies.index') }}" class="btn btn-secondary">
                            ย้อนกลับ
                        </a>
                        <button id="edit-poilicy-button" type="button" class="btn btn-primary" onclick="submitForm('edit-policy-form', this.id)">
                            บันทึก
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        let editor;

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(instance => {
                editor = instance;
            })
            .catch(console.error);

        async function submitForm(form_id, buttonId){
            const submitButton = document.querySelector(`#${buttonId}`)
            submitButton.disabled = true;
            editor.updateSourceElement();

            var validator = await validateForm(form_id);
            if(validator){
                document.getElementById(form_id).submit();
            }else{
                submitButton.disabled = false;
                alert('ดูเหมือนว่าท่านยังกรอกข้อมูลไม่ครบ! กรุณาตรวจสอบอีกครั้ง');
                window.scrollTo(0,0);
            }
        }

        async function validateForm(form_id){
            let form = document.getElementById(form_id);
            let input_text = form.querySelectorAll('input[type="text"][required]');
            let input_select = form.querySelectorAll('select[required]');
            let input_textarea = form.querySelector('#editor');
            let validator = true;
            await input_text.forEach(input => {
                if(input.value == ''){
                    validator = false;
                    let invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    let invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            });

            await input_select.forEach(input => {
                if(input.value == ''){
                    validator = false;
                    let invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    let invalid_element = input.nextElementSibling;
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            });

            if(input_textarea){
                let invalid_element = form.querySelector('.invalid-text-area');
                if(input_textarea.value == ''){
                    validator = false;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            }

            return validator;
        }

    </script>
@endsection
