@extends('layout')
@section('title')
ดูเอกสาร
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$file->description}}</h5>
                {{$file->file_type}}
                @if($file->file_type == 'pdf')
                    <div class="row my-2 isdisplay">
                        <div class="col-md-12">
                            <iframe src="{{route('displayfile',['full_path' => $file->full_path])}}" frameborder="0" class="w-100" height="1200"></iframe>
                        </div>
                    </div>
                @else
                    <div class="row my-2 isdisplay">
                        <div class="col-md-12">
                            <img src="{{route('displayfile',['full_path' => $file->full_path])}}" alt="" class="w-100">
                        </div>
                    </div>    
                @endif
            </div>
        </div>
    </section>
@endsection