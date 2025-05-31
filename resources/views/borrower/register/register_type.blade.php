@extends('layout')
@section('title')
ยื่นกู้
@endsection
@section('style')
    <style>

        .label {
            height: 100%;
            width: 100%;
        }

        .nav-link.active {
            background-color: #4382FB;
            -webkit-clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
            clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
            color: white !important;
        }

    </style>
@endsection
@section('content')
<section >
    <div class="card mb-3">
        <div class="card-body pb-0 mb-0">
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 1)
                        <a class="nav-link text-dark text-center m-0 active" id="borrower-type-tab" href="{{route('borrower.register.type')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 2)
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}"></i>ส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="#"><i class="bi bi-lock"></i>ส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 3)
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.result')}}"></i>สรุปการส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>สรุปการส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if($step >= 4)
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.recheck')}}"></i>ตรวจสอบเอกสารของระบบ</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>ตรวจสอบเอกสารของระบบ</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 5)
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="{{route('borrower.register.status')}}"></i>สถานะคำร้อง</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="#"><i class="bi bi-lock"></i>สถานะคำร้อง</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ท่านเคยกู้ยืมกับมหาวิทยาลัยหรือไม่</h5>
            <form id="register-type-form" class="row" action="{{route('borrower.register.store.type')}}" method="POST">
                @csrf
                <div class="col-md-12 mx-3">
                    <div class="form-check">
                        <label class="form-check-label" for="new-borrower">
                            <b>เป็นผู้กู้ยืมรายใหม่</b>
                        </label>
                        <input class="form-check-input" type="radio" name="register_type" id="new-borrower" value="1" onchange="selcetedRadio(this.value)" @checked($borrower_register_type != null && $borrower_register_type['type_id'] == '1')>
                    </div>
                </div>
                <div class="col-md-10 pt-3 mx-3">
                    <div class="form-check">
                        <label class="form-check-label" for="old-borrower">
                            <b>เป็นผู้กู้ยืมรายเก่า</b>
                        </label>
                        <input class="form-check-input" type="radio" name="register_type" id="old-borrower" value="2" onchange="selcetedRadio(this.value)" @checked($borrower_register_type != null && $borrower_register_type['type_id'] == '2')>
                        <label for="times" class="form-label">โดยกู้ยืมในระดับอุดมศึกษาครั้งนี้ครั้งที่</label>
                        <input type="text" class="mx-2 col-md-1 col-3" name="times" id="times" @disabled($borrower_register_type == null || $borrower_register_type['type_id']  == '1') value="{{ (isset( $borrower_register_type['type_id'])  && $borrower_register_type['times'] != null ) ?  $borrower_register_type['times'] : '' }}">
                        <div id="invalid-time" class="invalid-feedback">
                            กรุณากรอกจำนวนครั้งที่กู้
                        </div>
                    </div>
                </div>

                <div id="invalid-radio" class="invalid-feedback mx-3">
                    กรุณากรอกฟอร์ม
                </div>

                <div class="text-end pt-3">
                    <button type="button" id="submitRegisterTypeId" class="btn btn-primary w-25" onclick="submitForm(this.id)">ถัดไป</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        function selcetedRadio(value){
            const input_text = document.getElementById('times')
            if(value == '1'){
                input_text.disabled = true;
                input_text.required = false;
            }else if (value = '2'){
                input_text.disabled = false;
                input_text.required = true;
            }
        }

        async function submitForm(button_id){
            var validated = await formValidate();
            const submit_button =  document.getElementById(button_id);
            
            submit_button.disabled = true;
            console.log(validated);
            if(validated){
                const form = document.getElementById('register-type-form');
                form.submit();
            }else{
                submit_button.disabled = false;
                window.scrollTo(0, 0);
            }
        }

        async function formValidate(){
            const form = document.getElementById('register-type-form');
            var input_text = form.querySelector('input[type="text"][required]')
            var validator = true;
            if(input_text){
                var invalid_element = document.getElementById('invalid-time');
                if(input_text.value == ''){
                    validator = false;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            }
            if( ! await validateRadio(displayInvalid)){
                validator = false;
            }

            return validator;
        }

        async function validateRadio(displayer){
            const radios = document.getElementsByName('register_type');
            let isChecked = false;
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    isChecked = true;
                    break;
                }
            }

            validator = await displayer((!isChecked) ? true : false)
            return validator;
        }

        function displayInvalid(isChecked){
            if (isChecked) {
                var invalid_element = document.getElementById('invalid-radio');
                validator = false;
                if(invalid_element)invalid_element.classList.add('d-inline');
                return false;
            }else{
                if(invalid_element)invalid_element.classList.remove('d-inline');
                return true;
            }

        }
    </script>
@endsection