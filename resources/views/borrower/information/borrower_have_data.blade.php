
<form class="row g-3" id="form-borrower" method="POST" enctype="multipart/form-data" action="{{url('/borrower/edit_data')}}">
    @csrf

    <input type="hidden" name="borrower_id" value="{{$borrower['id']}}">
    <div class="col-md-5">
        <label for="borrower-type" class="col-form-label text-secondary">ลักษณะผู้กู้</label>
        <select id="borrower-type" name="borrower_appearance" class="form-select" aria-label="Default select example" required>
            @foreach($borrower_apprearance_types as $borrower_apprearance_type)
                <option {{ ($borrower['borrower_appearance_id'] == $borrower_apprearance_type->id) ? 'selected' : '' }} value="{{$borrower_apprearance_type->id}}">{{$borrower_apprearance_type->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-2">
        <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="prefix" name="prefix" class="form-select" aria-label="Default select example">
            <option {{ ($borrower['prefix'] == 'นาย')? 'selected' : '' }} value="นาย">นาย</option>
            <option {{ ($borrower['prefix'] == 'นาง')? 'selected': '' }} value="นาง">นาง</option>
            <option {{ ($borrower['prefix'] == 'นางสาว')? 'selected' : '' }} value="นางสาว">นางสาว</option>
        </select>
    </div>
    <div class="col-md-10"></div>
    <div class="col-md-5">
        <label for="firstname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="firstname" name="firstname" value="{{$borrower['firstname']}}">
    </div>
    <div class="col-md-5">
        <label for="lastname" class="form-label text-secondary">นามสกุล</label>
        <input type="text" class="form-control" id="lastname" name="lastname" value="{{$borrower['lastname']}}">
    </div>
    <div class="col-md-5">
        <label for="birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <div class="input-group date" id="">
            <input type="text" name="birthday" id="borrower_birthday" class="form-control"
                placeholder="วว/ดด/ปปปป" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $borrower['birthday'])->format('d-m-Y')}}" onchange="ageCal('borrower')"/>
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
        </div>
        {{-- <input type="date" class="form-control" id="borrower_birthday" name="birthday" > --}}
    </div>
    <div class="col-md-3">
        <label for="age" class="form-label text-secondary">อายุ</label>
        <input disabled type="text" class="form-control" id="borrower_age" name="age">
    </div>
    <div class="col-md-5">
        <label for="citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก</label>
        <input type="text" class="form-control" id="citizen_id"  name="citizen_id" oninput="formatThaiID(this)" maxlength="17" value="{{$borrower['citizen_id']}}" required >
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="student_id" class="form-label text-secondary">รหัสนักศึกษา</label>
        <input type="text" class="form-control" id="student_id" name="student_id" value="{{$borrower['student_id']}}" required>
    </div>
    <div class="col-md-7"></div>
    <!-- <div class="cal-md-10"></div> -->
    <div class="col-md-5">
        <label for="faculty" class="col-md-12 col-form-label text-secondary">คณะ</label>
        <select id="faculty" name="faculty" class="form-select" aria-label="Default select example" required>
            @foreach($faculties as $faculty)
                <option {{($borrower['faculty_id'] == $faculty->id) ? 'selected' : '' }} value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
            @endforeach
        </select>
        @error('faculty')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="major" class="col-md-12 col-form-label text-secondary">สาขา</label>
        <select id="major" name="major" class="form-select" aria-label="Default select example" required>
            @foreach($majors as $major)
                <option {{($borrower['major_id'] == $major->id) ? 'selected' : '' }} value="{{$major->id}}">{{$major->major_name}}</option>
            @endforeach
        </select>
        @error('major')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-3 mt-2">
        <label for="grade" class="col-md-12 col-form-label text-secondary">ชั้นปี</label>
        <select id="grade" name="grade" class="form-select" aria-label="Default select example">
            <option {{ $borrower['grade'] == '1' ? 'selected' : '' }} value="1">1</option>
            <option {{ $borrower['grade'] == '2' ? 'selected' : '' }} value="2">2</option>
            <option {{ $borrower['grade'] == '3' ? 'selected' : '' }} value="3">3</option>
            <option {{ $borrower['grade'] == '4' ? 'selected' : '' }} value="4">4</option>
            <option {{ $borrower['grade'] == '5' ? 'selected' : '' }} value="5">5</option>
        </select>
    </div>
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <label for="gpa" class="form-label text-secondary">ผลการเรียน</label>
        <input type="text" class="form-control" id="gpa" name="gpa" value="{{$borrower['gpa']}}">
    </div>

    <div class="col-md-12"></div>
    <div class="col-md-12"></div>

    <div class="col-md-12 pt-4">
        <h5 class="text-primary" >ข้อมูลที่อยู่</h5>
        <div class="col-md-11 line-section mt-2"></div>
    </div>

    <div class="col-md-5">
        <label for="village" class="form-label text-secondary">หมู่บ้าน</label>
        <input type="text" class="form-control" id="village" name="village" value="{{$address['village']}}">
    </div>

    <div class="col-md-3">
        <label for="house_no" class="form-label text-secondary">บ้านเลขที่</label>
        <input type="text" class="form-control" id="house_no" name="house_no" value="{{$address['house_no']}}">
    </div>

    <div class="col-md-3">
        <label for="village_no" class="form-label text-secondary">หมู่ที่</label>
        <input type="text" class="form-control" id="village_no" name="village_no" value="{{$address['village_no']}}">
    </div>

    <div class="col-md-5">
        <label for="street" class="form-label text-secondary">ซอย</label>
        <input type="text" class="form-control" id="street" name="street" value="{{$address['street']}}">
    </div>

    <div class="col-md-5">
        <label for="road" class="form-label text-secondary">ถนน</label>
        <input type="text" class="form-control" id="road" name="road" value="{{$address['road']}}">
    </div>

    <div class="col-md-3">
        <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
        <input type="text" class="form-control" id="borrower_postcode" name="postcode" onblur="addressWithZipcode(this.value,'borrower')" value="{{$address['postcode']}}">
    </div>
    <div class="col-md-9"></div>

    <div class="col-md-5">
        <label for="province" class="form-label text-secondary">จังหวัด</label>
        <input type="text" class="form-control" id="borrower_province" name="province" value="{{$address['province']}}">
    </div>

    <div class="col-md-5">
        <label for="aumphure" class="form-label text-secondary">อำเภอ</label>
        <input type="text" class="form-control" id="borrower_aumphure" name="aumphure" value="{{$address['aumphure']}}">
    </div>

    <div class="col-md-5">
        <label for="tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
        <select id="borrower_tambon" name="tambon" class="form-select" aria-label="Default select example">

        </select>
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="email" class="form-label text-secondary">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" value="{{$borrower['email']}}">
    </div>
    <div class="col-md-12"></div>

    <div class="col-md-5">
        <label for="phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{$borrower['phone']}}">
    </div>
    <div class="col-md-12"></div>

    <div class="col-md-5">
        <label id="formattedNumber" class="text-secondary text-secondary">ขอรับรองว่าข้าพเจ้ามีคุณสมบัติถูกต้องตามหลักเกณฑ์ ดังนี้</label>
    </div>
    <div class="col-md-7"></div>
    <!-- checkbox props -->
    <div class="col-md-12">
        <div class="row">
            @foreach($properties as $property)
                <div class="col-md-5 my-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="properties[]" value="{{$property->id}}" {{ in_array($property->id, $borrower_properties) ? 'checked' : '' }} >
                        <label class="form-check-label" for="properties">
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
    <!-- checkbox props -->
    <div class="col-md-12">
        <div class="row">

            @foreach ($nessessities as $nessessity)
                <div class="col-md-5 my-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="nessessities[]" value="{{$nessessity->id}}" {{ in_array($nessessity->id, $borrower_nessessities) ? 'checked' : '' }} >
                        <label class="form-check-label" for="necess1">
                            {{$nessessity->nessessity_title}}
                        </label>
                    </div>
                </div>
            @endforeach

            

            <div class="col-md-12"></div>

            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="morePropCheck" name="morePropCheck" value="อื่นๆ"  {{ isset($borrower_nessessity_other) ? 'checked' : '' }}>
                    <label class="form-check-label" for="morePropCheck">
                    อื่นๆ
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" style="height: 100px" id="moreProp" name="moreProp" {{ isset($borrower_nessessitiy_other) ? '' : 'disabled' }}>{{ isset($borrower_nessessity_other['other']) ? $borrower_nessessity_other['other'] : '' }}</textarea>
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
        <div class="col-md-3 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_is_thai" value="ไทย" required onchange="enableInputCountry('parent1',this.value)" {{($parent1['nationality'] == 'ไทย') ? 'checked' : ''}}>
                <label class="form-check-label" for="parent1_is_thai">
                สัญชาติไทย
                </label>
            </div>
        </div>
        <div class="col-md-1 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_not_thai" value="parent1_not_thai" required onchange="enableInputCountry('parent1',this.value)" {{($parent1['nationality'] == 'ไทย') ? '' : 'checked'}}>
                <label class="form-check-label" for="parent1_not_thai">
                    อื่นๆ
                </label>
            </div>
        </div>
        <div class="col-md-4">
            @if($parent1['nationality'] == 'ไทย')
            <input type="text" class="form-control" name="parent1_nationality" id="parent1_nationality" placeholder="กรอกสัญชาติ" disabled >
            @else
                <input type="text" class="form-control" name="parent1_nationality" id="parent1_nationality" placeholder="กรอกสัญชาติ" disabled required value="{{isset($parent1['nationality']) ? $parent1['nationality'] : '' }}" >
            @endif
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
        <div class="col-md-3 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_alive" id="parent1_is_alive" value="true" required onchange="disabledMainParentRadio(true,'parent1')" {{($parent1['alive']) ? 'checked' : ''}}>
                <label class="form-check-label" for="parent1_is_alive">
                ยังมีชีวิตอยู่
                </label>
            </div>
        </div>
        <div class="col-md-3 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_alive" id="parent1_no_alive" value="false" required onchange="disabledMainParentRadio(false,'parent1')" {{($parent1['alive']) ? '' : 'checked'}}>
                <label class="form-check-label" for="parent1_no_alive">
                ถึงแก่กรรม
                </label>
            </div>
        </div>
        
    </fieldset>

    <label for="parent1_relational" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
    <fieldset class="row mb-3">
        <div class="col-md-12 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_relational_option"  value="บิดา" onchange="parentRelational('parent1',this.value)" {{($parent1['borrower_relational'] == 'บิดา') ? 'checked' : ''}} required>
                <label class="form-check-label">
                    บิดา
                </label>
            </div>
        </div>
        <div class="col-md-12 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="parent1_relational_option"  value="มารดา" onchange="parentRelational('parent1',this.value)" {{($parent1['borrower_relational'] == 'มารดา') ? 'checked' : ''}} required>
                <label class="form-check-label">
                    มารดา
                </label>
            </div>
        </div>
        <div class="col-md-1 my-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" id="parent1moreRelational" name="parent1_relational_option" value="อื่นๆ" onchange="parentRelational('parent1',this.value)" {{($parent1['borrower_relational'] != 'มารดา' && $parent1['borrower_relational'] != 'บิดา') ? 'checked' : ''}} required>
                <label class="form-check-label">
                    อื่นๆ
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="parent1_custom_relational" onblur="setCustomRelational('parent1',this.value)" {{($parent1['borrower_relational'] != 'มารดา' || $parent1['borrower_relational'] != 'บิดา') ? '' : 'disabled'}} >
            <input type="hidden" id="parent1_relational" name="parent1_relational" value="{{$parent1['borrower_relational']}}" required>
        </div>
    </fieldset>
    @error('parent1_relational')
        <span class="text-danger">{{ $message }}</span>
    @enderror


    <div class="col-md-2">
        <label for="parent1_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="parent1_prefix" name="parent1_prefix" class="form-select" aria-label="Default select example" required>
            <option {{ ($parent1['prefix'] == 'นาย') ? 'selected' : '' }} value="นาย">นาย</option>
            <option {{ ($parent1['prefix'] == 'นาง')? 'selected': '' }} value="นาง">นาง</option>
            <option {{ ($parent1['prefix'] == 'นางสาว') ? 'selected' : '' }} value="นางสาว">นางสาว</option>
        </select>
        @error('parent1_prefix')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-10"></div>

    <div class="col-md-5">
        <label for="parent1_firstname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="parent1_firstname" name="parent1_firstname" required onblur="mainparent_label(this.value,'parent1')" value="{{$parent1['firstname']}}">
        @error('parent1_firstname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_lastname" class="form-label text-secondary">นามสกุล</label>
        <input type="text" class="form-control" id="parent1_lastname" name="parent1_lastname" required value="{{$parent1['lastname']}}">
        @error('parent1_lastname')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <div class="input-group date" id="">
            <input type="text" name="parent1_birthday" id="parent1_birthday" class="form-control"
                placeholder="วว/ดด/ปปปป" onchange="ageCal('parent1')" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $parent1['birthday'])->format('d-m-Y')}}" required/>
            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
        </div>
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
        <div id="div_parent1_citizen_id">
            <input type="text" class="form-control" id="parent1_citizen_id" name="parent1_citizen_id" maxlength="17" oninput="formatThaiID(this)" value="{{$parent1['citizen_id']}}" required>
        </div>
        @error('parent1_citizen_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-7"></div>
    <div class="col-md-5">
        <label for="parent1_email" class="form-label text-secondary">อีเมลล์</label>
        <input type="text" class="form-control" id="parent1_email" name="parent1_email" value="{{$parent1['email']}}" required>
        @error('parent1_email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="parent1_phone" name="parent1_phone" required value="{{$parent1['phone']}}">
        @error('parent1_phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_occupation" class="form-label text-secondary">อาชีพ</label>
        <input type="text" class="form-control" id="parent1_occupation" name="parent1_occupation" required value="{{$parent1['occupation']}}">
        @error('parent1_occupation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_place_of_work" class="form-label text-secondary">สถานที่ทำงาน</label>
        <input type="text" class="form-control" id="parent1_place_of_work" name="parent1_place_of_work" required value="{{$parent1['place_of_work']}}">
        @error('parent1_place_of_work')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-5">
        <label for="parent1_income" class="form-label text-secondary">รายได้ต่อปี</label>
        <input type="text" class="form-control" id="parent1_income" name="parent1_income" oninput="formatIncome(this)" placeholder="1,000,000" value="{{$parent1['income']}}" required>
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
            <input class="form-check-input" type="checkbox" id="parent2_no_data" name="parent2_no_data" value="true" {{isset($parent2)? '':'checked'}} onclick="parenat2NoData()">
            <label class="form-check-label  " for="parent2_no_data">
            ไม่มีข้อมูล
            </label>
        </div>
        @error('parent2_is_thai')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-7"></div>
    @if(isset($parent2))
        <fieldset class="row mb-3 mt-4">
            @error('parent2_is_thai')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_is_thai" value="ไทย" required onchange="enableInputCountry('parent2',this.value)" {{($parent2['nationality'] == 'ไทย') ? 'checked' : ''}}>
                    <label class="form-check-label" for="parent2_is_thai">
                    สัญชาติไทย
                    </label>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_not_thai" value="parent2_not_thai" required onchange="enableInputCountry('parent2',this.value)" {{($parent2['nationality'] == 'ไทย') ? '' : 'checked'}}>
                    <label class="form-check-label" for="parent2_not_thai">
                        อื่นๆ
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                @if($parent2['nationality'] == 'ไทย')
                    <input type="text" class="form-control" name="parent2_nationality" id="parent2_nationality" placeholder="กรอกสัญชาติ" disabled >
                @else
                    <input type="text" class="form-control" name="parent2_nationality" id="parent2_nationality" placeholder="กรอกสัญชาติ" disabled required value="{{isset($parent2['nationality']) ? $parent2['nationality'] : '' }}" >
                @endif
            </div>
            @error('parent2_nationality')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </fieldset>

        <fieldset class="row mb-3 mt-4" id="thaiperson">
            <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
            @error('parent2_alive')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_is_alive" value="true" required onchange="disabledMainParentRadio(true,'parent2')" {{($parent2['alive']) ? 'checked' : ''}}>
                    <label class="form-check-label" for="parent2_is_alive">
                    ยังมีชีวิตอยู่
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_no_alive" value="false" required onchange="disabledMainParentRadio(false,'parent2')" {{($parent2['alive']) ? '' : 'checked'}}>
                    <label class="form-check-label" for="parent2_no_alive">
                    ถึงแก่กรรม
                    </label>
                </div>
            </div>
            
        </fieldset>

        <label for="parent2_relational" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
        <fieldset class="row mb-3">
            <div class="col-md-12 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent2_relational_option"  value="บิดา" onchange="parentRelational('parent2',this.value)" {{($parent2['borrower_relational'] == 'บิดา') ? 'checked' : ''}} required>
                    <label class="form-check-label">
                        บิดา
                    </label>
                </div>
            </div>
            <div class="col-md-12 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="parent2_relational_option"  value="มารดา" onchange="parentRelational('parent2',this.value)" {{($parent2['borrower_relational'] == 'มารดา') ? 'checked' : ''}} required>
                    <label class="form-check-label">
                        มารดา
                    </label>
                </div>
            </div>
            <div class="col-md-1 my-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="parent2moreRelational" name="parent2_relational_option" value="อื่นๆ" onchange="parentRelational('parent2',this.value)" {{($parent2['borrower_relational'] != 'มารดา' && $parent2['borrower_relational'] != 'บิดา') ? 'checked' : ''}} required>
                    <label class="form-check-label">
                        อื่นๆ
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="parent2_custom_relational" onblur="setCustomRelational('parent2',this.value)" {{($parent2['borrower_relational'] != 'มารดา' || $parent2['borrower_relational'] != 'บิดา') ? 'disabled' : ''}} >
                <input type="hidden" id="parent2_relational" name="parent2_relational" value="{{$parent2['borrower_relational']}}" required>
            </div>
        </fieldset>
        @error('parent2_relational')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="col-md-2">
            <label for="parent2_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
            <select id="parent2_prefix" name="parent2_prefix" class="form-select" aria-label="Default select example" required>
                <option {{ ($parent2['prefix'] == 'นาย') ? 'selected' : '' }} value="นาย">นาย</option>
                <option {{ ($parent2['prefix'] == 'นาง') ? 'selected': ''}} value="นาง">นาง</option>
                <option {{ ($parent2['prefix'] == 'นางสาว') ? 'selected' : '' }} value="นางสาว">นางสาว</option>
            </select>
            @error('parent2_prefix')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-10"></div>

        <div class="col-md-5">
            <label for="parent2_firstname" class="form-label text-secondary">ชื่อ</label>
            <input type="text" class="form-control" id="parent2_firstname" name="parent2_firstname" required onblur="mainparent_label(this.value,'parent2')" value="{{$parent2['firstname']}}">
            @error('parent2_firstname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_lastname" class="form-label text-secondary">นามสกุล</label>
            <input type="text" class="form-control" id="parent2_lastname" name="parent2_lastname" required value="{{$parent2['lastname']}}">
            @error('parent2_lastname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
            <div class="input-group date" id="">
                <input type="text" name="parent2_birthday" id="parent2_birthday" class="form-control"
                    placeholder="วว/ดด/ปปปป" onchange="ageCal('parent2')" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $parent2['birthday'])->format('d-m-Y')}}" required/>
                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            </div>
            {{-- <input type="date" class="form-control" id="parent2_birthday" name="parent2_birthday" required > --}}
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
            <div id="div_parent2_citizen_id">
                <input type="text" class="form-control" id="parent2_citizen_id" name="parent2_citizen_id" maxlength="17" oninput="formatThaiID(this)" value="{{$parent2['citizen_id']}}" required>
            </div>
            @error('parent2_citizen_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-7"></div>
        <div class="col-md-5">
            <label for="parent2_email" class="form-label text-secondary">อีเมลล์</label>
            <input type="text" class="form-control" id="parent2_email" name="parent2_email" value="{{$parent2['email']}}" required>
            @error('parent2_email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
            <input type="text" class="form-control" id="parent2_phone" name="parent2_phone" required value="{{$parent2['phone']}}">
            @error('parent2_phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_occupation" class="form-label text-secondary">อาชีพ</label>
            <input type="text" class="form-control" id="parent2_occupation" name="parent2_occupation" required value="{{$parent2['occupation']}}">
            @error('parent2_occupation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_place_of_work" class="form-label text-secondary">สถานที่ทำงาน</label>
            <input type="text" class="form-control" id="parent2_place_of_work" name="parent2_place_of_work" required value="{{$parent2['place_of_work']}}">
            @error('parent2_place_of_work')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_income" class="form-label text-secondary">รายได้ต่อปี</label>
            <input type="text" class="form-control" id="parent2_income" name="parent2_income" oninput="formatIncome(this)" placeholder="1,000,000" value="{{$parent2['income']}}" required>
            @error('parent2_income')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    @else
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
                    <input class="form-check-input" type="radio" name="parent2_alive" id="parent2_no_alive" value="false" onchange="disabledMainParentRadio(false,'parent2')">
                    <label class="form-check-label" for="parent2_no_alive">
                    ถึงแก่กรรม
                    </label>
                </div>
            </div>
            @error('parent2_alive')
                <span class="text-danger">{{ $message }}</span>
            @enderror
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
                <input type="text" class="form-control" id="parent2_custom_relational" onblur="setCustomRelational('parent2',this.value)" disabled >
                <input type="hidden" id="parent2_relational" name="parent2_relational" required>
            </div>
        </fieldset>
        @error('parent2_relational')
            <span class="text-danger">{{ $message }}</span>
        @enderror

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
            <div class="input-group date" id="">
                <input type="text" name="parent2_birthday" id="parent2_birthday" class="form-control"
                    placeholder="วว/ดด/ปปปป" onchange="ageCal('parent2')" required/>
                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
            </div>
            {{-- <input type="date" class="form-control" id="parent2_birthday" name="parent2_birthday" required onchange="ageCal('parent2')"> --}}
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
            <div id="div_parent2_citizen_id">
                <input type="text" class="form-control" id="parent2_citizen_id" name="parent2_citizen_id" maxlength="17" oninput="formatThaiID(this)" required>
            </div>
            @error('parent2_citizen_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-7"></div>
        <div class="col-md-5">
            <label for="parent2_email" class="form-label text-secondary">อีเมลล์</label>
            <input type="text" class="form-control" id="parent2_email" name="parent2_email" required>
            @error('parent2_email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
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
            <label for="parent2_place_of_work" class="form-label text-secondary">สถานที่ทำงาน</label>
            <input type="text" class="form-control" id="parent2_place_of_work" name="parent2_place_of_work" required>
            @error('parent2_place_of_work')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-5">
            <label for="parent2_income" class="form-label text-secondary">รายได้ต่อปี</label>
            <input type="text" class="form-control" id="parent2_income" name="parent2_income"  oninput="formatIncome(this)" placeholder="1,000,000" required>
            @error('parent2_income')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @endif
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
                <input class="form-check-input" type="radio" name="marital_status" id="option1" value="อยู่ด้วยกัน" required {{($borrower->marital_status->status == "อยู่ด้วยกัน") ? 'checked' : ''}}>
                <label class="form-check-label" for="option1">
                อยู่ด้วยกัน
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="marital_status" id="option2" value="แยกกันอยู่ตามอาชีพ" required {{($borrower->marital_status->status == "แยกกันอยู่ตามอาชีพ") ? 'checked' : ''}}>
                <label class="form-check-label" for="option2">
                แยกกันอยู่ตามอาชีพ
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-5 form-check">
                <input class="form-check-input" type="radio" name="marital_status" id="devorce" value="หย่า" required {{($borrower->marital_status->status == "หย่า") ? 'checked' : ''}}>
                <label class="form-check-label" for="devorce">
                หย่า(แนบใบหย่า)
                </label>
            </div>
            <div class="col-md-5">
                <input disabled class="form-control {($borrower->marital_status->status == 'หย่า') ? '' : 'd-none'}}" type="file" id="devorceFile" name="devorce_file"  accept=".jpg, .jpeg, .png, .pdf" onchange="nonDisplayFile()">
            </div>
            @php 
                $file_extension = last(explode('.',$borrower->marital_status->file_path));
            @endphp

            @if(($borrower->marital_status->status == "หย่า"))
                @if($file_extension == 'pdf')
                    <div class="row my-2 isdisplay">
                        <div class="col-md-12">
                            <iframe src="{{route('marital.status.file',['file_path' => $borrower->marital_status->file_path])}}" frameborder="0" class="w-100" height="1200"></iframe>
                        </div>
                    </div>
                @else
                    <div class="row my-2 isdisplay">
                        <div class="col-md-12">
                            <img src="{{route('marital.status.file',['file_path' => $borrower->marital_status->file_path])}}" alt="" class="w-100">
                        </div>
                    </div>    
                @endif
            @else
                    <div class="my-2"></div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="col-md-2 form-check">
                <input class="form-check-input" type="radio" name="marital_status" id="other" value="other" required {{(($borrower->marital_status->status != "อยู่ด้วยกัน" && $borrower->marital_status->status != "แยกกันอยู่ตามอาชีพ") && ($borrower->marital_status->status != "หย่า")) ? 'checked' : ''}}>
                <label class="form-check-label" for="other">
                อื่นๆ
                </label>
            </div>
            <div class="col-md-4">
                @if(($borrower->marital_status->status != "อยู่ด้วยกัน" && $borrower->marital_status->status != "แยกกันอยู่ตามอาชีพ") && ($borrower->marital_status->status != "หย่า"))
                    <input disabled type="text" class="form-control" id="otherText" name="other_text" value="{{$borrower->marital_status->status}}">
                @else
                    <input disabled type="text" class="form-control" id="otherText" name="other_text">
                @endif
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
                    <input class="form-check-input" type="radio" name="main_parent" id="parent1_is_main_parent" value="parent1" required {{($parent1['is_main_parent']) ? 'checked' : ''}}>
                    <label class="form-check-label" for="parent1_is_main_parent" id="label_parent1_is_main_parent">
                        {{$parent1['prefix'].' '.$parent1['firstname']}}
                    </label>
                </div>
            </div>
            @if(isset($parent2))
                <div class="col-md-12 my-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="main_parent" id="parent2_is_main_parent" value="parent2" required {{($parent2['is_main_parent']) ? 'checked' : ''}}>
                        <label class="form-check-label" for="parent2_is_main_parent" id="label_parent2_is_main_parent">
                        {{$parent2['prefix'].' '.$parent2['firstname']}}
                        </label>
                    </div>
                </div>
                @error('main_parent')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @else
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
            @endif
        </fieldset>

        <label class="form-label" for="">
            <h6>ข้อมูลที่อยู่ผู้แทนโดยชอบธรรม</h6>
        </label>

        <div class="col-md-5 mt-3 mb-3">
          <div class="form-check">
              <input class="form-check-input" type="checkbox" id="address_currently_with_borrower" name="address_with_borrower" value="true" {{($address['id'] == $parent_address['id']) ? 'checked' : ''}}>
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
            <input type="text" class="form-control fake-class" id="main_parent_village" name="main_parent_village" required value="{{$parent_address['village']}}">
            @error('main_parent_village')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="main_parent_house_no" class="form-label text-secondary">บ้านเลขที่</label>
            <input type="text" class="form-control fake-class" id="main_parent_house_no" name="main_parent_house_no" required value="{{$parent_address['house_no']}}">
            @error('main_parent_house_no')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="main_parent_village_no" class="form-label text-secondary">หมู่ที่</label>
            <input type="text" class="form-control fake-class" id="main_parent_village_no" name="main_parent_village_no" required value="{{$parent_address['village_no']}}">
            @error('main_parent_village_no')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="main_parent_street" class="form-label text-secondary">ซอย</label>
            <input type="text" class="form-control fake-class" id="main_parent_street" name="main_parent_street" required value="{{$parent_address['street']}}">
            @error('main_parent_street')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="main_parent_road" class="form-label text-secondary">ถนน</label>
            <input type="text" class="form-control fake-class" id="main_parent_road" name="main_parent_road" required value="{{$parent_address['road']}}">
            @error('main_parent_road')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="main_parent_postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
            <input type="text" class="form-control fake-class" id="main_parent_postcode" name="main_parent_postcode" onblur="addressWithZipcode(this.value,'main_parent')" required value="{{$parent_address['postcode']}}">
            @error('main_parent_postcode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-9"></div>

        <div class="col-md-5">
            <label for="main_parent_province" class="form-label text-secondary">จังหวัด</label>
            <input type="text" class="form-control fake-class" id="main_parent_province" name="main_parent_province" required  value="{{$parent_address['province']}}">
            @error('main_parent_province')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
            <label for="main_parent_aumphure" class="form-label text-secondary">อำเภอ</label>
            <input type="text" class="form-control fake-class" id="main_parent_aumphure" name="main_parent_aumphure" required value="{{$parent_address['aumphure']}}">
            @error('main_parent_aumphure')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-5">
        <label for="main_parent_tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
            <select id="main_parent_tambon" name="main_parent_tambon" class="form-select fake-class" aria-label="Default select example" required>
            </select>
            @error('main_parent_tambon')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-7"></div>

    <!-- end main parent information -->
    {{-- end parent information --}}

    <div class="col-md-12"></div>


    <div class="text-start" id="edit-box">
        <button class="btn btn-secondary" id="edit-data" type="button">
            <i class="bi bi-pencil"></i>
            แก้ใขข้อมูล
        </button>
        {{--onclick="nextPgae('parent-information-tab')"  --}}
        {{-- onclick="submitBorrowerInformation()" --}}
    </div>

    <div class="text-end d-none" id="form-box">
        <a href="{{url('/borrower/information')}}" class="btn btn-secondary">ยกเลิก</a>
        
        <!-- save Modal-->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#non-parent-basic-modal">
            บันทึก
        </button>

        <div class="modal fade" id="non-parent-basic-modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">บันทึกข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p class="text-center">
                        ท่านต้องการบันทึกการแก้ใขหรือไม่
                    </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div><!-- End save Modal-->
        {{-- onclick="submitInformation()" --}}
    </div>
</form><!-- End Multi Columns Form -->

<script>

    //setup element when loaded
    const allinput = document.querySelectorAll('input, select, textarea');
    allinput.forEach((e)=>{
        e.disabled = true;
    });

    tambonFormPostcode('borrower');
    tambonFormPostcode('main_parent');


    ageCalFromData('borrower');
    ageCalFromData('parent1');
    @if(isset($parent2))
        ageCalFromData('parent2');
    @endif

    // setup element when click editdata button.
    const button_edit_data = document.querySelector('#edit-data');
    button_edit_data.addEventListener('click',()=>{

        //setup all input to enabeld an require.
        const allinput = document.querySelectorAll('input, select');
        allinput.forEach((e)=>{
            e.disabled = false
            e.required = false;
        });

        //disable some input that have some logic for enabled.
        const disableinput = document.querySelectorAll('#moreProp, #parent2_nationality, #parent1_nationality, #devorceFile, #otherText');
        // console.log(disableinput)
        disableinput.forEach((e)=>{
            e.setAttribute('disabled','true');
            e.setAttribute('required','false');
        });

        //setup enable or disable
        const morePropCheck = document.querySelector('#morePropCheck');
        const morePropTextArea = document.querySelector('#moreProp');
        if(morePropCheck.checked){
            morePropTextArea.disabled = false;
            morePropTextArea.required = true;
        }else{
            morePropTextArea.disabled = true;
            morePropTextArea.required = false;
        }

        //setup enable or disable
        var parent1_not_thai = document.getElementById('parent1_not_thai');
        const parent1_nationality = document.getElementById('parent1_nationality');
        if(parent1_not_thai.checked){
            parent1_nationality.disabled = false;
            parent1_nationality.required = true;
        }else{
            parent1_nationality.disabled = true;
            parent1_nationality.required = false;
        }
        
        //setup enable or disable
        var parent2_not_thai = document.getElementById('parent2_not_thai');
        const parent2_nationality = document.getElementById('parent2_nationality');
        if(parent2_not_thai.checked){
            parent2_nationality.disabled = false;
            parent2_nationality.required = true;
        }else{
            parent2_nationality.disabled = true;
            parent2_nationality.required = false;
        }

        //setup enable or disable
        const otherMaritalStat = document.getElementById('other');
        if(otherMaritalStat.checked){
            document.getElementById('otherText').disabled = false;
            document.getElementById('otherText').required = true;
        }else{
            document.getElementById('otherText').disabled = true;
            document.getElementById('otherText').required = false;

        }
        
        const devorce = document.getElementById('devorce');
        if(devorce.checked){
            document.getElementById('devorceFile').disabled = false;
            document.getElementById('devorceFile').required = false;
        }else{
            document.getElementById('devorceFile').disabled = true;
            document.getElementById('devorceFile').required = false;
        }

        const address_currently_with_borrower = document.getElementById('address_currently_with_borrower');
        if (address_currently_with_borrower.checked) {
            const address_input = document.querySelectorAll('.fake-class');
            address_input.forEach((e)=>{
                e.disabled = true;
                e.required = false;
            });
        } else {
            const address_input = document.querySelectorAll('.fake-class');
            address_input.forEach((e)=>{
                e.disabled = false;
                e.required = true;
            });
        }

        //if parent 2 don't have data
        parenat2NoData();

        window.scrollTo(0, 0);

        //hide edit button
        document.getElementById('edit-box').classList.toggle('d-none')
        document.getElementById('form-box').classList.toggle('d-none')

        //show submit and back button
    });

    //not display file when select new file
    function nonDisplayFile(){
        const displayfile = document.querySelector('.isdisplay');
        displayfile.classList.toggle('d-none');
    }


    //setup tambon option for select
    function tambonFormPostcode(caller){
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
                selectElement.innerHTML += `<option {{ ($borrower['tambon'] == '${tb}') ? 'selected' : '' }}value="${tb}">${tb}</option>`;
            }

        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    //age cal with data form database
    function ageCalFromData(role){

        var inputBirthday = document.getElementById(role + '_birthday');
        // Get the input value (assuming it's in the format "d-m-y")
        var birthDate = inputBirthday.value;

        // Parse the selected date
        var dateParts = birthDate.split('-');
        var selectedDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Month is 0-based

        // Calculate the current date
        var currentDate = new Date();

        // Convert the current year to the Buddhist calendar (543 years ahead)
        var buddhistCurrentYear = currentDate.getFullYear() + 543;

        // Calculate the age
        var age = buddhistCurrentYear - (selectedDate.getFullYear());

        // Check if the birthday has already occurred this year
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }

        if (age < 0) {
            document.getElementById(role + '_age').value = "สวัสดีผู้มาจากอนาคต";
        } else {
            document.getElementById(role + '_age').value = age;
        }
    }

    var parent1_moreRelational = document.getElementById('parent1moreRelational');
    if(parent1_moreRelational.checked){
        relational_value = document.getElementById('parent1_relational').value;
        document.getElementById('parent1_custom_relational').value = relational_value;
    }

    var parent2_moreRelational = document.getElementById('parent2moreRelational');
    if(parent2_moreRelational.checked){
        relational_value = document.getElementById('parent2_relational').value;
        document.getElementById('parent2_custom_relational').value = relational_value;
    }
</script>

