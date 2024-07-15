@extends('layout')
@section('title')
ข้อมูลผู้แทนโดยชอบธรรม
@endsection
@section('content')
<section class="main-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ข้อมูลผู้แทนโดยชอบธรรม</h5>
            <form action="{{route('borrower.store.main_parent.information')}}" id="main-parent-form" class="" method="POST">
                @csrf
                <fieldset class="row my-3">
                    <label class="form-label" for="main_parent">
                        <h6 class="text-primary">เลือกผู้แทนโดยชอบธรรม</h6>
                    </label>
                    @foreach($parents as $parent)
                    <div class="col-md-12 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="main_parent" id="parent{{ $loop->index }}_is_main_parent" value="{{$parent->id}}" required onchange="SelctMainParent(this.value)" >
                            <label class="form-check-label" for="parent{{ $loop->index }}_is_main_parent" id="label_parent{{ $loop->index }}_is_main_parent">
                                {{$parent->prefix}}{{$parent->firstname}} {{$parent->lastname}}
                            </label>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-12 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="main_parent" id="parent3_is_main_parent" value="parent3" required onchange="SelctMainParent(this.value)">
                            <label class="form-check-label" for="parent3_is_main_parent" id="label_parent3_is_main_parent">
                            อื่นๆ
                            </label>
                        </div>
                    </div>
                    <div id="invalid-main_parent" class="invalid-feedback">
                        กรุณาเลือกผู้แทนโดยชอบธรรม
                    </div>
                </fieldset>

                <div id="input-parent3-area" class="row col-12" >

                </div>

                <div class="col-12 row m-0 p-0">
                    <div class="col-md-8 col-sm-12"></div>
                    <div class="col-md-4 col-sm-12">
                        <button type="button" class="btn btn-primary w-100" onclick="submitForm('main-parent-form')">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    function togetherAddress() {
        address_currently_with_borrower = document.getElementById('address_currently_with_borrower');
        if (address_currently_with_borrower.checked) {
            console.log('checked')
            const address_input = document.querySelectorAll('.for-disabled');
            address_input.forEach((e)=>{
                e.disabled = true;
                e.required = false;
                e.value = "";
            });
        } else {
            const address_input = document.querySelectorAll('.for-disabled');
            address_input.forEach((e)=>{
                e.disabled = false;
                e.required = true;
                e.value = "";
            });
        }
    }

    function addressWithZipcode(zip_code_input, caller){
        fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_tambon.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.length == 0){
                console.log('no data');
            }
            var tambons = [];
            var aumphureId = '';
            for(tambon of data){
                if(zip_code_input == tambon.zip_code){
                    // console.log(tambon.name_th)
                    tambons.push(tambon.name_th.toString());
                    if(aumphureId == '')aumphureId = tambon.amphure_id;
                }
            }
            // console.log(tambons);
            var selectElement = document.getElementById(`${caller}_tambon`);
            selectElement.innerHTML ='<option disabled selected value="">เลือกตำบล</option>';
            for(tb of tambons){
                var newOption = document.createElement('option');
                newOption.value = tb;
                newOption.text = tb;
                selectElement.add(newOption);
            }
            getAumphure(aumphureId,caller)
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    function getAumphure(amphure_id,caller){
        // console.log(amphure_id);
        fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_amphure.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(aumphures => {
                var province_id = '';
                for(aumphure of aumphures){
                    if(amphure_id == aumphure.id){
                    document.getElementById(`${caller}_aumphure`).value = aumphure.name_th;
                    if(province_id == '')province_id = aumphure.province_id;
                    }
                }
                getProvince(province_id,caller);
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    function getProvince(province_id,caller){
        // console.log(province_id);
        fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(provinces => {
                for(province of provinces){
                    if(province_id == province.id)document.getElementById(`${caller}_province`).value = province.name_th;
                }
                
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    function enableInputCountry(parentNo,isthai){
        if(isthai == `${parentNo}_not_thai`){
            document.querySelector(`#div_${parentNo}_citizen_id`).innerHTML=`<input type="text" class="form-control" id="${parentNo}_citizen_id" name="${parentNo}_citizen_id" required>`
            document.querySelector(`#${parentNo}_nationality`).disabled = false;
            document.querySelector(`#${parentNo}_nationality`).required = true;
        }else{
            document.querySelector(`#div_${parentNo}_citizen_id`).innerHTML=`<input type="text" class="form-control" id="${parentNo}_citizen_id" name="${parentNo}_citizen_id" maxlength="17" oninput="formatThaiID(this)" required>`
            document.querySelector(`#${parentNo}_nationality`).disabled = true;
            document.querySelector(`#${parentNo}_nationality`).required = false;
        }
    }

    function parentRelational(parent,relation){
        var parentRelational = document.getElementById(`${parent}_custom_relational`);
        if(relation != 'บิดา' && relation != 'มารดา'){
            parentRelational.disabled = false;
            parentRelational.required = true;
            document.getElementById(`${parent}_relational`).value = '';
        }else{
            parentRelational.disabled = true;
            parentRelational.required = false;
            parentRelational.value = '';
            document.getElementById(`${parent}_relational`).value = relation;
        }
    }

    function setCustomRelational(parent,customRelation){
        document.getElementById(`${parent}_relational`).value = customRelation;
    }

    function ageCal(role) {
        var inputBirthday = document.getElementById(role + '_birthday');
        var birthDate = inputBirthday.value;
        var dateParts = birthDate.split('-');
        var selectedDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Month is 0-based
        var currentDate = new Date();
        var buddhistCurrentYear = currentDate.getFullYear() + 543;
        var age = buddhistCurrentYear - (selectedDate.getFullYear());
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }
        if (age < 0) {
            document.getElementById(role + '_age').value = "สวัสดีผู้มาจากอนาคต";
        } else {
            document.getElementById(role + '_age').value = age;
        }
    }

    function formatThaiID(input) {
        if(input.name == 'citizen_id'){
            const digits = input.value.replace(/\D/g, '');
            const formatted = digits.replace(
                /^(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})$/,
                '$1-$2-$3-$4-$5'
            );
            input.value = formatted;
        }else{
            var parent = '3';
            var parent_is_thai = document.getElementById(`parent${parent}_is_thai`).checked;

            if(parent_is_thai){
                input.maxlength = '17';
                const digits = input.value.replace(/\D/g, '');
                const formatted = digits.replace(
                    /^(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})$/,
                    '$1-$2-$3-$4-$5'
                );
                input.value = formatted;
            }
        }
    }

    function formatIncome(input) {
        // ลบตัวอักษรที่ไม่ใช่ตัวเลขและคอมมา
        const digits = input.value.replace(/[^\d]/g, '');

        // แบ่งกลุ่มตัวเลขเป็นสามหลักจากขวาไปซ้ายและใส่คอมมา
        const formatted = digits.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ','
        );
        input.value = formatted;
    }

    async function submitForm(formId){
        var validator = await validateForm(formId);
        if(validator){
            document.getElementById(formId).submit();
        }else{
            alert('ดูเหมือนว่าท่านยังกรอกข้อมูลไม่ครบ! กรุณาตรวจสอบอีกครั้ง');
            window.scrollTo(0,0);
        }
    }

    async function validateForm(formId){
        var form = document.getElementById(formId);
        var input_text = form.querySelectorAll('input[type="text"][required]');
        var input_select = form.querySelectorAll('select[required]');
        var input_radio = form.querySelectorAll('input[type="radio"][required]');
        var validator = true;
        var radio_stack_name = [];

        await input_text.forEach(input => {
            var invalid_element = input.nextElementSibling;
            if(input.value == ''){
                validator = false;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        await input_select.forEach(input => {
            var invalid_element = input.nextElementSibling;
            if(input.value == ''){
                validator = false;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        await input_radio.forEach(input => {
            if(radio_stack_name.includes(input.name.toString())){
                return;
            }else{
                radio_stack_name.push(input.name.toString())
                var invalid_element = document.getElementById('invalid-'+input.name.toString());
                if(validateRadio(input.name.toString())){
                    validator = false;
                    if(invalid_element)invalid_element.classList.add('d-inline');
                }else{
                    if(invalid_element)invalid_element.classList.remove('d-inline');
                }
            }
        });

        return validator;
    }

    function validateRadio(name) {
        const radios = document.getElementsByName(name);
        let isChecked = false;

        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                isChecked = true;
                break;
            }
        }

        if (!isChecked) {
            return true; // Prevent form submission
        } else {
            return false; // Allow form submission
        }
    }

    function SelctMainParent(main_parent){
        var parent3_area = document.getElementById('input-parent3-area');
        if(main_parent == 'parent3'){
            parent3_area.innerHTML = input_parent3();
            $("#parent3_birthday").datetimepicker({
                disabled:false,
                format: 'd-m-Y', 
                timepicker: false, 
                yearOffset: 543, 
                closeOnDateSelect: true,
            });
        }else{
            parent3_area.innerHTML = '';
        }
    }

    function input_parent3(){

        return `
        <label class="form-label" for="main_parent">
            <h6 class="text-primary">กรอกข้อมูลผู้แทนโดยชอบธรรม</h6>
        </label>
        <fieldset class="row mb-3 mt-2">
            <div class="col-md-3 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_is_thai" id="parent3_is_thai" value="ไทย" required onchange="enableInputCountry('parent3',this.value)">
                    <label class="form-check-label" for="parent3_is_thai">
                        สัญชาติไทย
                    </label>
                </div>
            </div>
            <div class="col-md-1 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_is_thai" id="parent3_not_thai" value="parent3_not_thai" required onchange="enableInputCountry('parent3',this.value)">
                    <label class="form-check-label" for="parent3_not_thai">
                        อื่นๆ
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="parent3_nationality" id="parent3_nationality" placeholder="กรอกสัญชาติ" disabled>
                <div class="invalid-feedback">
                    กรุณากรอกกรอกสัญชาติ
                </div>
            </div>
            <div id="invalid-parent3_is_thai" class="invalid-feedback">
                กรุณาเลือกสัญชาติ
            </div>
        </fieldset>
        <fieldset class="row mb-3 mt-3" id="thaiperson">
            <div class="col-md-3 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_alive" id="parent3_is_alive" value="true" required>
                    <label class="form-check-label" for="parent3_is_alive">
                    ยังมีชีวิตอยู่
                    </label>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_alive" id="parent3_no_alive" value="false" required>
                    <label class="form-check-label" for="parent3_no_alive">
                    ถึงแก่กรรม
                    </label>
                </div>
            </div>
            <div id="invalid-parent3_alive" class="invalid-feedback">
                กรุณาเลือกสถานภาพ
            </div>
        </fieldset>


        <label for="parent3_relational" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
        <fieldset class="row mb-3">
            <div class="col-md-12 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_relational_option"  value="บิดา" onchange="parentRelational('parent3',this.value)" required>
                    <label class="form-check-label">
                        บิดา
                    </label>
                </div>
            </div>
            <div class="col-md-12 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_relational_option"  value="มารดา" onchange="parentRelational('parent3',this.value)" required>
                    <label class="form-check-label">
                        มารดา
                    </label>
                </div>
            </div>
            <div class="col-md-1 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent3_relational_option" value="อื่นๆ" onchange="parentRelational('parent3',this.value)" required>
                    <label class="form-check-label">
                        อื่นๆ
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="parent3_custom_relational" onblur="setCustomRelational('parent3',this.value)" disabled>
                <div class="invalid-feedback">
                    กรุณากรอกความเกี่ยวข้องกับผู้กู้
                </div>
                <input type="hidden" id="parent3_relational" name="parent3_relational" required>
            </div>
            <div id="invalid-parent3_relational_option" class="invalid-feedback">
                กรุณาเลือกความเกี่ยวข้องกับผู้กู้
            </div>
        </fieldset>

        {{-- <div class="col-md-10"></div> --}}

        <div class="col-md-2 mb-3">
            <label for="parent3_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
            <select id="parent3_prefix" name="parent3_prefix" class="form-select" aria-label="Default select example" required>
                <option disabled selected  value="">เลือกคำนำหน้าชื่อ</option>
                <option value="นาย">นาย</option>
                <option value="นาง">นาง</option>
                <option value="นางสาว">นางสาว</option>
            </select>
            <div class="invalid-feedback">
                กรุณาเลือกคำนำหน้าชื่อ
            </div>
        </div>
        <div class="col-md-10"></div>

        <div class="col-md-5 mb-3">
            <label for="parent3_firstname" class="form-label text-secondary">ชื่อ</label>
            <input type="text" class="form-control" id="parent3_firstname" name="parent3_firstname" required>
            <div class="invalid-feedback">
                กรุณากรอกชื่อ
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_lastname" class="form-label text-secondary">นามสกุล</label>
            <input type="text" class="form-control" id="parent3_lastname" name="parent3_lastname" required>
            <div class="invalid-feedback">
                กรุณากรอกนามสกุล
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
            <div class="input-group date" id="">
                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                <input type="text" name="parent3_birthday" id="parent3_birthday" class="form-control"
                    placeholder="วว/ดด/ปปปป" onchange="ageCal('parent3')" required />
                <div class="invalid-feedback">
                    กรุณากรอกวันเกิด
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="parent3_age" class="form-label text-secondary">อายุ</label>
            <input type="text" class="form-control" id="parent3_age" name="parent3_age" required>
            <div class="invalid-feedback">
                กรุณากรอกอายุ
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
            <div id="div_parent3_citizen_id">
                <input type="text" class="form-control" id="parent3_citizen_id" name="parent3_citizen_id" maxlength="17" oninput="formatThaiID(this)" required>
                <div class="invalid-feedback">
                    กรุณากรอกเลขบัตรประชาชน 13 หลัก
                </div>
            </div>
        </div>
        <div class="col-md-7"></div>
        <div class="col-md-5 mb-3">
            <label for="parent3_email" class="form-label text-secondary">อีเมลล์</label>
            <input type="text" class="form-control" id="parent3_email" name="parent3_email" required>
            <div class="invalid-feedback">
                กรุณากรอกอีเมลล์
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
            <input type="text" class="form-control" id="parent3_phone" name="parent3_phone" required>
            <div class="invalid-feedback">
                กรุณากรอกเบอร์โทรศัพท์
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_occupation" class="form-label text-secondary">อาชีพ</label>
            <input type="text" class="form-control" id="parent3_occupation" name="parent3_occupation" required>
            <div class="invalid-feedback">
                กรุณากรอกอาชีพ
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_place_of_work" class="form-label text-secondary">สถานที่ทำงาน</label>
            <input type="text" class="form-control" id="parent3_place_of_work" name="parent3_place_of_work" required>
            <div class="invalid-feedback">
                กรุณากรอกสถานที่ทำงาน
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <label for="parent3_income" class="form-label text-secondary">รายได้ต่อปี</label>
            <input type="text" class="form-control" id="parent3_income" name="parent3_income" oninput="formatIncome(this)" placeholder="1,000,000" required>
            <div class="invalid-feedback">
                กรุณากรอกรายได้ต่อปี
            </div>
        </div>

        <label class="form-label mt-3" for="">
            <h6 class="text-primary">ข้อมูลที่อยู่ผู้แทนโดยชอบธรรม</h6>
        </label>

        <div class="col-md-5 mt-3 mb-3">
        <div class="form-check">
                <label class="form-check-label" for="address_currently_with_borrower">
                    ที่อยู่เดียวกันกับผู้กู้
                </label>
                <input class="form-check-input" type="checkbox" id="address_currently_with_borrower" name="address_with_borrower" value="true" onchange="togetherAddress()">
        </div>
        </div>
        <div class="col-md-7"></div>

        <div class="col-md-5 mb-3">
            <label for="parent3_village" class="form-label text-secondary">หมู่บ้าน</label>
            <input type="text" class="form-control for-disabled" id="parent3_village" name="parent3_village" required>
            <div class="invalid-feedback">
                กรุณากรอกหมู่บ้าน
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <label for="parent3_house_no" class="form-label text-secondary">บ้านเลขที่</label>
            <input type="text" class="form-control for-disabled" id="parent3_house_no" name="parent3_house_no" required>
            <div class="invalid-feedback">
                กรุณากรอกบ้านเลขที่
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <label for="parent3_village_no" class="form-label text-secondary">หมู่ที่</label>
            <input type="text" class="form-control for-disabled" id="parent3_village_no" name="parent3_village_no" required>
            <div class="invalid-feedback">
                กรุณากรอกหมู่ที่
            </div>
        </div>

        <div class="col-md-5 mb-3">
            <label for="parent3_street" class="form-label text-secondary">ซอย</label>
            <input type="text" class="form-control for-disabled" id="parent3_street" name="parent3_street" required>
            <div class="invalid-feedback">
                กรุณากรอกซอย
            </div>
        </div>

        <div class="col-md-5 mb-3">
            <label for="parent3_road" class="form-label text-secondary">ถนน</label>
            <input type="text" class="form-control for-disabled" id="parent3_road" name="parent3_road" required>
            <div class="invalid-feedback">
                กรุณากรอกถนน
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <label for="parent3_postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
            <input type="text" class="form-control for-disabled" id="parent3_postcode" name="parent3_postcode" onblur="addressWithZipcode(this.value,'parent3')" required>
            <div class="invalid-feedback">
                กรุณากรอกรหัสไปรษณีย์
            </div>
        </div>
        <div class="col-md-9"></div>

        <div class="col-md-5 mb-3">
            <label for="parent3_province" class="form-label text-secondary">จังหวัด</label>
            <input type="text" class="form-control for-disabled" id="parent3_province" name="parent3_province" required>
            <div class="invalid-feedback">
                กรุณากรอกจังหวัด
            </div>
        </div>

        <div class="col-md-5 mb-3">
            <label for="parent3_aumphure" class="form-label text-secondary">อำเภอ</label>
            <input type="text" class="form-control for-disabled" id="parent3_aumphure" name="parent3_aumphure" required>
            <div class="invalid-feedback">
                กรุณากรอกอำเภอ
            </div>
        </div>

        <div class="col-md-5 mb-3">
            <label for="parent3_tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
            <select id="parent3_tambon" name="parent3_tambon" class="form-select for-disabled" aria-label="Default select example" required>
                <option disabled selected value="">เลือกตำบล</option>
            </select>
            <div class="invalid-feedback">
                กรุณากรอกตำบล
            </div>
        </div>

        `;
    }

    

</script>
@endsection