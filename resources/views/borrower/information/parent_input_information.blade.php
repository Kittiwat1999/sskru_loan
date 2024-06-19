@extends('layout')
@section('title')
กรอหข้อมูลผู้ปกครอง
@endsection
@section('content')
<section class="main-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ข้อมูลผู้ปกครอง</h5>
            <form action="{{route('borrower.store.parent.information')}}" id="parent-form" class="row" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <fieldset class="row mb-3">
                    <div class="col-md-3 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_is_thai" value="ไทย" required onchange="enableInputCountry('parent1',this.value)">
                            <label class="form-check-label" for="parent1_is_thai">
                            สัญชาติไทย
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_not_thai" value="parent1_not_thai" required onchange="enableInputCountry('parent1',this.value)">
                            <label class="form-check-label" for="parent1_not_thai">
                                อื่นๆ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="parent1_nationality" id="parent1_nationality" placeholder="กรอกสัญชาติ" disabled>
                    </div>
                    <div class="invalid-feedback">
                        กรุณากรอก
                    </div>
                    <div id="invalid-parent1_is_thai" class="invalid-feedback">
                        กรุณาเลือกสัญชาติ
                    </div>
                </fieldset>
            
                <fieldset class="row mb-3 mt-3" id="thaiperson">
                    <div class="col-md-3 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_alive" id="parent1_is_alive" value="true" required>
                            <label class="form-check-label" for="parent1_is_alive">
                            ยังมีชีวิตอยู่
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_alive" id="parent1_no_alive" value="false" required>
                            <label class="form-check-label" for="parent1_no_alive">
                            ถึงแก่กรรม
                            </label>
                        </div>
                    </div>
                    <div id="invalid-parent1_alive" class="invalid-feedback">
                        กรุณาเลือกสถานภาพ
                    </div>
                </fieldset>
            
                <label for="parent1_relational" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
                <fieldset class="row mb-3">
                    <div class="col-md-12 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_relational_option"  value="บิดา" onchange="parentRelational('parent1',this.value)" required>
                            <label class="form-check-label">
                                บิดา
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_relational_option"  value="มารดา" onchange="parentRelational('parent1',this.value)" required>
                            <label class="form-check-label">
                                มารดา
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent1_relational_option" value="อื่นๆ" onchange="parentRelational('parent1',this.value)" required>
                            <label class="form-check-label">
                                อื่นๆ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="parent1_custom_relational" onblur="setCustomRelational('parent1',this.value)" disabled>
                        <div class="invalid-feedback">
                            กรุณากรอกความเกี่ยวข้องกับผู้กู้
                        </div>
                        <input type="hidden" id="parent1_relational" name="parent1_relational" required>
                    </div>
                    <div id="invalid-parent1_relational_option" class="invalid-feedback">
                        กรุณาเลือกความเกี่ยวข้องกับผู้กู้
                    </div>
                </fieldset>
            
                <div class="col-md-2 mb-3">
                    <label for="parent1_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                    <select id="parent1_prefix" name="parent1_prefix" class="form-select" aria-label="Default select example" required>
                        <option disabled selected value="">เลือกคำนำหน้าชื่อ</option>
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
                    <label for="parent1_firstname" class="form-label text-secondary">ชื่อ</label>
                    <input type="text" class="form-control" id="parent1_firstname" name="parent1_firstname" required>
                    <div class="invalid-feedback">
                        กรุณากรอกชื่อ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_lastname" class="form-label text-secondary">นามสกุล</label>
                    <input type="text" class="form-control" id="parent1_lastname" name="parent1_lastname" required>
                    <div class="invalid-feedback">
                        กรุณากรอกนามสกุล
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                    <div class="input-group date" id="">
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                        <input type="text" name="parent1_birthday" id="parent1_birthday" class="form-control"
                            placeholder="วว/ดด/ปปปป" onchange="ageCal('parent1')" required/>
                        <div class="invalid-feedback">
                            กรุณากรอกวันเกิด
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="parent1_age" class="form-label text-secondary">อายุ</label>
                    <input type="text" class="form-control" id="parent1_age" name="parent1_age" required>
                    <div class="invalid-feedback">
                        กรุณากรอกอายุ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                    <div id="div_parent1_citizen_id">
                        <input type="text" class="form-control" id="parent1_citizen_id" name="parent1_citizen_id" maxlength="17" oninput="formatThaiID(this)" required>
                        <div class="invalid-feedback">
                            กรุณากรอกเลขบัตรประชาชน 13 หลัก
                        </div>
                    </div>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_email" class="form-label text-secondary">อีเมลล์</label>
                    <input type="text" class="form-control" id="parent1_email" name="parent1_email" required>
                    <div class="invalid-feedback">
                        กรุณากรอกอีเมลล์
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="parent1_phone" name="parent1_phone" required>
                    <div class="invalid-feedback">
                        กรุณากรอกเบอร์โทรศัพท์
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_occupation" class="form-label text-secondary">อาชีพ</label>
                    <input type="text" class="form-control" id="parent1_occupation" name="parent1_occupation" required>
                    <div class="invalid-feedback">
                        กรุณากรอกอาชีพ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_place_of_work" class="form-label text-secondary">สถานที่ทำงาน</label>
                    <input type="text" class="form-control" id="parent1_place_of_work" name="parent1_place_of_work" required>
                    <div class="invalid-feedback">
                        กรุณากรอกสถานที่ทำงาน
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent1_income" class="form-label text-secondary">รายได้ต่อปี</label>
                    <input type="text" class="form-control" id="parent1_income" name="parent1_income" oninput="formatIncome(this)" placeholder="1,000,000" required>
                    <div class="invalid-feedback">
                        กรุณากรอกรายได้ต่อปี
                    </div>
                </div>
                
                <!-- end dad information -->
            
            
                <!-- mom information -->
                <div class="col-md-12 mb-2 mt-3">
                    <h6 class="text-primary">คู่สมรสของผู้ปกครอง</h6>
                    <div class="col-md-11 line-section mt-2"></div>
                </div>
                <div class="col-md-5">
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="parent2_no_data" name="parent2_no_data" value="true" onclick="parenat2NoData()">
                        <label class="form-check-label  " for="parent2_no_data">
                        ไม่มีข้อมูล
                        </label>
                    </div>
                </div>
                <div class="col-md-7"></div>
                <fieldset class="row mb-3 mt-3">
                    <div class="col-md-3 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_is_thai" value="ไทย" required onchange="enableInputCountry('parent2',this.value)">
                            <label class="form-check-label" for="parent2_is_thai">
                            สัญชาติไทย
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_not_thai" value="parent2_not_thai" required onchange="enableInputCountry('parent2',this.value)">
                            <label class="form-check-label" for="parent2_not_thai">
                                อื่นๆ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="parent2_nationality" id="parent2_nationality" placeholder="กรอกสัญชาติ" disabled>
                        <div class="invalid-feedback">
                            กรุณากรอก
                        </div>
                    </div>
                    <div id="invalid-parent2_is_thai" class="invalid-feedback">
                        กรุณาเลือกสัญชาติ
                    </div>
                </fieldset>
                <fieldset class="row mb-3 mt-3" id="thaiperson">
                    <div class="col-md-3 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_is_alive" value="true" required>
                            <label class="form-check-label" for="parent2_is_alive">
                            ยังมีชีวิตอยู่
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_no_alive" value="false" required>
                            <label class="form-check-label" for="parent2_no_alive">
                            ถึงแก่กรรม
                            </label>
                        </div>
                    </div>
                    <div id="invalid-parent2_alive" class="invalid-feedback">
                        กรุณาเลือกสถานภาพ
                    </div>
                </fieldset>
            
                
                <label for="parent2_relational" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
                <fieldset class="row mb-3">
                    <div class="col-md-12 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_relational_option"  value="บิดา" onchange="parentRelational('parent2',this.value)" required>
                            <label class="form-check-label">
                                บิดา
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_relational_option"  value="มารดา" onchange="parentRelational('parent2',this.value)" required>
                            <label class="form-check-label">
                                มารดา
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 my-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parent2_relational_option" value="อื่นๆ" onchange="parentRelational('parent2',this.value)" required>
                            <label class="form-check-label">
                                อื่นๆ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="parent2_custom_relational" onblur="setCustomRelational('parent2',this.value)" disabled>
                        <div class="invalid-feedback">
                            กรุณากรอกความเกี่ยวข้องกับผู้กู้
                        </div>
                        <input type="hidden" id="parent2_relational" name="parent2_relational" required>
                    </div>
                    <div id="invalid-parent2_relational_option" class="invalid-feedback">
                        กรุณาเลือกความเกี่ยวข้องกับผู้กู้
                    </div>
                </fieldset>

                {{-- <div class="col-md-10"></div> --}}
            
                <div class="col-md-2 mb-3">
                    <label for="parent2_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                    <select id="parent2_prefix" name="parent2_prefix" class="form-select" aria-label="Default select example" required>
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
                    <label for="parent2_firstname" class="form-label text-secondary">ชื่อ</label>
                    <input type="text" class="form-control" id="parent2_firstname" name="parent2_firstname" required>
                    <div class="invalid-feedback">
                        กรุณากรอกชื่อ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_lastname" class="form-label text-secondary">นามสกุล</label>
                    <input type="text" class="form-control" id="parent2_lastname" name="parent2_lastname" required>
                    <div class="invalid-feedback">
                        กรุณากรอกนามสกุล
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                    <div class="input-group date" id="">
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                        <input type="text" name="parent2_birthday" id="parent2_birthday" class="form-control"
                            placeholder="วว/ดด/ปปปป" onchange="ageCal('parent2')" required/>
                        <div class="invalid-feedback">
                            กรุณากรอกวันเกิด
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="parent2_age" class="form-label text-secondary">อายุ</label>
                    <input type="text" class="form-control" id="parent2_age" name="parent2_age" required>
                    <div class="invalid-feedback">
                        กรุณากรอกอายุ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                    <div id="div_parent2_citizen_id">
                        <input type="text" class="form-control" id="parent2_citizen_id" name="parent2_citizen_id" maxlength="17" oninput="formatThaiID(this)" required>
                        <div class="invalid-feedback">
                            กรุณากรอกเลขบัตรประชาชน 13 หลัก
                        </div>
                    </div>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_email" class="form-label text-secondary">อีเมลล์</label>
                    <input type="text" class="form-control" id="parent2_email" name="parent2_email" required>
                    <div class="invalid-feedback">
                        กรุณากรอกอีเมลล์
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="parent2_phone" name="parent2_phone" required>
                    <div class="invalid-feedback">
                        กรุณากรอกเบอร์โทรศัพท์
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_occupation" class="form-label text-secondary">อาชีพ</label>
                    <input type="text" class="form-control" id="parent2_occupation" name="parent2_occupation" required>
                    <div class="invalid-feedback">
                        กรุณากรอกอาชีพ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_place_of_work" class="form-label text-secondary">สถานที่ทำงาน</label>
                    <input type="text" class="form-control" id="parent2_place_of_work" name="parent2_place_of_work" required>
                    <div class="invalid-feedback">
                        กรุณากรอกสถานที่ทำงาน
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="parent2_income" class="form-label text-secondary">รายได้ต่อปี</label>
                    <input type="text" class="form-control" id="parent2_income" name="parent2_income" oninput="formatIncome(this)" placeholder="1,000,000" required>
                    <div class="invalid-feedback">
                        กรุณากรอกรายได้ต่อปี
                    </div>
                </div>
                 <!-- maritalStatus -->
                <fieldset class="row my-4" id="maritalStatusId">
                    <h5 class="text-primary">สถานภาพสมรสของผู้ปกครอง</h5>
                    <div class="col-md-11 line-section mt-2 mb-2"></div>
                    <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="marital_status" id="option1" value="อยู่ด้วยกัน" required>
                            <label class="form-check-label" for="option1">
                            อยู่ด้วยกัน
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="marital_status" id="option2" value="แยกกันอยู่ตามอาชีพ" required>
                            <label class="form-check-label" for="option2">
                            แยกกันอยู่ตามอาชีพ
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-5 form-check">
                            <input class="form-check-input" type="radio" name="marital_status" id="devorce" value="หย่า" required>
                            <label class="form-check-label" for="devorce">
                            หย่า(แนบใบหย่า)
                            </label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <input disabled class="form-control" type="file" id="devorceFile" name="devorce_file"  accept=".jpg, .jpeg, .png, .pdf">
                                <div class="invalid-feedback">
                                    กรุณาเลือกไฟล์
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2 form-check">
                            <input class="form-check-input" type="radio" name="marital_status" id="other" value="other" required>
                            <label class="form-check-label" for="other">
                            อื่นๆ
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input disabled type="text" class="form-control" id="otherText" name="other_text">
                            <div class="invalid-feedback">
                                กรุณากรอกสถานภาพสมรสของผู้ปกครอง
                            </div>
                        </div>
                    </div>
                    <div id="invalid-marital_status" class="invalid-feedback">
                        กรุณาเลือกสถานภาพสมรสของผู้ปกครอง
                    </div>
                </fieldset>
                <!-- end maritalStatus -->
                <div class="col-12 row m-0 p-0">
                    <div class="col-md-8 col-sm-12"></div>
                    <div class="col-md-4 col-sm-12">
                        <button type="button" class="btn btn-primary w-100" onclick="submitForm('parent-form')">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
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
        if(relation == 'อื่นๆ'){
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
            var parent = (input.name == 'parent1_citizen_id') ? "1" : "2";
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

    function parenat2NoData(){
        const parent2_no_data = document.getElementById('parent2_no_data');
        var parent2_element = document.querySelectorAll(`#parent2_is_thai, 
                                                #parent2_not_thai, 
                                                #parent2_is_alive,
                                                #parent2_no_alive,
                                                #parent2_relational,
                                                #parent2_prefix,
                                                #parent2_firstname,
                                                #parent2_lastname,
                                                #parent2_birthday,
                                                #parent2_age,
                                                #parent2_citizen_id,
                                                #parent2_email,
                                                #parent2_phone,
                                                #parent2_occupation,
                                                #parent2_place_of_work,
                                                #parent2_income,
                                                #parent2_is_main_parent
                                                `);
        var parent2_relation = document.querySelectorAll('input[name="parent2_relational_option"]');
        console.log(parent2_relation);
        // disable of required
        if(parent2_no_data.checked){
            parent2_element.forEach((e)=>{
                e.disabled = true;
                e.required = false;
            });
            parent2_relation.forEach((e) => {
                e.disabled = true;
                e.required = false;
            });
        }else{
            parent2_element.forEach((e)=>{
                e.disabled = false;
                e.required = true;
            });
            parent2_relation.forEach((e) => {
                e.disabled = false;
                e.required = true;
            });
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

    const MaritalStat = document.getElementById('maritalStatusId');
    MaritalStat.onchange = () =>{
        const otherMaritalStat = document.getElementById('other');
        const otherText = document.getElementById('otherText');
        const invalidOtherText = otherText.nextElementSibling;
        if(otherMaritalStat.checked){
            otherText.disabled = false;
            otherText.required = true;
        }else{
            otherText.disabled = true;
            otherText.required = false;
            if(invalidOtherText)invalidOtherText.classList.remove('d-inline');
        }
        
        const devorce = document.getElementById('devorce');
        const devorceFile = document.getElementById('devorceFile');
        const invalidDevorceFile =  devorceFile.nextElementSibling;
        if(devorce.checked){
            devorceFile.disabled = false;
            devorceFile.required = true;
        }else{
            devorceFile.disabled = true;
            devorceFile.required = false;
            if(invalidDevorceFile)invalidDevorceFile.classList.remove('d-inline');
        }
    }

    async function submitForm(formId){
        var validator = await validateForm(formId);
        if(validator){
            document.getElementById(formId).submit();
        }
    }

    async function validateForm(formId){
        var form = document.getElementById(formId);
        var input_text = form.querySelectorAll('input[type="text"][required]');
        var input_select = form.querySelectorAll('select[required]');
        var input_radio = form.querySelectorAll('input[type="radio"][required]');
        var input_file = form.querySelector('#devorceFile');
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

        if(input_file.files.length == 0 && input_file.required == true){
            validator = false;
            var invalid_element = input_file.nextElementSibling;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else{
            var invalid_element = input_file.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

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

    $("#parent1_birthday").datetimepicker({
        disabled:false,
        format: 'd-m-Y', 
        timepicker: false, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });
    $("#parent2_birthday").datetimepicker({
        disabled:false,
        format: 'd-m-Y', 
        timepicker: false, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });
</script>
@endsection