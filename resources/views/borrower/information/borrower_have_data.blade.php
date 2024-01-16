
<div class="m-3"></div>
<!-- <h6 class="text-secondary">กรอกข้อมูลผู้กู้</h6> -->
<!-- Multi Columns Form -->
<form class="row g-3" id="form-borrower" action="/store_information" method="POST">
    @csrf
    <div class="col-md-5">
        <label for="borrower-type" class="col-form-label text-secondary">ลักษณะผู้กู้</label>
        <select id="borrower-type" name="borrower_appearance" class="form-select" aria-label="Default select example">
            <option >เลือกลักษณะผู้กู้</option>
            <option {{ $borrower_information['borrower_appearance'] == 'ขาดแคลนคุณทรัพย์' ? 'selected' : '' }} value="ขาดแคลนคุณทรัพย์">ขาดแคลนคุณทรัพย์</option>
            <option {{ $borrower_information['borrower_appearance'] == 'สาขาที่ขาดแคลน' ? 'selected' : '' }} value="สาขาที่ขาดแคลน">สาขาที่ขาดแคลน</option>
            <option {{ $borrower_information['borrower_appearance'] == 'สาขาที่เป็นความต้องการหลัก' ? 'selected' : '' }} value="สาขาที่เป็นความต้องการหลัก">สาขาที่เป็นความต้องการหลัก</option>
            <option {{ $borrower_information['borrower_appearance'] == 'เรียนดีสร้างความเป็นเลิศ' ? 'selected' : '' }} value="เรียนดีสร้างความเป็นเลิศ">เรียนดีสร้างความเป็นเลิศ</option>
        </select>
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-2">
        <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="prefix" name="prefix" class="form-select" aria-label="Default select example">
            <option selected>เลือกคำนำหน้าชื่อ</option>
            <option {{ $borrower_information['prefix'] == 'นาย' ? 'selected' : '' }} value="นาย">นาย</option>
            <option {{ $borrower_information['prefix'] == 'นางสาว' ? 'selected' : '' }}value="นางสาว">นางสาว</option>
        </select>
    </div>
    <div class="col-md-10"></div>
    <div class="col-md-5">
        <label for="fname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="fname" name="fname" value="{{$user_information['fname']}}">
    </div>
    <div class="col-md-5">
        <label for="lname" class="form-label text-secondary">นามสกุล</label>
        <input type="email" class="form-control" id="lname" name="lname" value="{{$user_information['lname']}}">
    </div>
    <div class="col-md-5">
        <label for="birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <input type="date" class="form-control" id="birthday" name="birthday" value="{{$borrower_information['birthday']}}" onchange="ageCal('')">
    </div>
    <div class="col-md-3">
        <label for="age" class="form-label text-secondary">อายุ</label>
        <input disabled type="text" class="form-control" id="age" name="age">
    </div>
    <div class="col-md-5">
        <label for="citizen_id" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
        <input type="text" class="form-control" id="citizen_id" name="citizen_id" maxlength="13" value="{{$borrower_information['citizen_id']}}">
    </div>
    <div class="col-md-7"></div>
    <div class="col-md-5">
    <label id="formattedNumber" class="text-secondary text-secondary">x-xxxx-xxxxx-xx-x</label>
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="student_id" class="form-label text-secondary">รหัสนักศึกษา</label>
        <input type="number" class="form-control" id="student_id" name="student_id" value="{{$borrower_information['student_id']}}">
    </div>
    <div class="col-md-7"></div>
    <!-- <div class="cal-md-10"></div> -->
    <div class="col-md-5">
        <label for="faculty" class="col-md-12 col-form-label text-secondary">คณะ</label>
        <select id="faculty" name="faculty" class="form-select" aria-label="Default select example">
            <option selected>เลือกคณะ</option>
            <option value="lasc">lasc</option>
        </select>
    </div>
    <div class="col-md-5">
        <label for="major" class="col-md-12 col-form-label text-secondary">สาขา</label>
        <select id="major" name="major" class="form-select" aria-label="Default select example">
            <option selected>เลือกสาขา</option>
            <option value="software">software</option>
        </select>
    </div>
    <div class="col-md-3 mt-2">
        <label for="grade" class="col-md-12 col-form-label text-secondary">ชั้นปี</label>
        <select id="grade" name="grade" class="form-select" aria-label="Default select example">
            <option selected>เลือกชั้นปี</option>
            <option {{ $borrower_information['grade'] == '1' ? 'selected' : '' }} value="1">1</option>
            <option {{ $borrower_information['grade'] == '2' ? 'selected' : '' }} value="2">2</option>
            <option {{ $borrower_information['grade'] == '3' ? 'selected' : '' }} value="3">3</option>
            <option {{ $borrower_information['grade'] == '4' ? 'selected' : '' }} value="4">4</option>
            <option {{ $borrower_information['grade'] == '5' ? 'selected' : '' }} value="5">5</option>
        </select>
    </div>
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <label for="gpa" class="form-label text-secondary">ผลการเรียน</label>
        <input type="text" class="form-control" id="gpa" name="gpa" value="{{$borrower_information['gpa']}}">
    </div>

    <div class="col-md-12"></div>
    <div class="col-md-12"></div>

    <div class="col-md-11 line-section mt-2"></div>
    <h6 class="text-primary">ข้อมูลที่อยู่</h6>

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
        <input type="text" class="form-control" id="postcode" name="postcode" onblur="addressWithZipcode(this.value)" value="{{$address['postcode']}}">
    </div>
    <div class="col-md-9"></div>

    <div class="col-md-5">
        <label for="province" class="form-label text-secondary">จังหวัด</label>
        <input type="text" class="form-control" id="province" name="province" value="{{$address['province']}}">
    </div>

    <div class="col-md-5">
        <label for="aumphure" class="form-label text-secondary">อำเภอ</label>
        <input type="text" class="form-control" id="aumphure" name="aumphure" value="{{$address['aumphure']}}">
    </div>

    <div class="col-md-5">
    <label for="tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
        <select id="tambon" name="tambon" class="form-select" aria-label="Default select example">
            <option selected>เลือกตำบล</option>
    </select>
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="email" class="form-label text-secondary">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" value="{{$user_information['email']}}">
    </div>
    <div class="col-md-12"></div>

    <div class="col-md-5">
        <label for="phone_number" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{$borrower_information['phone_number']}}">
    </div>
    <div class="col-md-12"></div>

    <div class="col-md-5">
        <label id="formattedNumber" class="text-secondary text-secondary">ขอรับรองว่าข้าพเจ้ามีคุณสมบัติถูกต้องตามหลักเกณฑ์ ดังนี้</label>
    </div>
    <div class="col-md-7"></div>
    <!-- checkbox props -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="prop1" name="props[prop1]" value="มีรายได้ไม่เกิน 360,000 บาทต่อปี" {{ isset($borrower_information->borrower_properties->prop1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="prop1">
                    มีรายได้ไม่เกิน 360,000 บาทต่อปี
                    </label>
                </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop2" name="props[prop2]" value="ไม่เคยสำเร็จการศึกษาระดับปริญญาตรีสาขมใดๆมาก่อน"{{ isset($borrower_information->borrower_properties->prop2) ? 'checked' : '' }}>
                ไม่เคยสำเร็จการศึกษาระดับปริญญาตรีสาขมใดๆมาก่อน
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop3" name="props[prop3]" value="จบการศึกษาระดับมัธยมหรือเทียบเท่าแล้ว" {{ isset($borrower_information->borrower_properties->prop3) ? 'checked' : '' }}>
                <label class="form-check-label" for="prop3">
                จบการศึกษาระดับมัธยมหรือเทียบเท่าแล้ว
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop4"  name="props[prop4]" value="ไม่เป็นผู้มีงานประจำ" {{ isset($borrower_information->borrower_properties->prop4) ? 'checked' : '' }}>
                <label class="form-check-label" for="prop4">
                ไม่เป็นผู้มีงานประจำ
                </label>
            </div>
            </div>
            
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop5"  name="props[prop5]" value="มีอายุไม่เกิน 30 ปีบริบูรณ์" {{ isset($borrower_information->borrower_properties->prop5) ? 'checked' : '' }}>
                <label class="form-check-label" for="prop5">
                มีอายุไม่เกิน 30 ปีบริบูรณ์
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop6"  name="props[prop6]" value="ไม่เป็นบุคคลล้มละลาย" {{ isset($borrower_information->borrower_properties->prop6) ? 'checked' : '' }}>
                <label class="form-check-label" for="prop6">
                ไม่เป็นบุคคลล้มละลาย
                </label>
            </div>
            </div>
            
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="props7"  name="props[props7]" value="ไม่เคยผิดหนี้ชำระกับกองทุน" {{ isset($borrower_information->borrower_properties->prop7) ? 'checked' : '' }}>
                <label class="form-check-label" for="prop7">
                ไม่เคยผิดหนี้ชำระกับกองทุน
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop8"  name="props[prop8]" value="ไม่เคยต้องโทษจำคุก" {{ isset($borrower_information->borrower_properties->prop8) ? 'checked' : '' }}>
                <label class="form-check-label" for="prop8">
                ไม่เคยต้องโทษจำคุก
                </label>
            </div>
            </div>
            
        </div>
    </div>
    <!-- end checkbox props -->

    <div class="col-md-12"></div>
    
    <label id="formattedNumber" class="text-secondary text-secondary">เหตุผลความจำเป็นของการขอกุ้ยืม</label>
    <!-- checkbox props -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="necess1" name="necess[necess1]" value="เพื่อให้ได้เรียนในสาขาที่ชอบ" {{ isset($borrower_information->borrower_necessity->necess1) ? 'checked' : '' }}>
                <label class="form-check-label" for="necess1">
                เพื่อให้ได้เรียนในสาขาที่ชอบ
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="necess2" name="necess[necess2]" value="ขาดแคลนคุณทรัพย์" {{ isset($borrower_information->borrower_necessity->necess2) ? 'checked' : '' }}>
                <label class="form-check-label" for="necess2">
                ขาดแคลนคุณทรัพย์
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="necess3" name="necess[necess3]" value="ลดภาระผู้ปกครอง" {{ isset($borrower_information->borrower_necessity->necess3) ? 'checked' : '' }}>
                <label class="form-check-label" for="necess3">
                ลดภาระผู้ปกครอง
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="necess4" name="necess[necess4]" value="สาขาที่เป็นความต้องการหลัก" {{ isset($borrower_information->borrower_necessity->necess4) ? 'checked' : '' }}>
                <label class="form-check-label" for="necess4">
                สาขาที่เป็นความต้องการหลัก
                </label>
            </div>
            </div>
            
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="necess5" name="necess[necess5]" value="สาขาที่ขาดแคลน"  {{ isset($borrower_information->borrower_necessity->necess5) ? 'checked' : '' }}>
                <label class="form-check-label" for="necess5">
                สาขาที่ขาดแคลน
                </label>
            </div>
            </div>

            <div class="col-md-7"></div>

            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="morePropCheck" name="morePropCheck" value="อื่นๆ"  {{ isset($borrower_information->borrower_necessity->moreProp) ? 'checked' : '' }}>
                    <label class="form-check-label" for="morePropCheck">
                    อื่นๆ
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" style="height: 100px" id="moreProp" name="necess[moreProp]" {{ isset($borrower_information->borrower_necessity->moreProp) ? '' : 'disabled' }}>
                    {{ isset($borrower_information->borrower_necessity->moreProp) ? $borrower_information->borrower_necessity->moreProp : '' }}
                </textarea>
            </div>
            
        </div><!--end row-->
    </div>

    <div class="mt-4 mb-4"></div>
    <!-- end checkbox props -->
    <div class="col-md-12"></div>
    <div class="text-end">
    <!-- reset Modal-->
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal">
            ล้างข้อมูล
        </button>
        <div class="modal fade" id="basicModal" tabindex="-1">
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
        <button class="btn btn-primary" type="submit" onclick="submitBorrowerInformation()">save</button>
        {{--onclick="nextPgae('parent-information-tab')"  --}}
        {{-- onclick="submitBorrowerInformation()" --}}
    </div>
</form><!-- End Multi Columns Form -->

<script>
    
</script>

