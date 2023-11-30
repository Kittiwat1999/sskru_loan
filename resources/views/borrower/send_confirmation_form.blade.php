@extends('layout')
@section('titile')
borrower confirmation form
@endsection
@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body pt-3">
                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-black" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">ส่งแบบยืนยัน</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <br>

                                        <form class="container">
                                            <p>
                                                <label class="text-secondary">จำนวนเงินค่าครองชีพที่เบิก</label>
                                            <div class="col-4">
                                                <input class="form-control" type="text" value="3,000">
                                            </div>
                                            </p>
                                            <p>
                                                <label class="text-secondary">จำนวนเงินค่าเทอมที่เบิก</label>
                                            <div class="col-4">
                                                <input class="form-control" type="text" value="45,000">
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

                                            </ul><!-- End Default List group -->
                                            <br><br>
                                        </div>
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
                                                    แบบยืนยันการเบิกเงินกู้ยืม &nbsp; <img src="assets/img/pngwing.com.png" alt="" height="20px">
                                                    <br><br>
                                                    บันทึกจำนวนเงินที่เบิก &nbsp; <img src="assets/img/pngwing.com.png" alt="" height="20px">
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