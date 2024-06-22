
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
            กรุณากรอกกรอกสัญชาติ
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