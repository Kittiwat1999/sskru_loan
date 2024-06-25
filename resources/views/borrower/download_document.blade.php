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
                        @foreach($documents as $document)
                        <tr>
                            <td>
                                {{$document->child_document_title}}
                            </td>
                            <td>
                                <a href="{{route('borrower.download.document',['document_id' => $document->id])}}" class="btn btn-danger" target="_blank">ดาวน์โหลด</a>
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
