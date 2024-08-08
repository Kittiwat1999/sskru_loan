@extends('layout')
@section('title')
ยื่นกู้
@endsection
<style>

    .label {
        height: 100%;
        width: 100%;
    }

    .nav-link.active {
        background-color: #4382FB;
        -webkit-clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
        clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
        color: white !important;
    }

    /* .status{
        min-width: 100px; 
        width: 100px; 
        height: 20px; 
        border-radius: 10px !important;
    } */
</style>
@section('content')
<section >
    <div class="card mb-3">
        <div class="card-body pb-0 mb-0">
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="{{route('borrower.register')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}" >ส่งเอกสาร</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-dark text-center m-0 active" id="check-documents-tab" href="{{route('borrower.register.result')}}" >ตรวจสอบเอกสาร</a>
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    <a class="nav-link text-secondary text-center m-0" id="request-status-tab" href="{{route('borrower.register.status')}}" @disabled(false)>สถานะคำร้อง</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">สรุปการส่งเอกสาร</h5>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <ul class="list-group list-borderless">
                        @foreach($child_documents as $child_document)
                            <li class="list-group-item d-flex justify-content-between">
                                <span class=" {{ ($child_document->borrower_child_document) ? 'text-success' : 'text-dark' }}" >
                                    <h6>- {{$child_document->child_document_title}} </h6>
                                    @if($child_document->need_loan_balance)
                                        <div class="px-4">
                                            <small class="text-dark"> ค่าเล่าเรียนที่เบิก: {{number_format($child_document->borrower_child_document->education_fee)}}</small><br>
                                            <small class="text-dark"> ค่าครองชีพที่เบิก: {{number_format($child_document->borrower_child_document->living_exprenses)}}</small>
                                        </div>
                                    @endif
                                </span>
                                @if ($child_document->borrower_child_document)
                                    <i class="bi bi-check-square-fill text-success fs-5"></i>
                                @else
                                    <i class="bi bi-dash-square fs-5"></i>
                                @endif
                            </li>
                        @endforeach
                        @if($document->need_useful_activity)
                            <li class="list-group-item d-flex justify-content-between">
                                <span class=" {{ ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours) ? 'text-success' : 'text-dark' }}" >
                                    <h6>- กิจกรรมจิตอาสา {{$borrower_useful_activities_hours_sum }}/{{$useful_activities_hours}} ชั่วโมง </h6>
                                </span>
                                @if ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours)
                                    <i class="bi bi-check-square-fill text-success fs-5"></i>
                                @else
                                    <i class="bi bi-dash-square fs-5"></i>
                                @endif
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ข้าพเจ้าได้แนบเอกสารต่างๆ ตามที่กองทุนกำหนดเพื่อประกอบการพิจารณาครบถ้วนทุกรายการ อย่างละ 1 ฉบับ ได้แก่</h5>
            <div class="row mx-2">
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="copy_student_id_card" id="copy_student_id_card" value="1">
                    <label class="form-check-label mx-2" for="copy_student_id_card">
                        1. สำเนาบัตรประชาชนของนักศึกษา รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="student_consent" id="student_consent" value="2">
                    <label class="form-check-label mx-2" for="student_consent">
                        2. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของนักศึกษา
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="copy_parent_id_card" id="copy_parent_id_card" value="3">
                    <label class="form-check-label mx-2" for="copy_parent_id_card">
                        3. สำเนาบัตรประชาชนของบิดา มารดา ผู้แทนโดยชอบธรรม รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="parent_consent" id="parent_consent" value="4">
                    <label class="form-check-label mx-2" for="parent_consent">
                        4. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของบิดา มารดา ผู้แทนโดยชอบธรรม
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    {{-- <input class="form-check-input" type="checkbox" name="family_income" id="family_income" value="5"> --}}
                    <label class="form-check-label mx-2 mb-3" for="family_income">
                        5. หนังสือรับรองรายได้ครอบครัว
                    </label>
                    <div class="col-12 form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="regular_income" id="regular_income" value="5.1">
                        <label class="form-check-label mx-2 col-md-10 col-12" for="regular_income">
                            5.1 มีรายได้ประจำ แนบหนังสือรับรองเงินเดือน/สลิปเงินเดือน
                        </label>
                    </div>
                    <div class="col-12 form-check">
                        <input class="form-check-input" type="checkbox" name="no_regular_income" id="no_regular_income" value="5.2">
                        <label class="form-check-label mx-2 col-md-10 col-12" for="no_regular_income">
                            5.2 ไม่มีรายได้ประจำ (แบบกยศ.102 แนบสำเนาบัตรเจ้าหน้าที่ของรัฐ รับรองสำเนาถูกต้อง)
                        </label>
                    </div>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="teacher_opinion" id="teacher_opinion" value="6">
                    <label class="form-check-label mx-2" for="teacher_opinion">
                        6. หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="house_photo" id="house_photo" value="7">
                    <label class="form-check-label mx-2" for="house_photo">
                        7. รูปถ่ายบ้านที่อยู่อาศัยของผู้ปกครองและนักศึกษา
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="gpa" id="gpa" value="8">
                    <label class="form-check-label mx-2" for="gpa">
                        8. สำเนาใบรายงานผลการเรียน/สำเร็จการศึกษาในปีการศึกษาที่ผ่านมา
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="activities" id="activities" value="9">
                    <label class="form-check-label mx-2" for="activities">
                        9. บันทึกกิจกรรมจิตอาสา
                    </label>
                </div>
                <div class="col-12 form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="other" id="other" value="10">
                    <label class="form-check-label mx-2" for="other">
                        10. อื่นๆ (ถ้ามี) เช่น สำเนาบัตรสวัสดิการแห่งรัฐ/สำเนาใบเปลี่ยนชื่อ-สกุล/ใบมรณบัตร/ใบหย่า..............
                    </label>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary mt-3 w-25" onclick="nextPage('request-status-tab')">ถัดไป</button>
            </div>
        </div>
    </div>

</section>
@endsection
