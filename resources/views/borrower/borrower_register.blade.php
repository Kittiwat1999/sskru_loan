@extends('layout')
@section('title')
สรุปการส่งเอกสาร
@endsection
<style>
    .breadcrumb li {
        display: inline-block;
        background: #F1F5FA;
        padding: 10px 60px;
        position: relative;
        min-width: 100px;
        margin-right: -30px;
    }

    .breadcrumb li#last {
        -webkit-clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 50%, calc(100% - 30px) 100%, 0 100%, 30px 50%);
        clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 50%, calc(100% - 30px) 100%, 0 100%, 30px 50%);
    }

    .label {
        height: 100%;
        width: 100%;
    }

    .nav-link.active {
        display: inline-block;
        background-color: #4382FB;
        padding: 20px 60px;
        position: relative;
        min-width: 100px;
        -webkit-clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 50%, calc(100% - 30px) 100%, 0 100%, 30px 50%);
        clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 50%, calc(100% - 30px) 100%, 0 100%, 30px 50%);
        margin-right: -13px;
        color: white !important;
    }
</style>
@section('content')
<section class="section Editing min-vh-100 py-4 bg-white">

    <ul class="nav breadcrumb px-3 pb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active text-dark" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ประเภทผู้กู้ยืม</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-dark" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ส่งเอกสาร</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-dark" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">ตรวจสอบเอกสาร</a>
        </li>
        <li class="nav-item" role="presentation" id="last">
            <a class="nav-link text-dark" id="status-tab" data-bs-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">สถานะคำร้อง</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card mx-3">
                <div class="card-body pt-3" style="background-color: #F1F5FA">
                    <span class="mx-2 pb-4">ท่านเคยกู้ยืมกับมหาวิทยาลัยหรือไม่</span>
                    <div class="form-check mx-4 pt-3">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            <b>เป็นผู้กู้ยืมรายใหม่</b>
                        </label>
                    </div>
                    <div class="form-check mx-4 pt-3 pb-3">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="defaultCheck2">
                        <label class="form-check-label" for="defaultCheck2">
                            <b>เป็นผู้กู้ยืมรายเก่า</b>
                        </label>
                        <label for="basic-url" class="form-label">โดยกู้ยืมในระดับอุดมศึกษาครั้งนี้ครั้งที่ </label>
                        <input type="text" class="mx-2 col-md-1" id="basic-url">
                    </div>
                    <div class="text-end pt-4">
                        <button type="button" class="btn btn-primary" onclick="nextPage('profile-tab')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="card mx-3">
                <div class="card-body" style="background-color: #F1F5FA">
                    <div class="text-center mx-4 pt-4 pb-4"></div>
                    <div class="text-center mx-4 pt-4 pb-4">
                        <span class="text-danger">(**component ที่ส่งให้**)</span>
                    </div>
                    <div class="text-center mx-4 pt-4 pb-4"></div>
                </div>
            </div>
            <div class="pt-3 pb-3"></div>

            <div class="card mx-3">
                <div class="card-body" style="background-color: #F1F5FA">
                    <div class="d-flex justify-content-between">
                        <span class="text-start mx-4 pt-3"><b>ส่งเอกสารแล้ว 0/10 </b></span>
                        <button type="button" class="text-end btn btn-primary pt-1" onclick="nextPage('contact-tab')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="card mx-3">
                <div class="card-body" style="background-color: #F1F5FA">
                    <div class="text-center mx-4 pt-4 pb-4"></div>
                    <div class="text-center mx-4 pt-4 pb-4">
                        <span>ตรวจสอบการส่งเอกสาร</span>
                    </div>
                    <div class="text-center mx-4 pt-4 pb-4"></div>
                </div>
            </div>
            <div class="pt-3 pb-3"></div>

            <div class="card mx-3">
                <div class="card-body" style="background-color: #F1F5FA">
                    <span class="mx-4 fs-5">ข้าพเจ้าได้แนบเอกสารต่างๆ ตามที่กองทุนกำหนดเพื่อประกอบการพิจารณาครบถ้วนทุกรายการ อย่างละ 1 ฉบับ ได้แก่</span>
                    <div class="form-check mx-4 px-4 pt-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check1">
                        <label class="form-check-label mx-3" for="check1">
                            1. สำเนาบัตรประชาชนของนักศึกษา รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check2">
                        <label class="form-check-label mx-3" for="check2">
                            2. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของนักศึกษา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check3">
                        <label class="form-check-label mx-3" for="check3">
                            3. สำเนาบัตรประชาชนของบิดา มารดา ผู้แทนโดยชอบธรรม รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check4">
                        <label class="form-check-label mx-3" for="check4">
                            4. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของบิดา มารดา ผู้แทนโดยชอบธรรม
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check5">
                        <label class="form-check-label mx-3" for="check5">
                            5. หนังสือรับรองรายได้ครอบครัว
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <div class="container col-md-11">
                            <input class="form-check-input mx-1" type="checkbox" id="check5-1">
                        </div>
                        <label class="form-check-label mx-3" for="check5-1">
                            5.1 มีรายได้ประจำ แนบหนังสือรับรองเงินเดือน/สลิปเงินเดือน
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <div class="container col-md-11">
                            <input class="form-check-input mx-1" type="checkbox" id="check5-2">
                        </div>
                        <label class="form-check-label mx-3" for="check5-2">
                            5.2 ไม่มีรายได้ประจำ (แบบกยศ.102 แนบสำเนาบัตรเจ้าหน้าที่ของรัฐ รับรองสำเนาถูกต้อง)
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check6">
                        <label class="form-check-label mx-3" for="check6">
                            6. หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check7">
                        <label class="form-check-label mx-3" for="check7">
                            7. รูปถ่ายบ้านที่อยู่อาศัยของผู้ปกครองและนักศึกษา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check8">
                        <label class="form-check-label mx-3" for="check8">
                            8. สำเนาใบรายงานผลการเรียน/สำเร็จการศึกษาในปีการศึกษาที่ผ่านมา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check9">
                        <label class="form-check-label mx-3" for="check9">
                            9. บันทึกกิจกรรมจิตอาสา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" id="check10">
                        <label class="form-check-label mx-3" for="check10">
                            10. อื่นๆ (ถ้ามี) เช่น สำเนาบัตรสวัสดิการแห่งรัฐ/สำเนาใบเปลี่ยนชื่อ-สกุล/ใบมรณบัตร/ใบหย่า..............
                        </label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary pt-1" onclick="nextPage('status-tab')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade d-flex flex-column align-items-center" id="status" role="tabpanel" aria-labelledby="status-tab">
            <!-- Recent Activity -->
            {{-- <div class="card d-flex flex-column align-items-center py-4 pt-4 mt-4 px-4 col-md-8" style="background-color: #F1F5FA">

                <div class="card-body col-md-8" style="background-color: #FFFFFF">
                    <div class="filter text-end pt-4">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <h5 class="card-title text-dark"><b>สถานะการยื่นกู้</b></h5>

                <div class="activity">

                    <div class="activity-item d-flex">
                    <span class="badge bg-success">เสร็จสิ้น</span>
                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                    <div class="activity-content">
                        ผู้กู้ส่งเอกสาร
                    </div>
                    </div><!-- End activity item-->

                    <div class="activity-item d-flex">
                    <span class="badge bg-warning">รอดำเนินการ</span>
                    <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                    <div class="activity-content">
                        อาจารย์ที่ปรึกษาให้ความเห็น
                    </div>
                    </div><!-- End activity item-->

                    <div class="activity-item d-flex">
                    <span class="badge bg-warning">รอดำเนินการ</span>
                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                    <div class="activity-content">
                        ฝ่ายทุนตรวจเอกสาร
                    </div>
                    </div><!-- End activity item-->

                    <div class="activity-item d-flex">
                    <span class="badge bg-warning">รอดำเนินการ</span>
                    <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                    <div class="activity-content">
                        ยื่นกู้เสร็จสิ้น
                    </div>
                    </div><!-- End activity item-->

                </div>

                </div>
            </div> --}}
            <!-- End Recent Activity -->

            <section class="section dashboard pt-4 col-lg-5 pb-4">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="row">
                                <div class="card">
                                    <div class="filter">
                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                            </li>

                                            <li><a class="dropdown-item" href="#">Today</a></li>
                                            <li><a class="dropdown-item" href="#">This Month</a></li>
                                            <li><a class="dropdown-item" href="#">This Year</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                    <h5 class="card-title">สถานะการยื่นกู้</h5>

                                    <div class="activity">

                                        <div class="activity-item d-flex">
                                            <span class="badge bg-success" style="width: 100px; height: 20px; border-radius: 20px;">เสร็จสิ้น</span>
                                            <div class="activite-label"></div>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                            <div class="activity-content">
                                                ผู้กู้ส่งเอกสาร
                                            </div>
                                        </div><!-- End activity item-->

                                        <div class="activity-item d-flex">
                                            <span class="badge bg-warning" style="width: 100px; height: 20px; border-radius: 20px;">รอดำเนินการ</span>
                                            <div class="activite-label"></div>
                                            <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                            <div class="activity-content">
                                                อาจารย์ที่ปรึกษาให้ความเห็น
                                            </div>
                                        </div><!-- End activity item-->

                                        <div class="activity-item d-flex">
                                            <span class="badge bg-warning" style="width: 100px; height: 20px; border-radius: 20px;">รอดำเนินการ</span>
                                            <div class="activite-label"></div>
                                            <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                            <div class="activity-content">
                                                ฝ่ายทุนตรวจเอกสาร
                                            </div>
                                        </div><!-- End activity item-->

                                        <div class="activity-item d-flex">
                                            <span class="badge bg-warning" style="width: 100px; height: 20px; border-radius: 20px;">รอดำเนินการ</span>
                                            <div class="activite-label"></div>
                                            <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                            <div class="activity-content">
                                                ยื่นกู้เสร็จสิ้น
                                            </div>
                                        </div><!-- End activity item-->

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
    <script>
        function nextPage(page) {
            document.getElementById(page).click();
            window.scrollTo(0, 0);
        }
    </script>
</section>
@endsection
