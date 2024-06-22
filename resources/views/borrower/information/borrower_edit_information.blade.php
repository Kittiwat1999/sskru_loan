@extends('layout')
@section('title')
แก้ใขข้อมูลผู้กู้
@endsection
@section('content')
<section class="main-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">แก้ใขข้อมูลผู้กู้</h5>
            <form action="{{route('borrower.edit.information')}}" id="borrower-information-form" class="row" method="post">
                @csrf    
                @method('PUT')
                <div class="col-md-5">
                    <label for="borrower-type" class="col-form-label text-secondary">ลักษณะผู้กู้</label>
                    <select id="borrower-type" name="borrower_appearance" class="form-select" required>
                        <option disabled selected value="">เลือกลักษณะผู้กู้</option>
                        @foreach($borrower_apprearance_types as $borrower_apprearance_type)
                            <option value="{{$borrower_apprearance_type->id}}"{{($borrower->borrower_appearance_id	 == $borrower_apprearance_type->id) ? 'selected' : '' }} >{{$borrower_apprearance_type->title}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        กรุณาเลือกลักษณะผู้กู้
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-2 mb-3">
                    <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                    <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
                        <option disabled selected value="">เลือกคำนำหน้าชื่อ</option>
                        <option {{($user['prefix'] == "นาย")? 'selected': ''}} value="นาย">นาย</option>
                        <option {{($user['prefix'] == "นาง")? 'selected': ''}} value="นาง">นาง</option>
                        <option {{($user['prefix'] == "นางสาว")? 'selected': ''}} value="นางสาว">นางสาว</option>
                    </select>
                    <div class="invalid-feedback">
                        กรุณาเลือกคำนำหน้าชื่อ
                    </div>
                </div>
                <div class="col-md-10"></div>
                <div class="col-md-5 mb-3">
                    <label for="firstname" class="form-label text-secondary">ชื่อ</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required value="{{$user['firstname']}}" >
                    <div class="invalid-feedback">
                        กรุณากรอกชื่อ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="lastname" class="form-label text-secondary">นามสกุล</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required value="{{$user['lastname']}}">
                    <div class="invalid-feedback">
                        กรุณากรอกชื่อนามสกุล
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                    <div class="input-group date" id="">
                        <input type="text" name="birthday" id="borrower_birthday" class="form-control"
                        placeholder="วว/ดด/ปปปป" onchange="ageCal('borrower')" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $borrower['birthday'])->format('d-m-Y')}}" />
                        <div class="invalid-feedback">
                            กรุณากรอกวันเกิด
                        </div>
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="age" class="form-label text-secondary">อายุ</label>
                    <input type="text" class="form-control" id="borrower_age" required name="age">
                    <div class="invalid-feedback">
                        กรุณากรอกอายุ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                    <input type="text" class="form-control" id="citizen_id"  name="citizen_id" oninput="formatThaiID(this)" maxlength="17" required value="{{$borrower->citizen_id}}">
                    <div class="invalid-feedback">
                        กรุณากรอกเลขบัตรประชาชน
                    </div>
                </div>
                <div class="col-md-7"></div>

                <div class="col-md-5 mb-3">
                    <label for="student_id" class="form-label text-secondary">รหัสนักศึกษา</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" required value="{{$borrower->student_id}}">
                    <div class="invalid-feedback">
                        กรุณากรอกรหัสนักศึกษา
                    </div>
                </div>
                <div class="col-md-7"></div>
                <!-- <div class="cal-md-10"></div> -->
                <div class="col-md-5 mb-2">
                    <label for="faculty" class="col-md-12 col-form-label text-secondary">คณะ</label>
                    <select id="faculty" name="faculty" class="form-select" aria-label="Default select example" required>
                        <option disabled selected value="">เลือกคณะ</option>
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->id}}" {{($borrower->faculty_id == $faculty->id) ? 'selected' : '' }}>{{$faculty->faculty_name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        กรุณาเลือกคณะ
                    </div>
                </div>
                <div class="col-md-5 mb-2">
                    <label for="major" class="col-md-12 col-form-label text-secondary">สาขา</label>
                    <select id="major" name="major" class="form-select" aria-label="Default select example" required>
                        <option disabled selected value="">เลือกสาขา</option>
                        @foreach($majors as $major)
                            <option value="{{$major->id}}" {{($borrower->major_id == $major->id) ? 'selected' : '' }}>{{$major->major_name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        กรุณาเลือกสาขา
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="grade" class="col-md-12 col-form-label text-secondary">ชั้นปี</label>
                    <select id="grade" name="grade" class="form-select" aria-label="Default select example" required>
                        <option disabled selected value="">เลือกชั้นปี</option>
                        <option value="1" {{($borrower->grade == '1') ? 'selected' : '' }}>1</option>
                        <option value="2" {{($borrower->grade == '2') ? 'selected' : '' }}>2</option>
                        <option value="3" {{($borrower->grade == '3') ? 'selected' : '' }}>3</option>
                        <option value="4" {{($borrower->grade == '4') ? 'selected' : '' }}>4</option>
                        <option value="5" {{($borrower->grade == '5') ? 'selected' : '' }}>5</option>
                    </select>
                    <div class="invalid-feedback">
                        กรุณาเลือกชั้นปี
                    </div>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-3 mb-3">
                    <label for="gpa" class="form-label text-secondary">ผลการเรียน</label>
                    <input type="text" class="form-control" id="gpa" name="gpa" required value="{{$borrower->gpa}}">
                    <div class="invalid-feedback">
                        กรุณากรอกผลการเรียน
                    </div>
                </div>
                <div class="col-md-12 my-3">
                    <h6 class="text-primary" >ข้อมูลที่อยู่</h6>
                    <div class="col-md-11 line-section mt-2"></div>
                </div>

                <div class="col-md-5 mb-3">
                    <label for="village" class="form-label text-secondary">หมู่บ้าน</label>
                    <input type="text" class="form-control" id="village" name="village" required value="{{$address->village}}">
                    <div class="invalid-feedback">
                        กรุณากรอกหมู่บ้าน
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="house_no" class="form-label text-secondary">บ้านเลขที่</label>
                    <input type="text" class="form-control" id="house_no" name="house_no" required value="{{$address->house_no}}">
                    <div class="invalid-feedback">
                        กรุณากรอกบ้านเลขที่
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="village_no" class="form-label text-secondary">หมู่ที่</label>
                    <input type="text" class="form-control" id="village_no" name="village_no" required value="{{$address->village_no}}">
                    <div class="invalid-feedback">
                        กรุณากรอกหมู่
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <label for="street" class="form-label text-secondary">ซอย</label>
                    <input type="text" class="form-control" id="street" name="street" required value="{{$address->street}}">
                    <div class="invalid-feedback">
                        กรุณากรอกซอย
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <label for="road" class="form-label text-secondary">ถนน</label>
                    <input type="text" class="form-control" id="road" name="road" required value="{{$address->road}}">
                    <div class="invalid-feedback">
                        กรุณากรอกถนน
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control" id="borrower_postcode" name="postcode" required onblur="addressWithZipcode(this.value,'borrower')" value="{{$address->postcode}}">
                    <div class="invalid-feedback">
                        กรุณากรอกรหัสไปรษณีย์
                    </div>
                </div>
                <div class="col-md-9"></div>

                <div class="col-md-5 mb-3">
                    <label for="province" class="form-label text-secondary">จังหวัด</label>
                    <input type="text" class="form-control" id="borrower_province" required name="province" value="{{$address->province}}">
                    <div class="invalid-feedback">
                        กรุณากรอกจังหวัด
                    </div>
                </div>

                <div class="col-md-5">
                    <label for="aumphure" class="form-label text-secondary">อำเภอ</label>
                    <input type="text" class="form-control" id="borrower_aumphure" required name="aumphure" value="{{$address->aumphure}}">
                    <div class="invalid-feedback">
                        กรุณากรอกอำเภอ
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
                        <select id="borrower_tambon" name="tambon" class="form-select" required aria-label="Default select example">
                            
                        </select>
                        <div class="invalid-feedback">
                            กรุณาเลือกตำบล
                        </div>
                </div>
                <div class="col-md-7"></div>

                <div class="col-md-5 mb-3">
                    <label for="email" class="form-label text-secondary">อีเมล</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{$user->email}}">
                    <div class="invalid-feedback">
                        กรุณากรอกอีเมลล์
                    </div>
                </div>
                <div class="col-md-12"></div>

                <div class="col-md-5 mb-3">
                    <label for="phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="phone" required name="phone" value="{{$borrower->phone}}">
                    <div class="invalid-feedback">
                        กรุณากรอกเบอร์โทรศัพท์
                    </div>
                </div>
                <div class="col-md-12"></div>

                <div class="col-sm-12 my-2">
                    <label id="formattedNumber" class="text-primary fw-bold">ขอรับรองว่าข้าพเจ้ามีคุณสมบัติถูกต้องตามหลักเกณฑ์ ดังนี้</label>
                </div>
                @error('props')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <!-- checkbox props -->
                <div class="col-md-12">
                    <div class="row">
                        @foreach($properties as $property)
                            <div class="col-md-5 my-2">
                                <div class="form-check">
                                    <input id="property{{$property->id}}" class="form-check-input" type="checkbox" name="properties[]" value="{{$property->id}}"  {{ in_array($property->id, $borrower_properties) ? 'checked' : '' }} >
                                    <label class="form-check-label" for="property{{$property->id}}">
                                    {{$property->property_title}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- end checkbox props -->

                <div class="col-sm-12 my-2">
                    <label id="formattedNumber" class="text-primary fw-bold">เหตุผลความจำเป็นของการขอกุ้ยืม</label>
                    @error('necess')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- checkbox props -->
                <div class="col-md-12 mb-3">
                    <div class="row">
                        @foreach ($nessessities as $nessessity)
                            <div class="col-md-5 my-2">
                                <div class="form-check">
                                    <input id="nessessity{{$nessessity->id}}" class="form-check-input" type="checkbox" name="nessessities[]" value="{{$nessessity->id}}"  {{ in_array($nessessity->id, $borrower_nessessities) ? 'checked' : '' }} >
                                    <label class="form-check-label" for="nessessity{{$nessessity->id}}">
                                        {{$nessessity->nessessity_title}}
                                    </label>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-12"></div>

                        <div class="col-md-1 my-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="morePropCheck" name="morePropCheck" value="true" {{ isset($borrower_nessessity_other) ? 'checked' : '' }}>
                                <label class="form-check-label" for="morePropCheck">
                                อื่นๆ
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <textarea class="form-control" style="height: 100px" id="moreProp" name="necessMoreProp" value="" {{ isset($borrower_nessessity_other) ? 'required' : 'disabled' }} >{{ isset($borrower_nessessity_other['other']) ? $borrower_nessessity_other['other'] : '' }}</textarea>
                            <div class="invalid-feedback">
                                กรุณากรอกเหตุผลความจำเป็นอื่นๆ
                            </div>
                        </div>
                        
                    </div><!--end row-->
                </div>
                <div class="col-12 row m-0 p-0">
                    <div class="col-md-8 col-sm-12"></div>
                    <div class="col-md-4 col-sm-12">
                        <button type="button" class="btn btn-primary w-100" onclick="submitForm('borrower-information-form')">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    var tambon = @json($address->tambon);
    ageCal('borrower');
    tambonFormPostcode('borrower',tambon);

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
    
    const faculty = document.getElementById('faculty');
    faculty.addEventListener('change', async function() {

        fetch(`/borrower/major_by_faculty/${this.value}`)
        .then((response) => response.json())
        .then((data) => {
            majorOprionChange(data);// Process the data here
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
    });

    function majorOprionChange(majors){
        const major = document.getElementById('major');
        major.innerHTML = '<option disabled selected value="">เลือกสาขา</option>';
        major.innerHTML += majors.map(major =>{
            return `<option value="${major.id}">${major.major_name}</option>`;
        }).join("");
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

    function formatThaiID(input) {
        const digits = input.value.replace(/\D/g, '');
        const formatted = digits.replace(
            /^(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})$/,
            '$1-$2-$3-$4-$5'
        );
        input.value = formatted;
    }

    function gotoTop(){
        setTimeout(() => {
            window.scrollTo(0, 0);
        }, 1000);
    }

    var moreProps = document.getElementById('morePropCheck');
    moreProps.onchange = () => {
        const moreProp = document.getElementById('moreProp');
        moreProp.value = "";
        moreProp.disabled = !moreProp.disabled;
        moreProp.required = !moreProp.required;
        var invalid_element = moreProp.nextElementSibling;
        if(invalid_element)invalid_element.classList.remove('d-inline');
    }

    async function submitForm(form_id){
        var validator = await validateForm(form_id);
        if(validator){
            document.getElementById(form_id).submit();
        }else{
            alert('ดูเหมือนว่าท่านยังกรอกข้อมูลไม่ครบ! กรุณาตรวจสอบอีกครั้ง');
            window.scrollTo(0,0);
        }
    }

    async function validateForm(form_id){
        var form = document.getElementById(form_id);
        var input_text = form.querySelectorAll('input[type="text"][required]');
        var input_select = form.querySelectorAll('select[required]');
        var input_textarea = form.querySelector('textarea[required]');
        console.log(input_textarea);
        var validator = true;
        await input_text.forEach(input => {
            if(input.value == ''){
                validator = false;
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        await input_select.forEach(input => {
            if(input.value == ''){
                validator = false;
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        });

        if(input_textarea){
            if(input_textarea.value == ''){
                validator = false;
                var invalid_element = input_textarea.nextElementSibling;
                if(invalid_element)invalid_element.classList.add('d-inline');
            }else{
                var invalid_element = input_textarea.nextElementSibling;
                if(invalid_element)invalid_element.classList.remove('d-inline');
            }
        }

        return validator;
    }

    //setup tambon option for select
    function tambonFormPostcode(caller,tambon_db){
        fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_tambon.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            
            let getpostcodeforminput = document.querySelector(`#${caller}_postcode`).value;
            let tambons = [];
            for(tambon of data){
                if(getpostcodeforminput == tambon.zip_code){
                    // console.log(tambon.name_th)
                    tambons.push(tambon.name_th.toString());
                }
            }
            // console.log(tambons);
            const selectElement = document.getElementById(`${caller}_tambon`);
            for(tb of tambons){
                selectElement.innerHTML += `<option ${ (tambon_db == tb) ? 'selected' : '' } value="${tb}">${tb}</option>`;
            }

        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    $("#borrower_birthday").datetimepicker({
        disabled:false,
        format: 'd-m-Y', 
        timepicker: false, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });
</script>
@endsection