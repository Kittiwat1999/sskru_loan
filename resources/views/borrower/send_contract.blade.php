@extends('layout')
@section('titile')
borrower contract
@endsection
@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body pt-3">
            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="contr-tab" data-bs-toggle="tab" data-bs-target="#contr" type="button" role="tab" aria-controls="contr" aria-selected="true">สัญญา</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="confiem-money-tab" data-bs-toggle="tab" data-bs-target="#confiem-money" type="button" role="tab" aria-controls="confiem-money" aria-selected="false">แบบยืนยัน</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="contr" role="tabpanel" aria-labelledby="contr-tab">
                    <br>

                    <!-- Extra Large Modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExtralargeModal">
                        ตัวอย่างเอกสาร
                    </button>

                    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ตัวอย่างเอกสาร</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div align="center">
                                        <img src="assets/img/สัญญาและแบบยืนยัน.png" alt="" width="700px">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Extra Large Modal-->
                    <br><br><br>

                    <div>
                        <!-- List group with active and disabled items -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h6>1.สัญญากู้ยืมเงิน</h6>
                                <h6>2.สำเนาบัตรผู้กู้</h6>
                                <h6>3.สำเนาบัตรผู้แทน(ถ้าอายุไม่ถึงจะแสดง)</h6>
                            </li>
                        </ul><!-- End Clean list group -->
                    </div>
                    <br><br><br>

                    <div align="center">
                        <br><br><br>

                        <!-- Default List group -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">

                                <div class="d-grid w-75">
                                    <button class="btn btn-primary" type="button">ดาวน์โหลดเอกสาร</button>
                                </div>
                                <br><br>

                                <div class="row-cols-auto">
                                    <div class="col-md-6">
                                        <label for="file" class="text-black">สัญญาพร้อมสำเนาบัตร</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div>
                                            <input name="file" type="file" class="form-control" id="file">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul><!-- End Default List group -->
                        <br><br>
                    </div>
                    <div align="right">
                        <button type="button" class="btn btn-primary" onclick="nextPgae('confiem-money-tab')">
                            ถัดไป
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade" id="confiem-money" role="tabpanel" aria-labelledby="confiem-money-tab">
                    <br>

                    <form class="container">
                        <p>
                            <label class="text-secondary">ค่าเล่าเรียน</label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="45,000">
                        </div>
                        </p>
                        <p>
                            <label class="text-secondary">ค่าครองชีพที่กู้ยืม</label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="18,000">
                        </div>
                        </p>
                    </form>
                    <br>

                    <h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตัวอย่างเอกสาร</h6>

                    <div align="center">
                        <img src="assets/img/Group 2661.png" alt="">
                    </div>
                    <br><br><br>
                    <div align="center">

                        <!-- Default List group -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">


                                <div class="row-cols-auto">
                                    <div class="col-md-6">
                                        <label for="file" class="text-black">เอกสารแบบยืนยัน</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div>
                                            <input name="file" type="file" class="form-control" id="file">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul><!-- End Default List group -->
                        <br><br>
                    </div>
                            <!-- Large Modal -->
                            <div align="right">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
                                    ถัดไป
                                </button>
                            </div>

                        <div class="modal fade" id="largeModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">ยืนยันการส่งเอกสาร</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                            <div class="container bg-light">
                                                <div align="center">
                                                    <br><br>
                                                    สัญญาพร้อมสำเนาบัตร &nbsp; <img src="assets/img/pngwing.com.png" alt="" height="20px">
                                                    <br><br>
                                                    แบบยืนยันการเบิกเงินกู้ยืม &nbsp; <img src="assets/img/pngwing.com.png" alt="" height="20px">
                                                    <br><br><br><br>
                                                </div>
                                            </div>
                                            <br>
                        
                        
                        
                                        </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- End Large Modal-->
                </div>
              </div><!-- End Default Tabs -->
        </div>
    </div>
</section>
<script>
    function nextPgae(page){
        console.log(page);
        document.getElementById(page).click();
        window.scrollTo(0, 0);
      }
</script>
@endsection