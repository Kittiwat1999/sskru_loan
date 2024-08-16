@extends('layout')
@section('title')
ดูเอกสาร
@endsection
@section('style')
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
        iframe {
        width: 100%;
        border: none;
        }
        @media (max-width: 600px) {
        iframe {
            height: 400px;
        }
        }
        @media (min-width: 601px) and (max-width: 1200px) {
        iframe {
            height: 500px;
        }
        }
        @media (min-width: 1201px) {
        iframe {
            height: 1000px;
        }
        }
    </style>
@endsection

@section('content')
<section class="section Editing">
    <?php
        date_default_timezone_set("Asia/Bangkok");
        $loan_requests = array(
            array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'กู้มาผ่อน Iphone 15 promax','age'=>'24','comment'=>array('ครอบครัวขาดแคลน iphone 15','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
            array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'สาขาที่เป็นความต้องการหลัก','age'=>'23','comment'=>array('เป็นสาขาที่เป็นความต้องการหลัก','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
            array('id'=>'6410014101','name'=>'กฤษฎา เจริญวิเชียรฉาย','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'สารขาที่ขาดแคลน','age'=>'21','comment'=>array('เป็นสารขาที่ขาดแคลน','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
            array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'กู้มาผ่อนบ้าน','age'=>'21','comment'=>array('นักศึกษาขาดแคลนที่อยู่อาศัย','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
        );
        $i = 0;
    ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ตรวจเอกสาร</h5>

            <div class="card-body">
                <div class="accordion" id="accordionExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="col-md-3 col-7">สำเนาบัตรประชาชน</span>
                                    <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <iframe src="{{asset("assets/pdf/บัตรประชาชนผู้กู้.pdf")}}"></iframe>
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
                                    <iframe src="{{asset("assets/pdf/รายงานผลการเรียนผู้กู้.pdf")}}"></iframe>
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
                                    <iframe src="{{asset("assets/pdf/แบบยืนยัน(อย่างเดียว).pdf")}}"></iframe>
                                </div>
                            </div>

                        </div>

                </div>
            </div>

            <div class="card-body border mt-2 mx-4">
                <h5 class="card-title">รายละอียดผู้กู้</h5>

                    <div class="row">
                        <div class="col-md-3 text-secondary fw-bold">ชื่อ-นามสกุล</div>
                        <div class="col-md-4">{{$loan_requests['0']['name']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">ลักษณะผู้กู้</div>
                        <div class="col-md-4">{{$loan_requests['0']['type']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">อายุ</div>
                        <div class="col-md-4">{{$loan_requests['0']['age']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">รหัสนักศึกษา</div>
                        <div class="col-md-4">{{$loan_requests['0']['id']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">คณะ</div>
                        <div class="col-md-4">{{$loan_requests['0']['faculty']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">สาขา</div>
                        <div class="col-md-4">{{$loan_requests['0']['major']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">ชั้นปี</div>
                        <div class="col-md-4">{{$loan_requests['0']['grade']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">โทรศัพท์</div>
                        <div class="col-md-4">{{$loan_requests['0']['tel']}}</div>
                        <div class="col-md-5"></div>

                        <div class="col-md-3 text-secondary fw-bold">ผลการเรียนเฉลี่ย</div>
                        <div class="col-md-4">{{$loan_requests['0']['gpa']}}</div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="border-top mt-4"></div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="#" class="form-label">ให้ความเห็น</label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                ครอบครัวของนักศึกษาขาดแคลนคุณทรัพย์
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck2">
                                <label class="form-check-label" for="gridCheck2">
                                เป็นสาขาที่เป็นความต้องการหลักของประเทศ
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                เป็นสารขาที่ขาดแคลนของประเทศ
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck2">
                                <label class="form-check-label" for="gridCheck2">
                                เพื่อส่งต่อโอกาศทางการศึกษาให้นักศึกษาได้สำเร็จการศึกษา
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                เห็นควรพิจารณาอนุมัติให้กู้ยืม
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck2" onchange="enableInputText()">
                                <label class="form-check-label" for="gridCheck2">
                                อื่นๆ
                                </label>
                            </div>
                        </div>
                        <div class="col-md-5 col-11 mx-4">
                            <input type="text" name="morecommnet" id="morecommnet" class="form-control" disabled>
                        </div>
                    </div>
            </div>
            <div class="text-end mt-4">
                <a href="{{url('teacher_index')}}" class="btn btn-secondary">ปิด</a>
                <a href="{{url('teacher_index')}}" class="btn btn-primary">บันทึก</a>
            </div>
        </div>
    </div>
    <script>

        function enableCheckbox(roleName){
            const isDisabled = $(`:checkbox[id^=${roleName}]`).prop('disabled');
            $(`:checkbox[id^=${roleName}]`).prop('disabled', !isDisabled);
            if($(`#${roleName}confirm_radio`).prop('checked')){
                console.log('reset form');
                $(`:checkbox[id^=${roleName}]`).prop('checked', false);
                $(`#${roleName}moreText`).prop({'value':'','disabled':true});
            }
        }

        function enableInputArea(roleName){
        const isDisabled = $(`#${roleName}moreText`).prop('disabled');
        $(`#${roleName}moreText`).prop({'value':'','disabled': !isDisabled});
        }

        function enableInputText(){
            const inputText = document.getElementById('morecommnet');
            inputText.disabled = !inputText.disabled;
        }

    </script>
</section>
@endsection
