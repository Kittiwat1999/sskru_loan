@extends('layout')
@section('title')
ดาวน์โหลดเอกสาร
@endsection
@section('content')
<section class="content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ดาวน์โหลดเอกสาร</h5>
            <div class="table-responsive">
                <table class="table datatable table-striped table-borderless">
                    <thead>
                        <tr>
                            <th>เอกสาร</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parents as $parent)
                        <tr>
                            <td>
                                หนังสือยินยอมให้เปิดเผยข้อมูลผู้ปกครอง {{$parent->prefix}}{{$parent->firstname}} {{$parent->lastname}}
                            </td>
                            <td>
                                <a href="{{route('borrower.recheck.parent.document',['parent_id' => $parent->id])}}" class="btn btn-primary">ตรวจสอบเอกสาร</a>
                            </td>
                        </tr>
                        @endforeach
                        @foreach($child_documents as $child_document)
                        <tr>
                            <td>
                                {{$child_document->child_document_title}}
                            </td>
                            <td>
                                <a href="{{route('borrower.recheck.document',['child_document_id' => $child_document->id])}}" class="btn btn-primary">ตรวจสอบเอกสาร</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    console.log('download page');
</script>
@endsection
