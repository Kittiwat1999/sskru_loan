@extends('layout')
@section('title')
รายการกรอกข้อมูล
@endsection
@section('content')
<section class="main-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายการผู้กู้กรอกข้อมูล</h5>
            <div class="row">
                <div class="col-sm-12">
                    <ol class="list-group list-group">
                        <li class="list-group-item list-group-item d-flex justify-content-between">
                            <span>
                                <span>ข้อมูลผู้กู้</span>
                                @if($borrower_id != null)
                                <span class="text-success">: มีข้อมูล</span>
                                @endif
                            </span>
                            @if($borrower_id != null)
                            
                                <a href="{{route('borrower.edit.information.page')}}" class="btn btn-outline-primary">แก้ไขข้อมูล</a>
                            @else
                            <span>
                                <a href="{{route('borrower.input.information')}}" class="btn btn-primary">ไปหน้ากรอกข้อมูล</a>
                            </span>
                            @endif
                        </li>
                        <li class="list-group-item list-group-item-secondary d-flex justify-content-between">
                            <span>ข้อมูลผู้ปกครอง</span>
                            <button type="button" class="btn btn-secondary" disabled>ไปหน้ากรอกข้อมูล</button>
                        </li>
                        <li class="list-group-item list-group-item-secondary d-flex justify-content-between">
                            <span>ข้อมูลผู้แทนโดยชอบธรรม</span>
                            <button type="button" class="btn btn-secondary" disabled>ไปหน้ากรอกข้อมูล</button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script></script>
@endsection