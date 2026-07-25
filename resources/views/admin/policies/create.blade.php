@extends('layout')
@section('title')
ร่างนโยบาย
@endsection
@section('content')
    <div class="section dashboard">
        <h4 class="mb-3">
            ร่างนโยบาย
        </h4>
        <form method="POST" action="{{ route('admin.policies.store') }}" id="create-policy">
            @csrf
            <div class="card">
                <div class="card-body mt-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">
                                ประเภท
                            </label>

                            <select name="type" class="form-select">

                                <option value="terms">
                                    Terms of Use
                                </option>

                                <option value="privacy">
                                    Privacy Policy
                                </option>

                                <option value="pdpa">
                                    PDPA Notice
                                </option>

                            </select>

                        </div>
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                เวอร์ชัน
                            </label>

                            <input type="text" name="version" class="form-control" value="1.0.0" required>

                            <div class="invalid-feedback">
                                กรุณากรอกเวอร์ชัน
                            </div>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                ชื่อนโยบาย
                            </label>

                            <input type="text" name="title" class="form-control" required>

                            <div class="invalid-feedback">
                                กรุณากรอกชื่อนโยบาย
                            </div>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                เนื้อหา
                            </label>
                            <textarea name="content_html" id="editor" class="form-control" rows="15" required ></textarea>

                            <div class="invalid-feedback text-area">
                                กรุณากรอกเนื้อหา
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.policies.index') }}" class="btn btn-secondary">
                        ยกเลิก
                    </a>
                      <button id="create-pilicy-button" type="button" class="btn btn-primary" onclick="submitForm('create-policy', this.id)">
                        บันทึกฉบับร่าง
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
        
        async function submitForm(form_id, buttonId){
            const submitButton = document.querySelector(`#${buttonId}`)
            submitButton.disabled = true;

            let validator = await validateForm(form_id);
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
            let input_textarea = form.querySelector('textarea[required]');
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
                let invalid_element = form.querySelector('.text-area');
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
