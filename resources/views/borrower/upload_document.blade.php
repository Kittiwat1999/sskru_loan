@extends('layout')
@section('title')
อัพโหลดเอกสาร
@endsection

@section('content')
<section>
    <div class="card">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-3 mt-2 text-center">
                    <span class="fw-bold text-dark">คำขอกู้ยืมรายเก่าเลื่อนชั้นปี</span>
                </div>
                <div class="col-md-2 mt-2">
                    <span class="text-secondary">ปีการศึกษา:</span> <span class="text-dark">year</span>
                </div>
                <div class="col-md-2 mt-2">
                    <span class="text-secondary">ภาคเรียนที่:</span> <span class="text-dark">term</span>
                </div>
                <div class="col-md-4 mt-2">
                    <span class="text-secondary">สถานะ: </span>
                    {{-- @if($loanRequestDocument->status == "nonsend")
                        <span class="text-warning">รอดำเนินการ....</span>
                    @elseif($loanRequestDocument->status == "send")
                        <span class="text-success"><i class="bi bi-check2-circle"></i> ส่งแล้ว </span> <span class="text-warning"> <i class="bi bi-exclamation-triangle-fill text-warning"></i> รอฝ่ายทุนอนุมัติ....</span>
                    @elseif($loanRequestDocument->status == "approve")
                        <span class="text-success"><i class="bi bi-check2-circle"></i> ฝ่ายทุนอนุมัติแล้ว</span>
                    @endif --}}
                </div>
                <div class="col-md-3 col-sm-12 mt-2">
                    <button type="button" class="btn btn-success w-100" id="sendDocBtn" data-bs-toggle="modal" data-bs-target="#sendDocModal" disabled>
                        ส่งเอกสาร <i class="bi bi-box-arrow-up"></i>
                      </button>
                </div>
                <div class="col-md-9 col-sm-12 mt-3" id="explanation">
                    
                </div>
                {{-- modal --}}
                <div>
                    <div class="modal fade" id="sendDocModal" tabindex="-1" aria-labelledby="sendDocModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sendDocModalLabel">ส่งเอกสารผู้กู้รายเก่า</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                เมื่อท่านส่งเอกสารแล้วฝ่ายทุนการศึกษาฯ จะตรวจสอบและอนุมัติคำขอของท่านต่อไป<br>
                                ยืนยันการส่งเอกสารหรือไม่??
                            </div>
                            <div class="modal-footer">
                                <form action="" method="post">
                                    @csrf 
                                    <input type="hidden" name="doc_id" value="">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                    <button type="submit" class="btn btn-success">ส่งเอกสาร <i class="bi bi-box-arrow-up"></i></button>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                {{--end modal --}}


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ส่งสำเนาบัตรประชาชน</h5>
            <div class="row">
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ไฟล์ประกอบไปด้วย</label>
                    <div class="col-sm-10">
                        <ul class="list-group list-borderless">
                            <li class="list-group-item">
                                <i class="bi bi-dash"></i>
                                สำเนาบัตรประชาชนผู้กู้พร้อมรับรองสำเนาถูกต้อง
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-dash"></i>
                                สำเนาบัตรประชาชนผู้ผู้แทนโดยชอบธรรมพร้อมรับรองสำเนาถูกต้อง
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="citizen_card_file">ตัวอย่างไฟล์</label>
                    <div class="col-md-5 col-sm-12">
                        <button type="button" class="btn btn-outline-primary w-100"><i class="bi bi-eye"></i> ดูตัวอย่างไฟล์</button>
                    </div>
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" class="row">
                @csrf
                <input type="hidden" name="year" value="" required>
                <input type="hidden" name="term" value="" required>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="citizen_card_file" >เพิ่มไฟล์</label>
                    <div class="col-sm-5">
                        <input class="form-control" type="file" name="citizen_card_file" id="citizen_card_file" accept=".jpg, .jpeg, .png, .pdf" required onchange="show_submit_button('citizen')">
                    </div>
                </div>
                <div class="row col-md-12 mt-4">
                    <div class="col-md-8">
                        @if(isset($citizencardfile))
                        <i class="bi bi-check2-circle text-success fw-bold"></i>
                        <span class=" text-success fw-bold">อัพโหลดไฟล์แล้ว </span> &emsp; 
                        <span>
                            <a href="" target="_blank" rel="ดูไฟล์">
                                คลิกเพื่อดูไฟล์...
                            </a>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <button type="submit" class="btn btn-primary w-100" id="citizen-submit-button" ><i class="bi bi-save"></i> บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script></script>
@endsection