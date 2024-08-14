@extends('layout')
@section('title')
ยื่นกู้
@endsection
@section('style')
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

    </style>
@endsection
@section('content')
<section >
    <div class="card mb-3">
        <div class="card-body pb-0 mb-0">
            <ul class="nav row mx-0 my-2" id="myTab" role="tablist">
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 1)
                        <a class="nav-link text-dark text-center m-0" id="borrower-type-tab" href="{{route('borrower.register.type')}}" role="tab" aria-controls="borrower-type" aria-selected="true">ประเภทผู้กู้ยืม</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 2)
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="{{route('borrower.register.upload_document')}}"></i>ส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="send-documents-tab" href="#"><i class="bi bi-lock"></i>ส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 3)
                        <a class="nav-link text-dark text-center m-0 active" id="check-documents-tab" href="{{route('borrower.register.result')}}"></i>สรุปการส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>สรุปการส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if($step >= 4)
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.recheck')}}"></i>ตรวจสอบเอกสารของระบบ</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>ตรวจสอบเอกสารของระบบ</a>
                    @endif
                </li>
                <li class="nav-item col-md-2 m-0 px-0 py-2" role="presentation">
                    @if($step >= 5)
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="{{route('borrower.register.status')}}"></i>สถานะคำร้อง</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="request-status-tab" href="#"><i class="bi bi-lock"></i>สถานะคำร้อง</a>
                    @endif
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
                                    <h6>
                                        - {{$child_document->child_document_title}}
                                        @if(!$child_document['isrequired'])
                                            <small class="text-warning">กรณีไม่มีให้ข้ามการอัพโหลดนี้</small>
                                        @endif
                                    </h6>
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
            <div id="invalid-checkbox" class="invalid-feedback">
                กรุณาระบุเอกสารที่ส่ง
            </div>
            <form id="register-document-form" class="row mx-2" action="{{route('borrower.register.result.store')}}" method="POST">
                @csrf
                @foreach($register_documents as $index => $register_document)
                    @if($index == 4)
                        <label class="col-12 form-label m-0 p-0 mb-3" for="">
                            5. หนังสือรับรองรายได้ครอบครัว
                        </label>
                    @endif

                    @if($index == 4 || $index == 5)
                        <div class="col-12 form-check mb-3">
                            <div class="col-12 form-check">
                                <input class="form-check-input" type="checkbox" name="register_document[]" id="register_document-{{$register_document}}" value="{{$register_document['id']}}" @checked($register_document['checked'])>
                                <label class="form-check-label mx-2 col-md-10 col-12" for="register_document-{{$register_document}}">
                                    {{$register_document['title']}}
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="col-12 form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="register_document[]" id="register_document-{{$register_document}}" value="{{$register_document['id']}}" @checked($register_document['id'] == 7) @checked($register_document['checked'])>
                            <label class="form-check-label mx-2" for="register_document-{{$register_document}}">
                                {{$register_document['title']}}
                            </label>
                        </div>
                    @endif
                @endforeach
            </form>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary mt-3 w-25" onclick="submitForm('register-document-form')">ถัดไป</button>
            </div>
        </div>
    </div>

</section>
@endsection
@section('script')
    <script>
        async function submitForm(form_id){
            var validation = await validateForm(form_id) 

            if(validation){
                const form = document.getElementById(form_id);
                form.submit();
            }else{
                alert('ยังไม่ระบุเอกสารที่ส่ง');
                var invalid_element = document.getElementById('invalid-checkbox');
                if(invalid_element)invalid_element.classList.add('d-inline');
                window.scrollTo(0,0);
            }
        }

        async function validateForm(form_id){
            const form = document.getElementById(form_id);
            const checkbox =  form.querySelectorAll('input[name="register_document[]"]');
            validator = await validateCheckBox(checkbox);
            return validator;
        }

        async function validateCheckBox(checkbox){
            var checker = false;
            for(let i = 0; i < checkbox.length; i ++){
                if(checkbox[i].checked == true){
                    checker = true;
                    break;
                }
            }

            return (checker) ? true : false;
        }
    </script>
@endsection