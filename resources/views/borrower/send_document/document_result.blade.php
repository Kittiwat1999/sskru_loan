@extends('layout')
@section('title')
สรุปการส่งเอกสาร
@endsection
@section('content')
<section class="">
    <div class="card">
        <div class="card-body">
            <h5 class="py-2 fs-5">สรุปการส่งเอกสาร {{$document->document_title}}</h5>
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <ul class="list-group list-borderless">
                            @foreach($child_documents as $child_document)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class=" {{ ($child_document->borrower_child_document) ? 'text-success' : 'text-dark' }}" >
                                        <h6>- {{$child_document->child_document_title}} </h6>
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
                    <div class="col-sm-6 col-md-3 mb-3">
                        <a href="{{route('borrower.upload.document.page',['document_id' => $document->id])}}" class="btn btn-outline-dark w-100"><i class="bi bi-arrow-left"></i> ย้อนกลับ </a>
                    </div>
                    <div class="col-md-6 col-sm-0"></div>
                    <div class="col-sm-6 col-md-3 text-end">
                        @if(((int) $borrower_child_document_delivered_count >= (int) $child_document_required_count) && ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours))
                            <a href="{{route('borrower.upload.document.submit',['document_id' => $document->id])}}" class="btn btn-primary w-100" > ส่งเอกสาร <i class="bi bi-arrow-up"></i></a>
                        @elseif(!$document->need_useful_activity)
                            <a href="{{route('borrower.upload.document.submit',['document_id' => $document->id])}}" class="btn btn-primary w-100" > ส่งเอกสาร <i class="bi bi-arrow-up"></i></butaton>
                        @else
                            <button type="button" class="btn btn-secondary w-100" disabled> ส่งเอกสาร <i class="bi bi-arrow-up"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
