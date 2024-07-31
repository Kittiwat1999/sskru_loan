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
        <div class="card-body pt-3">
            <h5 class="py-2 fs-5">ตรวจเอกสาร</h5>
            <div class="accordionContainer">
                <div class="accordionItem">
                  <div class="accordionHeader">
                    <span class="row">
                        <div class="d-flex justify-content-start col-md-6">สำเนาบัตรประชาชน</div>
                        <div class="d-flex justify-content-end col-md-6 text-success">
                            ตรวจแล้ว &nbsp;
                            <img src="{{ asset('assets/img/doc/pngwing.com.png') }}" alt="" height="20px">
                        </div>
                    </span>
                  </div>
                  <div class="accordionContent">
                    <div class="accordionContentInner">
                        <iframe src="{{asset("assets/pdf/บัตรประชาชนผู้กู้.pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
                    </div>
                  </div>
                </div>

                <div class="accordionItem">
                  <div class="accordionHeader">
                    <span class="row">
                        <div class="d-flex justify-content-start col-md-6">รายงานผลการเรียน</div>
                        <div class="d-flex justify-content-end col-md-6 text-success">
                            ตรวจแล้ว &nbsp;
                            <img src="{{ asset('assets/img/doc/pngwing.com.png') }}" alt="" height="20px">
                        </div>
                    </span>
                  </div>
                  <div class="accordionContent">
                    <div class="accordionContentInner">
                        <iframe src="{{asset("assets/pdf/รายงานผลการเรียนผู้กู้.pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
                    </div>
                  </div>
                </div>

                <div class="accordionItem">
                  <div class="accordionHeader">
                    <span class="row">
                        <div class="d-flex justify-content-start col-md-6">แบบยืนยันเบิกเงินกู้ยืม</div>
                        <div class="d-flex justify-content-end col-md-6 text-success">
                            ตรวจแล้ว &nbsp;
                            <img src="{{ asset('assets/img/doc/pngwing.com.png') }}" alt="" height="20px">
                        </div>
                    </span>
                  </div>
                  <div class="accordionContent">
                    <div class="accordionContentInner">
                        <iframe src="{{asset("assets/pdf/แบบยืนยัน(อย่างเดียว).pdf")}}" frameborder="0" class="w-100" height="600"></iframe>
                    </div>
                  </div>
                </div>
              </div>
            <div class="text-end">
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
