@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection

@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ตรวจเอกสาร</h5>

                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        สำเนาบัตรประชาชน
                        <a class="badge bg-primary rounded-pill" href="{{url('check_document/documents')}}">ตรวจเอกสาร</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        รายงานผลการเรียน
                        <a class="badge bg-primary rounded-pill" href="{{url('check_document/documents')}}">ตรวจเอกสาร</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        แบบยืนยันเบิกเงินกู้ยืม
                        <a class="badge bg-primary rounded-pill" href="{{url('check_document/documents')}}">ตรวจเอกสาร</a>
                    </li>
                </ul>

            <div class="text-end mt-3">
                <a href="{{url('check_document/document_submission')}}" class="btn btn-primary col-4 col-md-2">ถัดไป</a>
            </div>
        </div>
    </div>
</section>
@endsection
