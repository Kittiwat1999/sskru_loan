@extends('layouts.guest')

@section('title')
    หมดเวลาในการทำรายการ
@endsection

@section('content')
<main>
    <div class="modal fade show" id="verticalycentered" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body row">
                    <div class="col-12 text-center mb-3 mt-4">
                        <i class="bi bi-exclamation-circle-fill text-danger fs-1"></i>
                    </div>
                    <div class="col-12 text-center">
                        <h5>คุณไม่ได้ทำรายการในเวลาที่กำหนด</h5>
                    </div>
                    <div class="col-12 text-center mb-3">
                        <small>เพื่อความปลอดภัยในการทำรายการ</small><br>
                        <small>กรุณาเข้าสู่ระบบใหม่อีกครั้ง</small>
                    </div>
                </div>
                <div class="modal-footer row">
                    <div class="col-12 text-center">
                        <a href="{{url('/signout')}}" class="btn btn-primary">เข้าสู่ระบบใหม่</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->
@endsection