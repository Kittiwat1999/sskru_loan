@extends('layout')
@section('title')
ดูเอกสารตัวอย่าง
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$example_file->description}}</h5>
                @if($example_file->file_type == 'pdf')
                <a href="{{route('admin.display.file',['file_path' =>$example_file->file_path,'file_name' => $example_file->file_name])}}" target="_blank" rel="noopener noreferrer">คลิกที่นี่หากไฟล์ไม่แสดง...</a>
                    <div class="row my-2 my-6">

                        <div class="col-md-12">
                            <iframe  src="{{route('admin.display.file',['file_path' =>$example_file->file_path,'file_name' => $example_file->file_name])}}" frameborder="0" class="w-100" height="1200"></iframe>
                        </div>
                    </div>
                @else
                    <div class="row my-6 mx-1  border border-2">
                        <div class="col-md-12">
                            <img src="{{route('admin.display.file',['file_path' =>$example_file->file_path,'file_name' => $example_file->file_name])}}" alt="" class="w-100">
                        </div>
                    </div>    
                @endif
            </div>
        </div>
    </section>
@endsection