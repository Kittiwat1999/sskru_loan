<form action="{{url('/store_information')}}" class="row g-3" id="form-information" method="post" enctype="multipart/form-data">
    @csrf    
    <div class="col-md-5">
        <label for="borrower-type" class="col-form-label text-secondary">ลักษณะผู้กู้</label>
        <select id="borrower-type" name="borrower_appearance" class="form-select" required>
            <option disabled selected value="">เลือกลักษณะผู้กู้</option>
            @foreach($borrower_apprearance_types as $borrower_apprearance_type)
                <option value="{{$borrower_apprearance_type->id}}">{{$borrower_apprearance_type->title}}</option>
            @endforeach
        </select>
        @error('borrower_appearance')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-2">
        <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
            <option disabled selected value="">เลือกคำนำหน้าชื่อ</option>
            <option {{($user['prefix'] == "นาย")? 'selected': ''}} value="นาย">นาย</option>
            <option {{($user['prefix'] == "นาง")? 'selected': ''}} value="นาง">นาง</option>
            <option {{($user['prefix'] == "นางสาว")? 'selected': ''}} value="นางสาว">นางสาว</option>
        </select>
        @error('prefix')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-10"></div>
    <div class="col-md-5">
        <label for="firstname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="firstname" name="firstname" required value="{{$user['firstname']}}" >
        @error('firstname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="lastname" class="form-label text-secondary">นามสกุล</label>
        <input type="text" class="form-control" id="lastname" name="lastname" required value="{{$user['lastname']}}">
        @error('lastname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <input type="date" class="form-control" id="borrower_birthday" name="birthday" required onchange="ageCal('borrower')">
        @error('birthday')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="age" class="form-label text-secondary">อายุ</label>
        <input type="text" class="form-control" id="borrower_age" required name="age">
        @error('age')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
        <input type="text" class="form-control" id="citizen_id"  name="citizen_id" required>
        @error('citizen_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="student_id" class="form-label text-secondary">รหัสนักศึกษา</label>
        <input type="text" class="form-control" id="student_id" name="student_id" required>
        @error('student_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-7"></div>
    <!-- <div class="cal-md-10"></div> -->
    <div class="col-md-5">
        <label for="faculty" class="col-md-12 col-form-label text-secondary">คณะ</label>
        <select id="faculty" name="faculty" class="form-select" aria-label="Default select example" required>
            <option disabled selected value="">เลือกคณะ</option>
            @foreach($faculties as $faculty)
                <option value="{{$faculty->faculty_name}}">{{$faculty->faculty_name}}</option>
            @endforeach
        </select>
        @error('faculty')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="major" class="col-md-12 col-form-label text-secondary">สาขา</label>
        <select id="major" name="major" class="form-select" aria-label="Default select example" required>
            <option disabled selected value="">เลือกสาขา</option>
            @foreach($majors as $major)
                <option value="{{$major->major_name}}">{{$major->major_name}}</option>
            @endforeach
        </select>
        @error('major')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3 mt-2">
        <label for="grade" class="col-md-12 col-form-label text-secondary">ชั้นปี</label>
        <select id="grade" name="grade" class="form-select" aria-label="Default select example" required>
            <option disabled selected value="">เลือกชั้นปี</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        @error('grade')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <label for="gpa" class="form-label text-secondary">ผลการเรียน</label>
        <input type="text" class="form-control" id="gpa" name="gpa" required>
        @error('gpa')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-12"></div>
    <div class="col-md-12"></div>

    <div class="col-md-12 pt-4">
        <h5 class="text-primary" >ข้อมูลที่อยู่</h5>
        <div class="col-md-11 line-section mt-2"></div>
    </div>

    <div class="col-md-5">
        <label for="village" class="form-label text-secondary">หมู่บ้าน</label>
        <input type="text" class="form-control" id="village" name="village" required>
        @error('village')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="house_no" class="form-label text-secondary">บ้านเลขที่</label>
        <input type="text" class="form-control" id="house_no" name="house_no" required>
        @error('house_no')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="village_no" class="form-label text-secondary">หมู่ที่</label>
        <input type="text" class="form-control" id="village_no" name="village_no" required>
        @error('village_no')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-5">
        <label for="street" class="form-label text-secondary">ซอย</label>
        <input type="text" class="form-control" id="street" name="street" required>
        @error('street')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-5">
        <label for="road" class="form-label text-secondary">ถนน</label>
        <input type="text" class="form-control" id="road" name="road" required>
        @error('road')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
        <input type="text" class="form-control" id="borrower_postcode" name="postcode" required onblur="addressWithZipcode(this.value,'borrower')">
        @error('postcode')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-9"></div>

    <div class="col-md-5">
        <label for="province" class="form-label text-secondary">จังหวัด</label>
        <input type="text" class="form-control" id="borrower_province" required name="province">
        @error('province')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-5">
        <label for="aumphure" class="form-label text-secondary">อำเภอ</label>
        <input type="text" class="form-control" id="borrower_aumphure" required name="aumphure">
        @error('aumphure')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-5">
    <label for="tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
        <select id="borrower_tambon" name="tambon" class="form-select" required aria-label="Default select example">
            
        </select>
        @error('tambon')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="email" class="form-label text-secondary">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" required value="{{$user['email']}}">
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-12"></div>

    <div class="col-md-5">
        <label for="phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="phone" required name="phone">
        @error('phone_number')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-12"></div>

    <div class="col-md-5">
        <label id="formattedNumber" class="text-secondary text-secondary">ขอรับรองว่าข้าพเจ้ามีคุณสมบัติถูกต้องตามหลักเกณฑ์ ดังนี้</label>
    </div>
    @error('props')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <div class="col-md-7"></div>
    <!-- checkbox props -->
    <div class="col-md-12">
        <div class="row">
            @foreach($properties as $property)
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="properties[]" value="{{$property->id}}">
                        <label class="form-check-label" for="prop1">
                        {{$property->property_title}}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- end checkbox props -->

    <div class="col-md-12"></div>
    
    <label id="formattedNumber" class="text-secondary text-secondary">เหตุผลความจำเป็นของการขอกุ้ยืม</label>
    @error('necess')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <!-- checkbox props -->
    <div class="col-md-12">
        <div class="row">
            @foreach ($nessessities as $nessessity)
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="nessessities[]" value="{{$nessessity->id}}">
                        <label class="form-check-label" for="necess1">
                            {{$nessessity->nessessity_title}}
                        </label>
                    </div>
                </div>
            @endforeach

            <div class="col-md-12"></div>

            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="morePropCheck" name="morePropCheck" value="true">
                    <label class="form-check-label" for="morePropCheck">
                    อื่นๆ
                    </label>
                </div>
            </div>

            <div class="col-md-4 mt-2">
                <textarea class="form-control" style="height: 100px" id="moreProp" name="necessMoreProp" value="" disabled></textarea>
            </div>
            
        </div><!--end row-->
    </div>

    {{-- parent information --}}
    <!-- dad information -->
    <div class="col-md-12 pt-4">
        <h5 class="text-primary" >ข้อมูลผู้ปกครอง</h5>
        <div class="col-md-11 line-section mt-2"></div>
    </div>

    <fieldset class="row mb-3 mt-4">
        @error('parent1_is_thai')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_is_thai" value="ไทย" required onchange="enableInputCountry('parent1',this.value)">
                <label class="form-check-label" for="parent1_is_thai">
                สัญชาติไทย
                </label>
            </div>
        </div>
        <div class="col-md-1">
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
        @error('parent1_nationality')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <fieldset class="row mb-3 mt-4" id="thaiperson">
        <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
        @error('parent1_alive')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_alive" id="parent1_is_alive" value="true" required onchange="disabledMainParentRadio(true,'parent1')">
                <label class="form-check-label" for="parent1_is_alive">
                ยังมีชีวิตอยู่
                </label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_alive" id="parent1_no_alive" value="false" required onchange="disabledMainParentRadio(false,'parent1')">
                <label class="form-check-label" for="parent1_no_alive">
                ถึงแก่กรรม
                </label>
            </div>
        </div>
        
    </fieldset>

    <div class="col-md-2">
        <label for="firstname" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
        <input type="text" class="form-control" id="parent1_relational" name="parent1_relational" required>
        @error('parent1_relational')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-10"></div>

    <div class="col-md-2">
        <label for="parent1_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="parent1_prefix" name="parent1_prefix" class="form-select" aria-label="Default select example" required>
            <option disabled selected value="">เลือกคำนำหน้าชื่อ</option>
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
        </select>
        @error('parent1_prefix')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-10"></div>

    <div class="col-md-5">
        <label for="parent1_firstname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="parent1_firstname" name="parent1_firstname" required onblur="mainparent_label(this.value,'parent1')">
        @error('parent1_firstname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_lastname" class="form-label text-secondary">นามสกุล</label>
        <input type="text" class="form-control" id="parent1_lastname" name="parent1_lastname" required>
        @error('parent1_lastname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <input type="date" class="form-control" id="parent1_birthday" name="parent1_birthday" required onchange="ageCal('parent1')">
        @error('parent1_birthday')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="parent1_age" class="form-label text-secondary">อายุ</label>
        <input type="text" class="form-control" id="parent1_age" name="parent1_age" required>
        @error('parent1_age')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
        <input type="text" class="form-control" id="parent1_citizen_id" name="parent1_citizen_id" required>
        @error('parent1_citizen_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="parent1_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="parent1_phone" name="parent1_phone" required>
        @error('parent1_phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_occupation" class="form-label text-secondary">อาชีพ</label>
        <input type="text" class="form-control" id="parent1_occupation" name="parent1_occupation" required>
        @error('parent1_occupation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_income" class="form-label text-secondary">รายได้ต่อปี</label>
        <input type="text" class="form-control" id="parent1_income" name="parent1_income" required>
        @error('parent1_income')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- end dad information -->


    <!-- mom information -->
    <div class="col-md-12 mb-2 mt-5">
        <h5 class="text-primary">คู่สมรสของผู้ปกครอง</h5>
        <div class="col-md-11 line-section mt-2"></div>
    </div>
    <div class="col-md-5">
        <div class="form-check my-3">
            <input class="form-check-input" type="checkbox" id="parent2_no_data" name="parent2_no_data" value="true" onclick="parenat2NoData()">
            <label class="form-check-label  " for="parent2_no_data">
            ไม่มีข้อมูล
            </label>
        </div>
        @error('parent2_is_thai')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-7"></div>
    <fieldset class="row mb-3 mt-4">
        @error('parent2_is_thai')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_is_thai" value="ไทย" required onchange="enableInputCountry('parent2',this.value)">
                <label class="form-check-label" for="parent2_is_thai">
                สัญชาติไทย
                </label>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_not_thai" value="parent2_not_thai" required onchange="enableInputCountry('parent2',this.value)">
                <label class="form-check-label" for="parent2_not_thai">
                    อื่นๆ
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="parent2_nationality" id="parent2_nationality" placeholder="กรอกสัญชาติ" disabled>
        </div>
        @error('parent2_nationality')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>
    <fieldset class="row mb-3 mt-4" id="thaiperson">
        <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_is_alive" value="true" required onchange="disabledMainParentRadio(true,'parent2')">
                <label class="form-check-label" for="parent2_is_alive">
                ยังมีชีวิตอยู่
                </label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_no_alive" value="false" required onchange="disabledMainParentRadio(false,'parent2')">
                <label class="form-check-label" for="parent2_no_alive">
                ถึงแก่กรรม
                </label>
            </div>
        </div>
        @error('parent2_alive')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </fieldset>

    <div class="col-md-2">
        <label for="parent2_relational" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
        <input type="text" class="form-control" id="parent2_relational" name="parent2_relational" required>
        @error('parent2_relational')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-10"></div>

    <div class="col-md-2">
        <label for="parent2_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="parent2_prefix" name="parent2_prefix" class="form-select" aria-label="Default select example" required>
            <option disabled selected  value="">เลือกคำนำหน้าชื่อ</option>
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
        </select>
        @error('parent2_prefix')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-10"></div>

    <div class="col-md-5">
        <label for="parent2_firstname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="parent2_firstname" name="parent2_firstname" required onblur="mainparent_label(this.value,'parent2')">
        @error('parent2_firstname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent2_lastname" class="form-label text-secondary">นามสกุล</label>
        <input type="text" class="form-control" id="parent2_lastname" name="parent2_lastname" required>
        @error('parent2_lastname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent2_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <input type="date" class="form-control" id="parent2_birthday" name="parent2_birthday" required onchange="ageCal('parent2')">
        @error('parent2_birthday')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="parent2_age" class="form-label text-secondary">อายุ</label>
        <input type="text" class="form-control" id="parent2_age" name="parent2_age" required>
        @error('parent2_age')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent2_citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
        <input type="text" class="form-control" id="parent2_citizen_id" name="parent2_citizen_id" required>
        @error('parent2_citizen_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="parent2_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="parent2_phone" name="parent2_phone" required>
        @error('parent2_phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent2_occupation" class="form-label text-secondary">อาชีพ</label>
        <input type="text" class="form-control" id="parent2_occupation" name="parent2_occupation" required>
        @error('parent2_occupation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent2_income" class="form-label text-secondary">รายได้ต่อปี</label>
        <input type="text" class="form-control" id="parent2_income" name="parent2_income" required>
        @error('parent2_income')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <!-- end mom information -->

    <!-- maritalStatus -->
    <fieldset class="row my-4" id="maritalStatusId">
        <h5 class="text-primary">สถานภาพสมรสของผู้ปกครอง</h5>
        <div class="col-md-11 line-section mt-2 mb-2"></div>
        @error('marital_status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
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
                </div>
                @error('devorce_file')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                @error('other_text')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
    </fieldset>
    <!-- end maritalStatus -->

    <!-- main parent information -->

        <h5 class="text-primary">ข้อมูลโดยชอบธรรม</h5>
        <div class="col-md-11 line-section mt-2"></div>

        <fieldset class="row my-3">
            <label class="form-label" for="main_parent">
                <h6>เลือกผู้แทนโดยชอบธรรม</h6>
            </label>
            <div class="col-md-12 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="main_parent" id="parent1_is_main_parent" value="parent1" required>
                    <label class="form-check-label" for="parent1_is_main_parent" id="label_parent1_is_main_parent">
                    ผู้ปกครอง
                    </label>
                </div>
            </div>
            <div class="col-md-12 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="main_parent" id="parent2_is_main_parent" value="parent2" required>
                    <label class="form-check-label" for="parent2_is_main_parent" id="label_parent2_is_main_parent">
                    คู่สมรสของผู้ปกครอง
                    </label>
                </div>
            </div>
            @error('main_parent')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </fieldset>

        <label class="form-label" for="">
            <h6>ข้อมูลที่อยู่ผู้แทนโดยชอบธรรม</h6>
        </label>

        <div class="col-md-5 mt-3 mb-3">
          <div class="form-check">
              <input class="form-check-input" type="checkbox" id="address_currently_with_borrower" name="address_with_borrower" value="true">
              <label class="form-check-label" for="address_currently_with_borrower">
              ที่อยู่เดียวกันกับผู้กู้
              </label>
          </div>
          @error('address_with_borrower')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-md-7"></div>

        <div class="col-md-5">
            <label for="main_parent_village" class="form-label text-secondary">หมู่บ้าน</label>
            <input type="text" class="form-control fake-class" id="main_parent_village" name="main_parent_village" required>
            @error('main_parent_village')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="main_parent_house_no" class="form-label text-secondary">บ้านเลขที่</label>
            <input type="text" class="form-control fake-class" id="main_parent_house_no" name="main_parent_house_no" required>
            @error('main_parent_house_no')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="main_parent_village_no" class="form-label text-secondary">หมู่ที่</label>
            <input type="text" class="form-control fake-class" id="main_parent_village_no" name="main_parent_village_no" required>
            @error('main_parent_village_no')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="main_parent_street" class="form-label text-secondary">ซอย</label>
            <input type="text" class="form-control fake-class" id="main_parent_street" name="main_parent_street" required>
            @error('main_parent_street')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="main_parent_road" class="form-label text-secondary">ถนน</label>
            <input type="text" class="form-control fake-class" id="main_parent_road" name="main_parent_road" required>
            @error('main_parent_road')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="main_parent_postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
            <input type="text" class="form-control fake-class" id="main_parent_postcode" name="main_parent_postcode" onblur="addressWithZipcode(this.value,'main_parent')" required>
            @error('main_parent_postcode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-9"></div>

        <div class="col-md-5">
            <label for="main_parent_province" class="form-label text-secondary">จังหวัด</label>
            <input type="text" class="form-control fake-class" id="main_parent_province" name="main_parent_province" required>
            @error('main_parent_province')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="main_parent_aumphure" class="form-label text-secondary">อำเภอ</label>
            <input type="text" class="form-control fake-class" id="main_parent_aumphure" name="main_parent_aumphure" required>
            @error('main_parent_aumphure')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
        <label for="main_parent_tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
            <select id="main_parent_tambon" name="main_parent_tambon" class="form-select fake-class" aria-label="Default select example" required>
                <option disabled selected value="">เลือกตำบล</option>
            </select>
            @error('main_parent_tambon')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-7"></div>

    <!-- end main parent information -->
    
    <div class="text-end">
        <!-- reset Modal-->
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#non-parent-basic-modal">
            ล้างข้อมูล
        </button>
        <div class="modal fade" id="non-parent-basic-modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">ล้างข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p class="text-center">
                        ท่านต้องการล้างขอมูลบนฟอร์มหรือไม่
                    </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ล้างข้อมูล</button>
                    </div>
                </div>
            </div>
        </div><!-- End reset Modal-->
        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
        {{-- onclick="submitInformation()" --}}
    </div>
    {{-- end parent information --}}
</form>
<script>
    

    </script>

