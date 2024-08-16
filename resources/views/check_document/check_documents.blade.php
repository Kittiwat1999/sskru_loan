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
            <h5 class="card-title">ตรวจเอกสาร</h5>
            <div class="accordion mb-3" id="accordion">
                @foreach($child_documents as $child_document)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="child-document-{{$child_document->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-child-document-{{$child_document->id}}" aria-expanded="true" aria-controls="collapse-child-document-{{$child_document->id}}">
                                <span class="col-md-3 col-7">{{$child_document->child_document_title}}</span>
                                {{-- <span class="badge rounded-pill bg-success mx-3">ตรวจแล้ว</span> --}}
                            </button>
                        </h2>
                        <div id="collapse-child-document-{{$child_document->id}}" class="accordion-collapse collapse" aria-labelledby="child-document-{{$child_document->id}}" data-bs-parent="#accordion" style="">
                            <div class="accordion-body">
                                <iframe src="{{route('check.document.preview.file',['borrower_child_document_id' => $child_document->borrower_child_document->id])}}"></iframe>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-end">
                <a href="{{url('check_document/document_submission')}}" class="btn btn-primary col-4 col-md-3">ถัดไป</a>
            </div>
        </div>
    </div>
    <script>
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
