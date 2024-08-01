@extends('layout')
@section('title')
ลงทะเบียนผู้กู้
@endsection
<style>
    .breadcrumb li {
        display: inline-block;
        background: #F1F5FA;
        padding: 20px 60px;
        position: relative;
        min-width: 100px;
        margin-right: -37px;
        margin-left: 0px;
    }

    .last {
        -webkit-clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 50%, calc(100% - 30px) 100%, 0 100%, 30px 50%);
        clip-path: polygon(0 0, calc(100% - 30px) 0, 100% 50%, calc(100% - 30px) 100%, 0 100%, 30px 50%);
        margin-right: 0px;
        margin-left: 0px;
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
        
        color: white !important;
    }

    .status{
        min-width: 100px; 
        width: 100px; 
        height: 20px; 
        border-radius: 10px !important;
    }
</style>
@section('content')
<section class="section Editing my-4 container-fluid bg-white">

    <ul class="nav breadcrumb row pt-4 pb-4" id="myTab" role="tablist">
        <li class="nav-item col-md-auto last" role="presentation">
            <a class="nav-link active text-dark" id="borrower-type-tab" data-bs-toggle="tab" href="#borrower-type" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
        </li>
        <li class="nav-item col-md-auto last" role="presentation">
            <a class="nav-link text-dark" id="send-documents-tab" data-bs-toggle="tab" href="#send-documents" role="tab" aria-controls="send-documents" aria-selected="false">ส่งเอกสาร</a>
        </li>
        <li class="nav-item col-md-auto last" role="presentation">
            <a class="nav-link text-dark" id="check-documents-tab" data-bs-toggle="tab" href="#check-documents" role="tab" aria-controls="check-documents" aria-selected="false">ตรวจสอบเอกสาร</a>
        </li>
        <li class="nav-item col-md-auto last" role="presentation">
            <a class="nav-link text-dark" id="request-status-tab" data-bs-toggle="tab" href="#request-status" role="tab" aria-controls="request-status" aria-selected="false">สถานะคำร้อง</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="borrower-type" role="tabpanel" aria-labelledby="borrower-type-tab">

            <div class="card mx-3">
                <div class="card-body pt-3" style="background-color: #F1F5FA">
                    <span class="mx-2 pb-4">ท่านเคยกู้ยืมกับมหาวิทยาลัยหรือไม่</span>
                    <div class="row">
                        <div class="col-md-12 pt-3 mx-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="borrower" id="new_borrower" value="เป็นผู้กู้ยืมรายใหม่">
                                <label class="form-check-label" for="new_borrower">
                                    <b>เป็นผู้กู้ยืมรายใหม่</b>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-10 pt-3 mx-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="borrower" id="old_borrower" value="เป็นผู้กู้ยืมรายเก่า">
                                <label class="form-check-label" for="old_borrower">
                                    <b>เป็นผู้กู้ยืมรายเก่า</b>
                                </label>
                                <label for="loan_session" class="form-label">โดยกู้ยืมในระดับอุดมศึกษาครั้งนี้ครั้งที่</label>
                                <input type="text" class="mx-2 col-md-1 col-3" name="loan_session" id="loan_session">
                            </div>
                        </div>
                    </div>
                    <div class="text-end pt-4">
                        <button type="button" class="btn btn-primary" onclick="nextPage('send-documents-tab')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="send-documents" role="tabpanel" aria-labelledby="send-documents-tab">

            <div class="card mx-3">
                <div class="card-body" style="background-color: #F1F5FA">
                    <h5 class="card-title">Title</h5>
                    <div class="row">
                        <div class="col-md-12 row my-2">
                            <label class="col-sm-2 col-form-label text-secondary" for="component-file">ไฟล์ประกอบไปด้วย</label>
                            <div class="col-sm-10">
                                <ul class="list-group list-borderless">
                                    <li class="list-group-item">
                                        - Title
                                    </li>
                                    <li class="list-group-item">
                                        - Addon File
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 row my-2">
                            <label class="col-sm-2 col-form-label text-secondary" for="component-file">ตัวอย่างเอกสาร</label>
                            <div class="col-sm-10">
                                <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger w-100">คลิกเพื่อดูไฟล์ตัวอย่าง</a>
                            </div>
                        </div>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data" class="row">
                        @csrf
                        <div class="col-md-12 row my-2">
                            <label class="col-sm-2 col-form-label text-secondary" for="name" >เลือกไฟล์</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="file" name="name" id="name" accept=".jpg, .jpeg, .png, .pdf" required >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pt-3 pb-3"></div>

            <div class="card mx-3">
                <div class="card-body" style="background-color: #F1F5FA">
                    <div class="d-flex justify-content-between">
                        <span class="text-start mx-3 mt-3"><b>ส่งเอกสารแล้ว 0/10 </b></span>
                        <button type="button" class="text-end btn btn-primary mt-3" onclick="nextPage('check-documents-tab')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="check-documents" role="tabpanel" aria-labelledby="check-documents-tab">
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
                        <input class="form-check-input mx-2" type="checkbox" name="copy_student_id_card" id="copy_student_id_card" value="1">
                        <label class="form-check-label mx-3" for="copy_student_id_card">
                            1. สำเนาบัตรประชาชนของนักศึกษา รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="student_consent" id="student_consent" value="2">
                        <label class="form-check-label mx-3" for="student_consent">
                            2. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของนักศึกษา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="copy_parent_id_card" id="copy_parent_id_card" value="3">
                        <label class="form-check-label mx-3" for="copy_parent_id_card">
                            3. สำเนาบัตรประชาชนของบิดา มารดา ผู้แทนโดยชอบธรรม รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="parent_consent" id="parent_consent" value="4">
                        <label class="form-check-label mx-3" for="parent_consent">
                            4. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของบิดา มารดา ผู้แทนโดยชอบธรรม
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="family_income" id="family_income" value="5">
                        <label class="form-check-label mx-3" for="family_income">
                            5. หนังสือรับรองรายได้ครอบครัว
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <div class="container col-md-11">
                            <input class="form-check-input mx-1" type="checkbox" name="regular_income" id="regular_income" value="5.1">
                        </div>
                        <label class="form-check-label mx-3" for="regular_income">
                            5.1 มีรายได้ประจำ แนบหนังสือรับรองเงินเดือน/สลิปเงินเดือน
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <div class="container col-md-11">
                            <input class="form-check-input mx-1" type="checkbox" name="no_regular_income" id="no_regular_income" value="5.2">
                        </div>
                        <label class="form-check-label mx-3" for="no_regular_income">
                            5.2 ไม่มีรายได้ประจำ (แบบกยศ.102 แนบสำเนาบัตรเจ้าหน้าที่ของรัฐ รับรองสำเนาถูกต้อง)
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="teacher_opinion" id="teacher_opinion" value="6">
                        <label class="form-check-label mx-3" for="teacher_opinion">
                            6. หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="house_photo" id="house_photo" value="7">
                        <label class="form-check-label mx-3" for="house_photo">
                            7. รูปถ่ายบ้านที่อยู่อาศัยของผู้ปกครองและนักศึกษา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="gpa" id="gpa" value="8">
                        <label class="form-check-label mx-3" for="gpa">
                            8. สำเนาใบรายงานผลการเรียน/สำเร็จการศึกษาในปีการศึกษาที่ผ่านมา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="activities" id="activities" value="9">
                        <label class="form-check-label mx-3" for="activities">
                            9. บันทึกกิจกรรมจิตอาสา
                        </label>
                    </div>
                    <div class="form-check mx-4 px-4">
                        <input class="form-check-input mx-2" type="checkbox" name="other" id="other" value="10">
                        <label class="form-check-label mx-3" for="other">
                            10. อื่นๆ (ถ้ามี) เช่น สำเนาบัตรสวัสดิการแห่งรัฐ/สำเนาใบเปลี่ยนชื่อ-สกุล/ใบมรณบัตร/ใบหย่า..............
                        </label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary pt-1" onclick="nextPage('request-status-tab')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade d-flex flex-column align-items-center" id="request-status" role="tabpanel" aria-labelledby="request-status-tab">

            <div class="card d-flex flex-column align-items-center pt-3 mb-4 px-3 col-md-6" style="background-color: #F1F5FA">
                <div class="card section dashboard pt-4 mb-4 col-md-12 col-11">
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
                                <span class="badge bg-success status">เสร็จสิ้น</span>
                                <div class="activite-label"></div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    ผู้กู้ส่งเอกสาร
                                </div>
                            </div><!-- End activity item-->
    
                            <div class="activity-item d-flex">
                                <span class="badge bg-warning status">รอดำเนินการ</span>
                                <div class="activite-label col-1"></div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    อาจารย์ที่ปรึกษาให้ความเห็น
                                </div>
                            </div><!-- End activity item-->
    
                            <div class="activity-item d-flex">
                                <span class="badge bg-warning status">รอดำเนินการ</span>
                                <div class="activite-label col-1"></div>
                                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                <div class="activity-content">
                                    ฝ่ายทุนตรวจเอกสาร
                                </div>
                            </div><!-- End activity item-->
    
                            <div class="activity-item d-flex">
                                <span class="badge bg-warning status">รอดำเนินการ</span>
                                <div class="activite-label col-1"></div>
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
    <script>
        function nextPage(page) {
            document.getElementById(page).click();
            window.scrollTo(0, 0);
        }
    </script>
</section>
@endsection
