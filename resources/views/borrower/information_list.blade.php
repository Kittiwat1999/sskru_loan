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
                                <a href="{{route('borrower.input.information')}}" class="btn btn-primary">กรอกข้อมูล</a>
                            </span>
                            @endif
                        </li>
                        <li class="list-group-item list-group-item-{{$borrower_id != null ? '' : 'secondary' }} secondary d-flex justify-content-between">
                            <span>
                                <span>ข้อมูลผู้ปกครอง</span>
                                    @if($parent_count > 0)
                                    <span class="text-success">: มีข้อมูล</span>
                                    @endif
                                </span>
                            </span>
                            @if($borrower_id != null)
                                <span>
                                @if($parent_count == 0)
                                    <a href="{{route('borrower.input.parent.information')}}" class="btn btn-primary">กรอกข้อมูล</a>
                                @else
                                    <a href="{{route('borrower.edit.parent.information.page')}}" class="btn btn-outline-primary">แก้ไขข้อมูล</a>
                                @endif
                                </span>
                            @else
                            <span>
                                <button  class="btn btn-secondary" disabled >กรอกข้อมูล</button>
                            </span>
                            @endif
                        </li>
                        <li class="list-group-item list-group-item-{{($borrower_id != null && $parent_count != 0) ? '' : 'secondary' }} d-flex justify-content-between">
                            <span>
                                <span>ข้อมูลผู้แทนโดยชอบธรรม</span>
                                    @if(isset($main_parent_id))
                                    <span class="text-success">: มีข้อมูล</span>
                                    @endif
                                </span>
                            </span>
                            @if($borrower_id != null && $parent_count != 0)
                                @if(isset($main_parent_id))
                                    <a href="{{route('borrower.edit.main_parent.information.page')}}" type="button" class="btn btn-outline-primary">แก้ไขข้อมูล</a>
                                @else
                                    <a href="{{route('borrower.input.main_parent.information')}}" type="button" class="btn btn-primary">กรอกข้อมูล</a>
                                @endif
                            @else
                                <button type="button" class="btn btn-secondary" disabled>กรอกข้อมูล</button>
                            @endif
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