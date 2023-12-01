<div class="m-3"></div>
<!-- <h6 class="text-secondary">กรอกข้อมูลผู้กู้</h6> -->
<!-- Multi Columns Form -->

<form class="row g-3" id="form-borrower" action="#">
    <div class="col-md-5">
        <label for="borrower-type" class="col-form-label text-secondary">ลักษณะผู้กู้</label>
        <select id="borrower-type" class="form-select" aria-label="Default select example">
            <option selected>เลือกลักษณะผู้กู้</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-2">
        <label for="borrower-type" class="col-form-label text-secondary">คำนำหน้า</label>
        <select id="borrower-type" class="form-select" aria-label="Default select example">
            <option selected>เลือกคำนำหน้าชื่อ</option>
            <option value="1">นาย</option>
            <option value="2">นางสาว</option>
        </select>
    </div>
    <div class="col-md-10"></div>
    <div class="col-md-5">
        <label for="fname" class="form-label text-secondary">ชื่อ</label>
        <input type="text" class="form-control" id="fname" name="fname">
    </div>
    <div class="col-md-5">
        <label for="lname" class="form-label text-secondary">นามสกุล</label>
        <input type="email" class="form-control" id="lname" name="lname">
    </div>
    <div class="col-md-5">
        <label for="borrower_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
        <input type="date" class="form-control" id="borrower_birthday" name="borrower_birthday" onchange="ageCal('borrower')">
    </div>
    <div class="col-md-3">
        <label for="borrower_age" class="form-label text-secondary">อายุ</label>
        <input disabled type="text" class="form-control" id="borrower_age" name="borrower_age">
    </div>
    <div class="col-md-5">
        <label for="idCardNumber" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
        <input type="text" class="form-control" id="idCardNumber" name="idCardNumber" maxlength="13">
    </div>
    <div class="col-md-7"></div>
    <div class="col-md-5">
    <label id="formattedNumber" class="text-secondary text-secondary">x-xxxx-xxxxx-xx-x</label>
    </div>
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <label for="studentId" class="form-label text-secondary">รหัสนักศึกษา</label>
        <input type="number" class="form-control" id="studentId" name="studentId">
    </div>
    <div class="col-md-7"></div>
    <!-- <div class="cal-md-10"></div> -->
    <div class="col-md-5">
        <label for="faculty" class="col-md-12 col-form-label text-secondary">คณะ</label>
        <select id="faculty" name="faculty" class="form-select" aria-label="Default select example">
            <option selected>เลือกคณะ</option>
            <option value="1">1</option>
        </select>
    </div>
    <div class="col-md-5">
        <label for="major" class="col-md-12 col-form-label text-secondary">สาขา</label>
        <select disabled id="major" name="major" class="form-select" aria-label="Default select example">
            <option selected>เลือกสาขา</option>
            <option value="1">1</option>
        </select>
    </div>
    <div class="col-md-3 mt-2">
        <label for="grade" class="col-md-12 col-form-label text-secondary">ชั้นปี</label>
        <select id="grade" name="grade" class="form-select" aria-label="Default select example">
            <option selected>เลือกชั้นปี</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <label for="gpa" class="form-label text-secondary">ผลการเรียน</label>
        <input type="text" class="form-control" id="gpa" name="gpa">
    </div>

    <div class="col-md-12"></div>
    <div class="col-md-12"></div>

    <div class="col-md-11 line-section mt-2"></div>
    <h6 class="text-primary">ข้อมูลที่อยู่</h6>

    <div class="col-md-5">
        <label for="village" class="form-label text-secondary">หมู่บ้าน</label>
        <input type="text" class="form-control" id="village" name="village">
    </div>

    <div class="col-md-3">
        <label for="houseNo" class="form-label text-secondary">บ้านเลขที่</label>
        <input type="text" class="form-control" id="houseNo" name="houseNo">
    </div>

    <div class="col-md-3">
        <label for="villageNo" class="form-label text-secondary">หมู่ที่</label>
        <input type="text" class="form-control" id="villageNo" name="villageNo">
    </div>

    <div class="col-md-5">
        <label for="street" class="form-label text-secondary">ซอย</label>
        <input type="text" class="form-control" id="street" name="street">
    </div>

    <div class="col-md-5">
        <label for="road" class="form-label text-secondary">ถนน</label>
        <input type="text" class="form-control" id="road" name="road">
    </div>

    <div class="col-md-3">
        <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
        <input type="text" class="form-control" id="postcode" name="postcode" onblur="addressWithZipcode(this.value)">
    </div>
    <div class="col-md-9"></div>

    <div class="col-md-5">
        <label for="province" class="form-label text-secondary">จังหวัด</label>
        <input type="text" class="form-control" id="province" name="province" readonly>
    </div>

    <div class="col-md-5">
        <label for="aumphure" class="form-label text-secondary">อำเภอ</label>
        <input type="text" class="form-control" id="aumphure" name="aumphure" readonly>
    </div>

    <div class="col-md-5">
    <label for="tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
        <select id="tambon" name="tambon" class="form-select" aria-label="Default select example">
            <option selected>เลือกตำบล</option>
    </select>
    </div>

    <div class="col-md-7"></div>
    <div class="col-md-5">
        <label for="phoneNumber" class="form-label text-secondary">เบอร์โทรศัพท์</label>
        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber">
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
                    <input class="form-check-input" type="checkbox" id="prop1">
                    <label class="form-check-label" for="prop1">
                    มีรายได้ไม่เกิน 360,000 บาทต่อปี
                    </label>
                </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop2">
                <label class="form-check-label" for="prop2">
                ไม่เคยสำเร็จการศึกษาระดับปริญญาตรีสาขมใดๆมาก่อน
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop3">
                <label class="form-check-label" for="prop3">
                จบการศึกษาระดับมัธยมหรือเทียบเท่าแล้ว
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop4">
                <label class="form-check-label" for="prop4">
                ไม่เป็นผู้มีงานประจำ
                </label>
            </div>
            </div>
            
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop5">
                <label class="form-check-label" for="prop5">
                มีอายุไม่เกิน 30 ปีบริบูรณ์
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop6">
                <label class="form-check-label" for="prop6">
                ไม่เป็นบุคคลล้มละลาย
                </label>
            </div>
            </div>
            
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="props7">
                <label class="form-check-label" for="prop7">
                ไม่เคยผิดหนี้ชำระกับกองทุน
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="prop8">
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
                <input class="form-check-input" type="checkbox" id="m1">
                <label class="form-check-label" for="m1">
                เพื่อให้ได้เรียนในสาขาที่ชอบ
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="m2">
                <label class="form-check-label" for="m2">
                ขาดแคลนคุณทรัพย์
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="m3">
                <label class="form-check-label" for="m3">
                ลดภาระผู้ปกครอง
                </label>
            </div>
            </div>

            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="m4">
                <label class="form-check-label" for="m4">
                สาขาที่เป็นความต้องการหลัก
                </label>
            </div>
            </div>
            
            <div class="col-md-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="m5">
                <label class="form-check-label" for="m5">
                สาขาที่ขาดแคลน
                </label>
            </div>
            </div>

            <div class="col-md-7"></div>

            <div class="col-md-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="morePropCheck">
                    <label class="form-check-label" for="morePropCheck">
                    อื่นๆ
                    </label>
                </div>
            </div>

            <div class="col-md-4">
                <textarea class="form-control" style="height: 100px" id="moreProp" name="moreProp" disabled></textarea>
            </div>
            
        </div><!--end row-->
    </div>

    <div class="mt-4 mb-4"></div>
    <!-- end checkbox props -->
    <div class="col-md-12"></div>
    <div class="text-end">
    <!-- reset Modal-->
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal">
            reset
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
        <button type="button" class="btn btn-primary" onclick="nextPgae('parent-information-tab')">บันทึกข้อมูล</button>
    </div>
</form><!-- End Multi Columns Form -->

<script>
    function addressWithZipcode(zip_code_input){
        fetch('https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_tambon.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // console.log(zip_code_input);
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
            var selectElement = document.getElementById('tambon');
            for(tb of tambons){
                var newOption = document.createElement('option');

                newOption.value = tb;
                newOption.text = tb;

                selectElement.add(newOption);
            }
            
            getAumphure(aumphureId)
            

        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }
    function getAumphure(amphure_id){
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
                    document.getElementById('aumphure').value = aumphure.name_th;
                    if(province_id == '')province_id = aumphure.province_id;
                    }
                }
                getProvince(province_id);
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    function getProvince(province_id){
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
                    if(province_id == province.id)document.getElementById('province').value = province.name_th;
                }
                
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }
</script>

