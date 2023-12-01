@extends('layout')
@section('titile')
edit borrower information
@endsection
@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body pt-3">
            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-black" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit"
                        type="button" role="tab" aria-controls="edit"
                        aria-selected="true">แก้ใขข้อมูล</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-black" id="document-tab" data-bs-toggle="tab" data-bs-target="#document"
                        type="button" role="tab" aria-controls="document"
                        aria-selected="true">แนบหลักฐานแก้ไขข้อมูลผู้กู้</button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                     
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

                        <div class="col-md-3 mt-4">
                            <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" id="postcode" name="postcode">
                        </div>

                        <div class="col-md-5">
                            <label for="phoneNumber" class="form-label text-secondary">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber">
                        </div>
                        <div class="col-md-7"></div>
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('document-tab')">แนบหลักฐาน</button>
                        </div>
                    </form><!-- End Multi Columns Form -->

                </div>
                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                    <br>
                    <div class="row-cols-auto">
                        <div class="col-md-6">
                            <label for="file" class="text-secondary">เอกสารแก้ไขข้อมูลผู้กู้</label>
                        </div>
                        <br>
                        <div class="col-md-8">
                            <div>
                                <input name="file" type="file" class="form-control" id="file">
                            </div>
                    </div>                         
                    <div align="right">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
                            ถัดไป
                        </button>
                        <!-- Large Modal -->
                        <div class="modal fade" id="largeModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">ยืนยันการส่งเอกสาร</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                            <div class="container bg-light">
                                                <div align="center">
                                                    <br><br>
                                                    เอกสารแก้ไขข้อมูลผู้กู้ &nbsp; <img src="{{asset('assets/img/pngwing.com.png')}}" alt="" height="20px">
                                                    <br><br><br><br>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- End Large Modal-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function nextPgae(page){
        console.log(page);
        document.getElementById(page).click();
        window.scrollTo(0, 0);
      }
</script>
@endsection