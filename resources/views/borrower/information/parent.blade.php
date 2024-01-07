<div class="mt-2 mb-2">
        <form action="" class="row g-3" id="form-parent">
            @csrf          
            <!-- dad information -->
            <div class="col-md-12 my-4">
                <h5 class="text-primary" >ข้อมูลผู้ปกครอง</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <fieldset class="row mb-3 mt-4" id="Dthaiperson">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Dthaiperson" id="Dthai" value="Dthai" checked>
                        <label class="form-check-label" for="Dthai">
                        ชาวไทย
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Dthaiperson" id="DnonThai" value="DnonThai">
                        <label class="form-check-label" for="DnonThai">
                        ชาวต่างชาติ
                        </label>
                    </div>
                </div>
            </fieldset>
            <fieldset class="row mb-3 mt-4" id="thaiperson">
                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alive" id="Dalive" value="Dalive" checked>
                        <label class="form-check-label" for="Dalive">
                        ยังมีชีวิตอยู่
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alive" id="DnonAlive" value="DnonAlive">
                        <label class="form-check-label" for="DnonAlive">
                        ถึงแก่กรรม
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="col-md-2">
                <label for="fname" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
                <input type="text" class="form-control" id="borrower-relation" name="borrower-relation">
            </div>

            <div class="col-md-10"></div>

            <div class="col-md-2">
                <label for="Mprefix" class="col-form-label text-secondary">คำนำหน้า</label>
                <select id="Mprefix" name="Mprefix" class="form-select" aria-label="Default select example">
                    <option selected>เลือกคำนำหน้าชื่อ</option>
                    <option value="1">นาย</option>
                    <option value="2">นาง</option>
                    <option value="3">นางสาว</option>
                </select>
            </div>
            <div class="col-md-10"></div>

            <div class="col-md-5">
                <label for="fname" class="form-label text-secondary">ชื่อ</label>
                <input type="text" class="form-control" id="Dfname" name="Dfname">
            </div>
            <div class="col-md-5">
                <label for="lname" class="form-label text-secondary">นามสกุล</label>
                <input type="email" class="form-control" id="lname" name="lname">
            </div>
            <div class="col-md-5">
                <label for="p1_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                <input type="date" class="form-control" id="p1_birthday" name="p1_birthday" onchange="ageCal('p1')">
            </div>
            <div class="col-md-3">
                <label for="p1_age" class="form-label text-secondary">อายุ</label>
                <input disabled type="text" class="form-control" id="p1_age" name="p1_age">
            </div>
            <div class="col-md-5">
                <label for="idCardNumber" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                <input type="text" class="form-control" id="idCardNumber" name="idCardNumber" maxlength="13">
            </div>
            <div class="col-md-3">
                <label for="studentId" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" id="dadPhone" name="dadphone">
            </div>
            <div class="col-md-5">
                <label id="formattedNumber" class="text-secondary text-secondary">x-xxxx-xxxxx-xx-x</label>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <label for="idCardNumber" class="form-label text-secondary">อาชีพ</label>
                <input type="text" class="form-control" id="idCardNumber" name="idCardNumber" maxlength="13">
            </div>
            <div class="col-md-5">
                <label for="studentId" class="form-label text-secondary">รายได้ต่อปี</label>
                <input type="number" class="form-control" id="studentId" name="studentId">
            </div>
            
            <!-- end dad information -->


            <!-- mom information -->
            <div class="col-md-12 mb-2 mt-5">
                <h5 class="text-primary">คู่สมรสของผู้ปกครอง</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <fieldset class="row mb-3 mt-4" id="Mthaiperson">
                <!-- <label class="form-label text-secondary">สัญชาติมารดา</label> -->
                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Mthisperson" id="Mthai" value="Mthai" checked>
                        <label class="form-check-label" for="Mthai">
                        ชาวไทย
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Mthisperson" id="MnonThai" value="MnonThai">
                        <label class="form-check-label" for="MnonThai">
                        ชาวต่างชาติ
                        </label>
                    </div>
                </div>
            </fieldset>
            <fieldset class="row mb-3 mt-4" id="thaiperson">
                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Malive" id="Dalive" value="Dalive" checked>
                        <label class="form-check-label" for="Dalive">
                        ยังมีชีวิตอยู่
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Malive" id="DnonAlive" value="DnonAlive">
                        <label class="form-check-label" for="DnonAlive">
                        ถึงแก่กรรม
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="col-md-2">
                <label for="fname" class="form-label text-secondary">เกี่ยวข้องกับผู้กู้โดยเป็น</label>
                <input type="text" class="form-control" id="borrower-relation" name="borrower-relation">
            </div>

            <div class="col-md-12"></div>

            <div class="col-md-2">
                <label for="Mprefix" class="col-form-label text-secondary">คำนำหน้า</label>
                <select id="Mprefix" name="Mprefix" class="form-select" aria-label="Default select example">
                    <option selected>เลือกคำนำหน้าชื่อ</option>
                    <option value="1">นาย</option>
                    <option value="2">นาง</option>
                    <option value="3">นางสาว</option>
                </select>
            </div>
            <div class="col-md-10"></div>
            <div class="col-md-5">
                <label for="fname" class="form-label text-secondary">ชื่อ</label>
                <input type="text" class="form-control" id="Dfname" name="Dfname">
            </div>
            <div class="col-md-5">
                <label for="lname" class="form-label text-secondary">นามสกุล</label>
                <input type="email" class="form-control" id="lname" name="lname">
            </div>
            <div class="col-md-5">
                <label for="p2_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                <input type="date" class="form-control" id="p2_birthday" name="p2_birthday" onchange="ageCal('p2')">
            </div>
            <div class="col-md-3">
                <label for="p2_age" class="form-label text-secondary">อายุ</label>
                <input disabled type="text" class="form-control" id="p2_age" name="p2_age">
            </div>
            <div class="col-md-5">
                <label for="idCardNumber" class="form-label text-secondary">เลขบัตรประชาชน 13 หลัก </label>
                <input type="text" class="form-control" id="idCardNumber" name="idCardNumber" maxlength="13">
            </div>
            <div class="col-md-3">
                <label for="studentId" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" id="dadPhone" name="dadphone">
            </div>
            <div class="col-md-5">
                <label id="formattedNumber" class="text-secondary text-secondary">x-xxxx-xxxxx-xx-x</label>
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <label for="idCardNumber" class="form-label text-secondary">อาชีพ</label>
                <input type="text" class="form-control" id="idCardNumber" name="idCardNumber" maxlength="13">
            </div>
            <div class="col-md-5">
                <label for="studentId" class="form-label text-secondary">รายได้ต่อปี</label>
                <input type="number" class="form-control" id="studentId" name="studentId">
            </div>
            <!-- end mom information -->
            <!-- maritalStatus -->
            <fieldset class="row mb-3 mt-4" id="maritalStatusId">
                <h5 class="text-primary">สถานภาพสมรสของผู้ปกครอง</h5>
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
            <div class="col-md-12 mb-2 mt-4">
                <h5 class="text-primary">ข้อมูลผู้แทนโดยชอบธรรม</h5>
                <div class="col-md-11 line-section mt-2 mb-2"></div>
            </div>

            <div class="col-md-3 mt-2">
                  <label for="grade" class="col-md-12 col-form-label text-secondary">เลือกผู้แทนโดยชอบธรรม</label>

                  <select id="grade" name="grade" class="form-select" aria-label="Default select example">
                      <option selected>เลือกผู้แทน</option>
                      <option value="1">บิดา (นายไกรวุฒิ จตุรอาชานันท์)</option>
                      <option value="2">มารดา (นางสณัญญา จตุรอาชานันท์)</option>
                  </select>
                </div>

                <h5 class="text-primary mb-4">ข้อมูลที่อยู่ของผู้แทนโดยชอบธรรม</h5>

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

                <div class="col-md-5">
                    <label for="city" class="col-md-12 col-form-label text-secondary">จังหวัด</label>
                    <select id="city" name="city" class="form-select" aria-label="Default select example">
                        <option selected>เลือกจังหวัด</option>
                        <option value="1">1</option>
                    </select>
                </div>

                <div class="col-md-5">
                <label for="district" class="col-md-12 col-form-label text-secondary">อำเภอ</label>
                <select disabled id="district" name="district" class="form-select" aria-label="Default select example">
                    <option selected>เลือกอำเภอ</option>
                    <option value="1">1</option>
                </select>
                </div>

                <div class="col-md-5">
                <label for="subDistrict" class="col-md-12 col-form-label text-secondary">ตำบล</label>
                <select disabled id="subDistrict" name="subDistrict" class="form-select" aria-label="Default select example">
                    <option selected>เลือกตำบล</option>
                    <option value="1">1</option>
                </select>
                </div>

                <div class="col-md-7"></div>


                <div class="col-md-3 mt-3">
                    <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control" id="postcode" name="postcode">
                </div>

            <!-- end main parent information -->
            
            <div class="text-end">
                <!-- reset Modal-->
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#non-parent-basic-modal">
                    reset
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
</script>
