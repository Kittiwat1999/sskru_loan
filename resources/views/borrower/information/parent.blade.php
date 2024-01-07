<div class="mt-2 mb-2">
        <form action="" class="row g-3" id="form-parent">
            @csrf          
            <!-- dad information -->
            <div class="col-md-12 pt-4">
                <h5 class="text-primary" >ข้อมูลผู้ปกครอง</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <fieldset class="row mb-3 mt-4">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_is_thai" value="parent1_is_thai" onchange="enableInputCountry('parent1',this.value)">
                        <label class="form-check-label" for="parent1_is_thai">
                        สัญชาติไทย
                        </label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent1_is_thai" id="parent1_not_thai" value="parent1_not_thai" onchange="enableInputCountry('parent1',this.value)">
                        <label class="form-check-label" for="parent1_not_thai">
                            อื่นๆ
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="parent1_country" id="parent1_country" placeholder="กรอกสัญชาติ" disabled>
                </div>
            </fieldset>
            <fieldset class="row mb-3 mt-4" id="thaiperson">
                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent1_is_alive" id="parent1_is_alive" value="true">
                        <label class="form-check-label" for="parent1_is_alive">
                        ยังมีชีวิตอยู่
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent1_is_alive" id="parent1_no_alive" value="false">
                        <label class="form-check-label" for="parent1_no_alive">
                        ถึงแก่กรรม
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="col-md-2">
                <label for="fname" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
                <input type="text" class="form-control" id="parent1_relational" name="parent1_relational">
            </div>

            <div class="col-md-10"></div>

            <div class="col-md-2">
                <label for="parent1_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                <select id="parent1_prefix" name="parent1_prefix" class="form-select" aria-label="Default select example">
                    <option selected>เลือกคำนำหน้าชื่อ</option>
                    <option value="1">นาย</option>
                    <option value="2">นาง</option>
                    <option value="3">นางสาว</option>
                </select>
            </div>
            <div class="col-md-10"></div>

            <div class="col-md-5">
                <label for="parent1_fname" class="form-label text-secondary">ชื่อ</label>
                <input type="text" class="form-control" id="parent1_fname" name="parent1_fname">
            </div>
            <div class="col-md-5">
                <label for="parent1_lname" class="form-label text-secondary">นามสกุล</label>
                <input type="email" class="form-control" id="parent1_lname" name="parent1_lname">
            </div>
            <div class="col-md-5">
                <label for="parent1_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                <input type="date" class="form-control" id="parent1_birthday" name="parent1_birthday" onchange="ageCal('parent1')">
            </div>
            <div class="col-md-3">
                <label for="parent1_age" class="form-label text-secondary">อายุ</label>
                <input disabled type="text" class="form-control" id="parent1_age" name="parent1_age">
            </div>
            <div class="col-md-5">
                <label for="parent1_id_card_number" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                <input type="text" class="form-control" id="parent1_id_card_number" name="parent1_id_card_number" maxlength="13">
            </div>
            <div class="col-md-3">
                <label for="parent1_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" id="parent1_phone" name="parent1_phone">
            </div>
            <div class="col-md-5">
                <label id="formattedNumber" class="text-secondary text-secondary">x-xxxx-xxxxx-xx-x</label>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <label for="parent1_occupation" class="form-label text-secondary">อาชีพ</label>
                <input type="text" class="form-control" id="parent1_occupation" name="parent1_occupation" maxlength="13">
            </div>
            <div class="col-md-5">
                <label for="parent1_income" class="form-label text-secondary">รายได้ต่อปี</label>
                <input type="number" class="form-control" id="parent1_income" name="parent1_income">
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="main_parent" id="parent1_is_main_parent" value="parent1">
                    <label class="form-check-label" for="parent1_is_main_parent">
                    เป็นผู้แทนโดยชอบธรรม(เลือก 1 ในผู้ปกครอง)
                    </label>
                </div>
            </div>
            <div class="col-md-8"></div>
            
            <!-- end dad information -->


            <!-- mom information -->
            <div class="col-md-12 mb-2 mt-5">
                <h5 class="text-primary">คู่สมรสของผู้ปกครอง</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <fieldset class="row mb-3 mt-4">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_is_thai" value="parent2_is_thai" onchange="enableInputCountry('parent2',this.value)">
                        <label class="form-check-label" for="parent2_is_thai">
                        สัญชาติไทย
                        </label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent2_is_thai" id="parent2_not_thai" value="parent2_not_thai" onchange="enableInputCountry('parent2',this.value)">
                        <label class="form-check-label" for="parent2_not_thai">
                            อื่นๆ
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="parent2_country" id="parent2_country" placeholder="กรอกสัญชาติ" disabled>
                </div>
            </fieldset>
            <fieldset class="row mb-3 mt-4" id="thaiperson">
                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent2_is_alive" id="parent2_is_alive" value="true">
                        <label class="form-check-label" for="parent2_is_alive">
                        ยังมีชีวิตอยู่
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="parent2_is_alive" id="parent2_no_alive" value="false">
                        <label class="form-check-label" for="parent2_no_alive">
                        ถึงแก่กรรม
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="col-md-2">
                <label for="fname" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
                <input type="text" class="form-control" id="parent2_relational" name="parent2_relational">
            </div>

            <div class="col-md-10"></div>

            <div class="col-md-2">
                <label for="parent2_prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                <select id="parent2_prefix" name="parent2_prefix" class="form-select" aria-label="Default select example">
                    <option selected>เลือกคำนำหน้าชื่อ</option>
                    <option value="1">นาย</option>
                    <option value="2">นาง</option>
                    <option value="3">นางสาว</option>
                </select>
            </div>
            <div class="col-md-10"></div>

            <div class="col-md-5">
                <label for="parent2_fname" class="form-label text-secondary">ชื่อ</label>
                <input type="text" class="form-control" id="parent2_fname" name="parent2_fname">
            </div>
            <div class="col-md-5">
                <label for="parent2_lname" class="form-label text-secondary">นามสกุล</label>
                <input type="email" class="form-control" id="parent2_lname" name="parent2_lname">
            </div>
            <div class="col-md-5">
                <label for="parent2_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                <input type="date" class="form-control" id="parent2_birthday" name="parent2_birthday" onchange="ageCal('parent2')">
            </div>
            <div class="col-md-3">
                <label for="parent2_age" class="form-label text-secondary">อายุ</label>
                <input disabled type="text" class="form-control" id="parent2_age" name="parent2_age">
            </div>
            <div class="col-md-5">
                <label for="parent2_id_card_number" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                <input type="text" class="form-control" id="parent2_id_card_number" name="parent2_id_card_number" maxlength="13">
            </div>
            <div class="col-md-3">
                <label for="parent2_phone" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" id="parent2_phone" name="parent2_phone">
            </div>
            <div class="col-md-5">
                <label id="formattedNumber" class="text-secondary text-secondary">x-xxxx-xxxxx-xx-x</label>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <label for="parent2_occupation" class="form-label text-secondary">อาชีพ</label>
                <input type="text" class="form-control" id="parent2_occupation" name="parent2_occupation" maxlength="13">
            </div>
            <div class="col-md-5">
                <label for="parent2_income" class="form-label text-secondary">รายได้ต่อปี</label>
                <input type="number" class="form-control" id="parent2_income" name="parent2_income">
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="main_parent" id="parent2_is_main_parent" value="parent2">
                    <label class="form-check-label" for="parent2_is_main_parent">
                    เป็นผู้แทนโดยชอบธรรม(เลือก 1 ในผู้ปกครอง)
                    </label>
                </div>
            </div>
            <div class="col-md-8"></div>
            <!-- end mom information -->

            <!-- maritalStatus -->
            <fieldset class="row my-4" id="maritalStatusId">
                <h5 class="text-primary">สถานภาพสมรสของผู้ปกครอง</h5>
                <div class="col-md-11 line-section mt-2 mb-2"></div>

                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maritalStatus" id="option1" value="อยู่ด้วยกัน" selected>
                        <label class="form-check-label" for="option1">
                        อยู่ด้วยกัน
                        </label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maritalStatus" id="option2" value="แยกกันอยู่ตามอาชีพ">
                        <label class="form-check-label" for="option2">
                        แยกกันอยู่ตามอาชีพ
                        </label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-5 form-check">
                        <input class="form-check-input" type="radio" name="maritalStatus" id="devorce" value="หย่า">
                        <label class="form-check-label" for="devorce">
                        หย่า(แนบใบหย่า)
                        </label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <input disabled class="form-control" type="file" id="devorceFile">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-2 form-check">
                        <input class="form-check-input" type="radio" name="maritalStatus" id="other" value="option2">
                        <label class="form-check-label" for="other">
                        อื่นๆ
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input disabled type="text" class="form-control" id="otherText" name="otherText">
                    </div>
                </div>

            </fieldset>
            <!-- end maritalStatus -->

            <!-- main parent information -->

                <h5 class="text-primary">ข้อมูลที่อยู่ผู้แทนโดยชอบธรรม</h5>
                <div class="col-md-11 line-section mt-2"></div>

                <div class="col-md-5 mt-3 mb-3">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="prop1">
                      <label class="form-check-label" for="prop1">
                      ที่อยู่เดียวกันกับผู้กู้
                      </label>
                  </div>
                </div>
                <div class="col-md-7"></div>

                <div class="col-md-5">
                    <label for="main_parent_village" class="form-label text-secondary">หมู่บ้าน</label>
                    <input type="text" class="form-control" id="main_parent_village" name="main_parent_village">
                </div>

                <div class="col-md-3">
                    <label for="main_parent_houseNo" class="form-label text-secondary">บ้านเลขที่</label>
                    <input type="text" class="form-control" id="main_parent_houseNo" name="main_parent_houseNo">
                </div>

                <div class="col-md-3">
                    <label for="main_parent_villageNo" class="form-label text-secondary">หมู่ที่</label>
                    <input type="text" class="form-control" id="main_parent_villageNo" name="main_parent_villageNo">
                </div>

                <div class="col-md-5">
                    <label for="main_parent_street" class="form-label text-secondary">ซอย</label>
                    <input type="text" class="form-control" id="main_parent_street" name="main_parent_street">
                </div>

                <div class="col-md-5">
                    <label for="main_parent_road" class="form-label text-secondary">ถนน</label>
                    <input type="text" class="form-control" id="main_parent_road" name="main_parent_road">
                </div>

                <div class="col-md-3">
                    <label for="main_parent_postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control" id="main_parent_postcode" name="main_parent_postcode" onblur="addressWithZipcode(this.value)">
                </div>
                <div class="col-md-9"></div>

                <div class="col-md-5">
                    <label for="main_parent_province" class="form-label text-secondary">จังหวัด</label>
                    <input type="text" class="form-control" id="main_parent_province" name="main_parent_province" readonly>
                </div>

                <div class="col-md-5">
                    <label for="main_parent_aumphure" class="form-label text-secondary">อำเภอ</label>
                    <input type="text" class="form-control" id="main_parent_aumphure" name="main_parent_aumphure" readonly>
                </div>

                <div class="col-md-5">
                <label for="main_parent_tambon" class="col-md-12 col-form-label text-secondary">ตำบล</label>
                    <select id="main_parent_tambon" name="main_parent_tambon" class="form-select" aria-label="Default select example">
                        <option selected>เลือกตำบล</option>
                </select>
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
                <button type="button" class="btn btn-primary" onclick="nextPgae('representative-tab')">บันทึกข้อมูล</button>
            </div>
        </form>
</div><!-- End Bordered Tabs -->

<script>
    function enableInputCountry(parentNo,isthai){
        console.log(parentNo)
        if(isthai == `${parentNo}_not_thai`){
            document.querySelector(`#${parentNo}_country`).disabled = false;
        }else{
            document.querySelector(`#${parentNo}_country`).disabled = true;
        }

    }

    const MaritalStat = document.getElementById('maritalStatusId');
    MaritalStat.onchange = () =>{
        const otherMaritalStat = document.getElementById('other');
        if(otherMaritalStat.checked){
            document.getElementById('otherText').disabled = false;
        }else{
            document.getElementById('otherText').disabled = true;
        }
        
        const devorce = document.getElementById('devorce');
        if(devorce.checked){
            document.getElementById('devorceFile').disabled = false;
        }else{
            document.getElementById('devorceFile').disabled = true;
        }
    }

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
            var selectElement = document.getElementById('main_parent_tambon');
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
                    document.getElementById('main_parent_aumphure').value = aumphure.name_th;
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
                    if(province_id == province.id)document.getElementById('main_parent_province').value = province.name_th;
                }
                
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }
</script>
