@extends('layout')
@section('title')
@endsection
@section('content')
        <!-- start card toggle -->
        <div class="card">
            <div class="card-body">
            {{-- <h5 class="card-title">กรอกข้อมูล</h5> --}}
                <div class="col-md-12 my-4">
                    <h5 class="text-primary">ข้อมูลผู้กู้</h5>
                    <div class="col-md-11 line-section mt-2"></div>
                </div>

                @if(isset($borrower_information))
                    @include('borrower/information/borrower_have_data')
                @else
                    @include('borrower/information/input_information')
                @endif

            </div>
            <!-- end card body -->

        </div>
        <!-- end card toggle -->
      
@endsection
