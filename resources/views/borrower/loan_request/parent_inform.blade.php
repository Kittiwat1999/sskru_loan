<div class="mt-2 mb-2"></div>
<ul class="nav nav-tabs " id="parentTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent" type="button" role="tab" aria-controls="parent" aria-selected="true">ผู้ปกครองที่เป็นบิดา-มารดา</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="non-parent-tab" data-bs-toggle="tab" data-bs-target="#non-parent" type="button" role="tab" aria-controls="non-parent" aria-selected="false">กรณีไม่ใช่บิดา-มารดา</button>
    </li>
</ul>
<div class="tab-content pt-2" id="parentTabContent">
    <div class="tab-pane fade show active" id="parent" role="tabpanel" aria-labelledby="parent-tab">
        <form action="" class="row g-3" id="form-parent">
            <fieldset class="row mb-3 mt-4" id="maritalStatusId">
                <label class="form-label text-primary">สถานภาพสมรสของบิดา-มารดา</label>
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
            <!-- dad information -->
            <div class="col-md-12 mb-3">
                <h5 class="text-primary">ข้อมูลบิดา</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <div class="col-md-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="DhaveData" checked>
                    <label class="form-check-label" for="DhaveData">
                        มีข้อมูลบิดา
                    </label>
                </div>
            </div>
            <fieldset class="row mb-3 mt-4" id="Dthaiperson">
                <!-- <label class="form-label text-secondary">สัญชาติบิดา</label> -->
                <!-- <legend class="form-label col-sm-2 pt-0" for>Radios</legend> -->
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
                <label for="Dprefix" class="col-form-label text-secondary">คำนำหน้า</label>
                <select disabled id="Dprefix" name="Dprefix" class="form-select" aria-label="Default select example">
                    <option >เลือกคำนำหน้าชื่อ</option>
                    <option selected value="1">นาย</option>
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
                <label for="D_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                <input type="date" class="form-control" id="D_birthday" name="D_birthday" onchange="ageCal('D')">
            </div>
            <div class="col-md-3">
                <label for="D_age" class="form-label text-secondary">อายุ</label>
                <input disabled type="text" class="form-control" id="D_age" name="D_age">
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
            <div class="col-md-12 mb-2 mt-4">
                <h5 class="text-primary">ข้อมูลมารดา</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <div class="col-md-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="DhaveData" checked>
                    <label class="form-check-label" for="DhaveData">
                        มีข้อมูลมารดา
                    </label>
                </div>
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
                <label for="Mprefix" class="col-form-label text-secondary">คำนำหน้า</label>
                <select id="Mprefix" name="Mprefix" class="form-select" aria-label="Default select example">
                    <option selected>เลือกคำนำหน้าชื่อ</option>
                    <option value="1">นาง</option>
                    <option value="2">นางสาว</option>
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
                <label for="M_birthday" class="form-label text-secondary">เกิดเมื่อ</label>
                <input type="date" class="form-control" id="M_birthday" name="M_birthday" onchange="ageCal('M')">
            </div>
            <div class="col-md-3">
                <label for="M_age" class="form-label text-secondary">อายุ</label>
                <input disabled type="text" class="form-control" id="M_age" name="M_age">
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
            <div class="text-end">
                <!-- reset Modal-->
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#parant-reset-modal">
                    reset
                </button>
                <div class="modal fade" id="parant-reset-modal" tabindex="-1">
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
    </div>
    <div class="tab-pane fade" id="non-parent" role="tabpanel" aria-labelledby="non-parent-tab">
        <form action="" class="row g-3" id="form-parent">              
            <!-- dad information -->
            <div class="col-md-12 mb-2 mt-4">
                <h5 class="text-primary">ผู้ปกครองที่ไม่ใช่บิดา-มารดา</h5>
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
                <h5 class="text-primary">คู่สมรสของผู้ปกครองที่ไม่ใช่บิดา-มารดา</h5>
                <div class="col-md-11 line-section mt-2"></div>
            </div>
            <div class="col-md-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="DhaveData" checked>
                    <label class="form-check-label" for="DhaveData">
                        คู่สมรสของผู้ปกครองที่ไม่ใช่บิดา-มารดา
                    </label>
                </div>
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
    </div>
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
