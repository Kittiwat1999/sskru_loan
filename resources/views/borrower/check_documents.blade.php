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

            <!-- Default Accordion -->
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
                        <iframe src="{{asset("assets/pdf/บัตรประชาชนผู้กู้.pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
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
                </div>
                </div>
            </div>
            <!-- End Default Accordion Example -->
            <div class="text-end pt-3">
                <a href="{{url('/borrower/document_submission')}}" class="btn btn-primary">ถัดไป</a>
            </div>

        </div>
    </div>
</section>
@endsection
