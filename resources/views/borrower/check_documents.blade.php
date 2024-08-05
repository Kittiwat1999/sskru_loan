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
<script>
    function jsAccordion(accordionContainerClass, openFirstItem) {
        if(typeof accordionContainerClass != 'string' && typeof accordionItemClass != 'string' && typeof openFirstItem != 'boolean') {
        return;
        }

        var accordion = document.querySelector(accordionContainerClass);
        var accordionItem = accordion.querySelectorAll('.accordionItem');

        (function init() {
            for(var i = 0; accordionItem.length > i; i++) {

                var accordionContent = accordionItem[i].querySelector('.accordionContent');

                if(openFirstItem && i === 0) {
                    setDefaultHeight(accordionContent);
                    addClass(accordionItem[i], 'active');
                    showAccordion(accordionContent)
                } else {
                    setDefaultHeight(accordionContent);
                    hideAccordion(accordionContent);
                }
            }
        })();

        function setDefaultHeight(element) {
            var defaultHeight = element.children[0].offsetHeight;
            element.setAttribute('data-defaultheight', defaultHeight);

            element.previousElementSibling.addEventListener('click', function() {
                if(hasClass(element.parentNode, 'active')) {
                    hideAccordion(element);
                } else {
                    hideAllAccordions(accordionItem);
                    showAccordion(element);
                }
            });
        }

        function hideAllAccordions() {
            for(var i = 0; accordionItem.length > i; i++) {
                var accordionContent = accordionItem[i].querySelector('.accordionContent');
                hideAccordion(accordionContent);
            }
        }

        function hideAccordion(element) {
            element.style.height = '0px';
            element.children[0].style.visilibty = 'hidden';
            removeClass(element.parentNode, 'active');
        }

        function showAccordion(element) {
            var defaultHeight = element.getAttribute('data-defaultheight');
            element.style.height = defaultHeight + 'px';
            element.children[0].style.visilibty = 'visible';
            addClass(element.parentNode, 'active');
        }

        function hasClass(element, className) {
            if (element.classList) {
                return element.classList.contains(className);
            } else {
                return new RegExp('(^| )' + className + '( |$)', 'gi').test(element.className);
            }
        }

        function addClass(element, className){
            if(element.className.indexOf(className) == -1) {
                element.className += ' ' + className;
            }
        }

        function removeClass(element, name) {
        if (hasClass(element, name)) {
            element.className=element.className.replace(new RegExp('(\\s|^)'+name+'(\\s|$)'),' ').replace(/^\s+|\s+$/g, '');
        }
        }
    }
    jsAccordion('.accordionContainer', true);
</script>
@endsection
