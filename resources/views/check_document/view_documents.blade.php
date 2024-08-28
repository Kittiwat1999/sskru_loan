@extends('layout')
@section('title')
ตรวจเอกสาร
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

        html {
            scroll-behavior: auto;
        }

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
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ดูเอกสาร</h5>
            <div class="accordion mb-3" id="accordion">
                @foreach($child_documents as $child_document)
                    @if($child_document->borrower_child_document != null)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="child-document-{{$child_document->id}}">
                            <button id="accordion-button-child-document-{{$child_document->id}}" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse-child-document-{{$child_document->id}}" 
                                aria-expanded="true" 
                                aria-controls="collapse-child-document-{{$child_document->id}}">
                                <span class="col-md-3 col-7">{{$child_document->child_document_title}}</span>
                                {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                            </button>
                        </h2>
                        <div id="collapse-child-document-{{$child_document->id}}" class="accordion-collapse collapse" aria-labelledby="child-document-{{$child_document->id}}" data-bs-parent="#accordion" style="">
                            <div class="accordion-body">
                                <iframe src="{{route('check.document.preview.file',['borrower_child_document_id' => $child_document->borrower_child_document->id])}}"></iframe>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12"></div>
                                    <div class="col-md-2 col-sm-12">
                                        <button type="button" class="btn btn-secondary w-100" onclick="closeAccordion({{$child_document->id}},'child-document')">ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                @if($document->need_teacher_comment)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="document-103">
                            <button id="accordion-button-document-103-1" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#document-103-collapse" 
                                aria-expanded="true" 
                                aria-controls="document-103-collapse">
                                <span class="col-md-3 col-7">หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)</span>
                                {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                            </button>
                        </h2>
                        <div id="document-103-collapse" class="accordion-collapse collapse" aria-labelledby="document-103" data-bs-parent="#accordion" style="">
                            <div class="accordion-body">
                                <iframe id="pdf-103" src="{{route('check.document.preview.teacher.comment',['document_id' => $document->id, 'borrower_uid' => $borrower->user_id])}}" frameborder="0" class="w-100" height="800"></iframe>
                                <div class="row">
                                    <div class="col-md-10 col-sm-12"></div>
                                    <div class="col-md-2 col-sm-12">
                                        <button type="button" class="btn btn-secondary w-100" onclick="closeAccordion('1','document-103')" >ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($document->need_useful_activity)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="useful-activity">
                        <button id="accordion-button-useful-activity-1" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#useful-activity-collapse" 
                            aria-expanded="true" 
                            aria-controls="useful-activity-collapse">
                            <span class="col-md-3 col-7">บันทึกกิจกรรมจิตอาสา</span>
                            {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                        </button>
                    </h2>
                    <div id="useful-activity-collapse" class="accordion-collapse collapse" aria-labelledby="useful-activity" data-bs-parent="#accordion" style="">
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col-2">ชื่อโครงการ</th>
                                        <th scope="col-2">สถานที่</th>
                                        <th scope="col-2">วัน/เดือน/ปี</th>
                                        <th scope="col-2">จำนวนชั่วโมง</th>
                                        <th scope="col-2">ลักษณะกิจกรรม</th>
                                        <th scope="col-2">ไฟล์หลักฐาน</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                        @foreach ($useful_activities as $useful_activity)
                                        <tr>
                                            <td>{{$useful_activity->activity_name}}</td>
                                            <td>{{$useful_activity->activity_location}}</td>
                                            <td>
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $useful_activity->start_date)->format('d-m-Y H:i')}} <br>
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $useful_activity->end_date)->format('d-m-Y H:i')}}
                                            </td>
                                            <td class="text-center">{{$useful_activity->hour_count}}</td>
                                            <td>{{$useful_activity->description}} </td>
                                            <td class="text-center">
                                                <a class="btn btn-danger" href="{{route('borrower.show.usefulactivity.file' ,['useful_activity_id' => $useful_activity->id , 'document_id' => $document->id])}}" rel="noopener noreferrer" target="_blank"><i class="bi bi-journal-bookmark" ></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
            
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                        </td>
                                        <td class="text-center">{{$borrower_useful_activities_hours_sum}}/{{$useful_activities_hours}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-md-10 col-sm-12"></div>
                                <div class="col-md-2 col-sm-12">
                                    <button type="button" class="btn btn-secondary w-100" onclick="closeAccordion('1','useful-activity')" >ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="text-start">
                <a href="{{route('check_document.select_document', ['document_id' => $document->id])}}" class="btn btn-secondary col-4 col-md-3">ย้อนกลับ</a>
            </div>
        </div>
    </div>


    <script>

        function closeAccordion(id, option){
            const accordion_button = document.getElementById('accordion-button-' + option + '-' + id);
            accordion_button.click();
        }
        // function enableCheckbox(roleName){
        //     const isDisabled = $(`:checkbox[id^=${roleName}]`).prop('disabled');
        //     $(`:checkbox[id^=${roleName}]`).prop('disabled', !isDisabled);
        //     if($(`#${roleName}confirm_radio`).prop('checked')){
        //         console.log('reset form');
        //         $(`:checkbox[id^=${roleName}]`).prop('checked', false);
        //         $(`#${roleName}moreText`).prop({'value':'','disabled':true});
        //     }
        // }
        // function enableInputArea(roleName){
        // const isDisabled = $(`#${roleName}moreText`).prop('disabled');
        // $(`#${roleName}moreText`).prop({'value':'','disabled': !isDisabled});
        // }
    </script>
</section>
@endsection
