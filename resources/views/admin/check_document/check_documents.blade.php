@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
<style>
    .accordionContainer .accordionItem {
    margin-bottom: 10px;
    }
    .accordionContainer .accordionHeader {
    border-radius: 2px;
    background-color: #F4F7FE;
    padding: 5px;
    font-weight: 700;
    }
    .accordionContainer .accordionHeader:hover {
    cursor: pointer;
    }
    .accordionContainer .accordionContent {
    overflow: hidden;
    transition: 0.3s ease;
    transform: tanslateZ(0);
    height: 0px;
    }
    .accordionContainer .accordionContentInner {
    padding: 15px 0;
    background-color: #FFFFFF;
    padding: 5px 10px;
    }
</style>
@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ตรวจเอกสาร</h5>

            <div class="card">
                <div class="card-body">
                    <!-- Default Accordion -->
                    <div class="accordion mt-3" id="accordionExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="col-md-3 col-7">สำเนาบัตรประชาชน</span>
                                    <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <iframe src="{{asset("assets/pdf/บัตรประชาชนผู้กู้.pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
                                </div>

                                <fieldset class="row mb-3 mt-3 mx-2">
                                    <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                                    <div class="col-sm-10">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_confirm_radio" value="true" checked="" onchange="enableCheckbox('gpa_')">
                                            <label class="form-check-label" for="gpa_confirm_radio">
                                            เอกสารถูกต้อง
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_to_edit" value="false" onchange="enableCheckbox('gpa_')">
                                            <label class="form-check-label" for="gpa_to_edit">
                                            เอกสารไม่ถูกต้อง
                                            </label>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="row mb-3 mt-2 text-dark text-start mx-2">

                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_1" disabled="">
                                            <label class="form-check-label" for="gpa_comment_1" name="gpa_comment_1">
                                                เอกสารไม่ชัดเจน
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_2" disabled="">
                                            <label class="form-check-label" for="gpa_comment_2" name="gpa_comment_2">
                                                บัตรประชาชนหมดอายุ
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_more_radio" disabled="" onchange="enableInputArea('gpa_')">
                                            <label class="form-check-label" for="gpa_more_radio">
                                                อื่นๆ
                                            </label>
                                        </div>
                                        <div class="input-group">
                                            <label for="gpa_moreText"></label>
                                            <textarea class="form-control" name="gpa_moreText" id="gpa_moreText" cols="30" rows="4" disabled=""></textarea>
                                        </div>

                                    </div>

                                    <div class="col-sm-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_3" disabled="">
                                            <label class="form-check-label" for="gpa_comment_3" name="gpa_comment_3">
                                                ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_4" disabled="">
                                            <label class="form-check-label" for="gpa_comment_4" name="gpa_comment_4">
                                                สำเนาบัตรประชาชนไม่ถูกต้อง
                                            </label>
                                        </div>

                                    </div>
                                    
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary">ยืนยัน</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span class="col-md-3 col-7">รายงานผลการเรียน</span>
                                    <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <iframe src="{{asset("assets/pdf/รายงานผลการเรียนผู้กู้.pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
                                </div>

                                <fieldset class="row mb-3 mt-3 mx-2">
                                    <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                                    <div class="col-sm-10">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_confirm_radio" value="true" checked="" onchange="enableCheckbox('gpa_')">
                                            <label class="form-check-label" for="gpa_confirm_radio">
                                            เอกสารถูกต้อง
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_to_edit" value="false" onchange="enableCheckbox('gpa_')">
                                            <label class="form-check-label" for="gpa_to_edit">
                                            เอกสารไม่ถูกต้อง
                                            </label>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="row mb-3 mt-2 text-dark text-start mx-2">

                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_1" disabled="">
                                            <label class="form-check-label" for="gpa_comment_1" name="gpa_comment_1">
                                                เอกสารไม่ชัดเจน
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_2" disabled="">
                                            <label class="form-check-label" for="gpa_comment_2" name="gpa_comment_2">
                                                บัตรประชาชนหมดอายุ
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_more_radio" disabled="" onchange="enableInputArea('gpa_')">
                                            <label class="form-check-label" for="gpa_more_radio">
                                                อื่นๆ
                                            </label>
                                        </div>
                                        <div class="input-group">
                                            <label for="gpa_moreText"></label>
                                            <textarea class="form-control" name="gpa_moreText" id="gpa_moreText" cols="30" rows="4" disabled=""></textarea>
                                        </div>

                                    </div>

                                    <div class="col-sm-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_3" disabled="">
                                            <label class="form-check-label" for="gpa_comment_3" name="gpa_comment_3">
                                                ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_4" disabled="">
                                            <label class="form-check-label" for="gpa_comment_4" name="gpa_comment_4">
                                                สำเนาบัตรประชาชนไม่ถูกต้อง
                                            </label>
                                        </div>

                                    </div>
                                    
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary">ยืนยัน</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <span class="col-md-3 col-7">แบบยืนยันเบิกเงินกู้ยืม</span>
                                    <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <iframe src="{{asset("assets/pdf/แบบยืนยัน(อย่างเดียว).pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
                                </div>

                                <fieldset class="row mb-3 mt-3 mx-2">
                                    <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                                    <div class="col-sm-10">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_confirm_radio" value="true" checked="" onchange="enableCheckbox('gpa_')">
                                            <label class="form-check-label" for="gpa_confirm_radio">
                                            เอกสารถูกต้อง
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_to_edit" value="false" onchange="enableCheckbox('gpa_')">
                                            <label class="form-check-label" for="gpa_to_edit">
                                            เอกสารไม่ถูกต้อง
                                            </label>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="row mb-3 mt-2 text-dark text-start mx-2">

                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_1" disabled="">
                                            <label class="form-check-label" for="gpa_comment_1" name="gpa_comment_1">
                                                เอกสารไม่ชัดเจน
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_2" disabled="">
                                            <label class="form-check-label" for="gpa_comment_2" name="gpa_comment_2">
                                                บัตรประชาชนหมดอายุ
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_more_radio" disabled="" onchange="enableInputArea('gpa_')">
                                            <label class="form-check-label" for="gpa_more_radio">
                                                อื่นๆ
                                            </label>
                                        </div>
                                        <div class="input-group">
                                            <label for="gpa_moreText"></label>
                                            <textarea class="form-control" name="gpa_moreText" id="gpa_moreText" cols="30" rows="4" disabled=""></textarea>
                                        </div>

                                    </div>

                                    <div class="col-sm-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_3" disabled="">
                                            <label class="form-check-label" for="gpa_comment_3" name="gpa_comment_3">
                                                ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                                            </label>
                                        </div>
                            
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gpa_comment_4" disabled="">
                                            <label class="form-check-label" for="gpa_comment_4" name="gpa_comment_4">
                                                สำเนาบัตรประชาชนไม่ถูกต้อง
                                            </label>
                                        </div>

                                    </div>

                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary">ยืนยัน</button>
                                    </div>
                                </div>
                        </div>

                    </div>
                    <!-- End Default Accordion Example -->
                </div>
            </div>
        </div>
        <div class="text-end">
            <a href="{{url('/admin/check_document/document_submission')}}" class="btn btn-primary">ถัดไป</a>
        </div>
    </div>
</section>
@endsection
