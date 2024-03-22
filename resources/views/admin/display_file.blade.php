@extends('layout')
@section('title')
ดูเอกสาร
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$file->description}}</h5>
                @if($file->file_type == 'pdf')
                    <div class="row my-2 isdisplay my-6">
                        <div class="col-md-12">
                            <iframe src="{{route('admin.displayfile',['file_name' => $file->file_name])}}" frameborder="0" class="w-100" height="1200"></iframe>
                        </div>
                    </div>
                @else
                    <div class="row my-2 isdisplay my-6">
                        <div class="col-md-12">
                            <img src="{{route('admin.displayfile',['file_name' => $file->file_name])}}" alt="" class="w-100">
                        </div>
                    </div>    
                @endif
            </div>
        </div>
    </section>
@endsection