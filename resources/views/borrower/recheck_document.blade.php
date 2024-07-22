@extends('layout')
preview document
@section('title')
@endsection
@section('content')
    <section class="main-content">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ตรวจสอบเอกสารก่อนดาวน์โหลด</h5>
                <a href="{{route('borrower.response.document',['document_id' => $document->id, 'request_type' => 'preview'])}}" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
                <div class="row my-6 mx-1  border border-2 mb-2">
                    <div class="col-md-12">
                        <iframe  src="{{route('borrower.response.document',['document_id' => $document->id, 'request_type' => 'preview'])}}" frameborder="0" class="w-100" height="800"></iframe>
                    </div>
                </div>    
                <div class="text-end"><a href="{{route('borrower.response.document',['document_id' => $document->id, 'request_type' => 'download'])}}" class="btn btn-danger w-100 ">ดาวน์โหลดเอกสาร</a></div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script></script>
@endsection