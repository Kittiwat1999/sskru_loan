@extends('layout')
@section('title')
preview document
@endsection
@section('content')
    <section class="main-content">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ตรวจสอบเอกสารก่อนดาวน์โหลด</h5>
                <a onclick="openPDFInNewTab()" class="open-link" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
                <div class="row my-6 mx-1  border border-2 mb-2">
                    <div class="col-md-12 iframe-container">
                        <iframe id="pdfIframe"  src="{{route('borrower.response.parent.document', ['parent_id' => $parent_id])}}" frameborder="0" class="w-100" height="800"></iframe>
                    </div>
                </div>    
                <div class="text-end">
                    <button onclick="downloadPDF()" class="btn btn-danger w-100">ดาวน์โหลดเอกสาร</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
    function downloadPDF() {
        var iframe = document.getElementById('pdfIframe');
        var pdfURL = iframe.src;
        var downloadLink = document.createElement('a');
        
        downloadLink.href = pdfURL;
        downloadLink.download = 'downloaded_file.pdf';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    function openPDFInNewTab() {
        var iframe = document.getElementById('pdfIframe');
        var pdfURL = iframe.src;
        
        window.open(pdfURL, '_blank');
    }
</script>
@endsection