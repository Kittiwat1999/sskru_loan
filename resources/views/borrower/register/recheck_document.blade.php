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
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="{{route('borrower.register.result')}}"></i>สรุปการส่งเอกสาร</a>
                    @else
                        <a class="nav-link text-dark text-center m-0" id="check-documents-tab" href="#"><i class="bi bi-lock"></i>สรุปการส่งเอกสาร</a>
                    @endif
                </li>
                <li class="nav-item col-md-3 m-0 px-0 py-2" role="presentation">
                    @if($step >= 4)
                        <a class="nav-link text-dark text-center m-0 active" id="check-documents-tab" href="{{route('borrower.register.recheck')}}"></i>ตรวจสอบเอกสารของระบบ</a>
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
    @if($document['need_teacher_comment'])
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">ตรวจสอบเอกสาร หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)</h5>
            <a class="open-link" onclick="openPDFInNewTab('pdf-103')" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
            <div class="row my-6 mx-1  border border-2 mb-2">
                <div class="col-md-12 iframe-container">
                    <iframe id="pdf-103" src="{{route('borrower.register.generate.teacher.comment',['document_id' => $document->id])}}" frameborder="0" class="w-100" height="800"></iframe>
                </div>
            </div>    
        </div>
    </div>
    @endif
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">ตรวจสอบเอกสาร กยศ. 101</h5>
            <a class="open-link" onclick="openPDFInNewTab('pdf-101')" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
            <div class="row my-6 mx-1  border border-2 mb-2">
                <div class="col-md-12 iframe-container">
                    <iframe id="pdf-101" src="{{route('borrower.register.generate.document',['document_id' => $document->id, 'child_document_id' => $child_document->id])}}" frameborder="0" class="w-100" height="800"></iframe>
                </div>
            </div>    
        </div>
    </div>

    <div class="card">
        <div class="card-body row mx-0">
            <div class="col-md-9 col-sm-12"></div>
            <div class="col-md-3 col-sm-12 text-end">
                <a href="{{route('borrower.register.sumit.document')}}" class="btn btn-primary mt-3 w-100">ส่งเอกสาร</a>
            </div>
        </div>
    </div>

</section>
@endsection

@section('script')
<script>
    function openPDFInNewTab(id) {
        var iframe = document.getElementById(id);
        var pdfURL = iframe.src;
        
        window.open(pdfURL, '_blank');
    }

</script>
@endsection