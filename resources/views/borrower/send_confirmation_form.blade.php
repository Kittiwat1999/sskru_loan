@extends('layout')
@section('titile')
borrower confirmation form
@endsection
@section('content')
<section class="section Editing">
    
    <div class="card pt-3">
        <div class="card-body">
            <div class="row">
            <div class="container-fluid align-items-center p-0 m-0">
                <div class="d-flex justify-content-around p-0 m-0">
                    <div class="d-flex flex-column">
                            <div class="text-center mb-1">
                                <button class="btn bg-primary text-white btn-sm rounded-pill" style="width: 2rem; height: 2rem" data-bs-toggle="collapse" data-bs-target="#company3" aria-expanded="false" aria-controls="company3" onclick="stepFunction(event)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </div>
                            <small class="text-primary text-center text-progress-step fw-bold">แบบยืนยันการเบิกเงินกู้ยืม</small>
                        </div>
                        <span class="bg-secondary w-25 rounded mt-3 me-1 ms-1" style="height: 0.17rem">
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button class="btn bg-secondary text-white btn-sm rounded-pill" style="width: 2rem; height: 2rem" data-bs-toggle="collapse" data-bs-target="#company3" aria-expanded="false" aria-controls="company3" onclick="stepFunction(event)">
                                  <i class="bi bi-file-earmark-arrow-down"></i>
                                </button>
                            </div>
                            <small class="text-secondary text-center text-progress-step fw-bold">ส่งเอกสาร</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body pt-3">
            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="id-card-tab" data-bs-toggle="tab" data-bs-target="#id-card" type="button" role="tab" aria-controls="id-card" aria-selected="true">แบบยืนยันการเบิกเงินกู้ยืม</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sumary-tab" data-bs-toggle="tab" data-bs-target="#sumary" type="button" role="tab" aria-controls="sumary" aria-selected="false">ส่งเอกสาร</button>
                </li>

            </ul>

            <div class="tab-content pt-2" id="myTabContent">

                <div class="tab-pane fade show active" id="id-card" role="tabpanel" aria-labelledby="id-card-tab">
                    <!-- ฟอร์มส่งเอกสาร -->
                    <form class="row">
                        <div class="col-sm-12 my-3"></div>
                        <div class="col-md-2">
                            <label for="cost-of-living" class="form-label text-secondary">จำนวนเงินค่าเทอมที่เบิก</label>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="45,000">
                        </div>
                        <div><br></div>
                        <div class="col-md-2">
                            <label for="tuition-money" class="form-label text-secondary">จำนวนเงินค่าครองชีพที่เบิก</label>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="3,000">
                        </div>
                        <div><br></div>
                        <div class="col-md-2">
                            <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group list-borderless">
                                <li class="list-group-item">
                                    <i class="bi bi-dash"></i>
                                    แบบยืนยันการเบิกเงินกู้ยืมกองทุนเงินให้กู้ยืมเพื่อการศึกษา
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 pt-2">
                            <label for="exampdoc" class="form-label text-secondary">ตัวอย่างเอกสาร</label>
                        </div>
                        <div class="col-md-10 my-2 text-warning"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <!-- Slides with controls -->
                            <div id="borrower-document_1" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/doc/ยืนยันการเบิกเงินกู้ยืม.png')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                            </div><!-- End Slides with controls -->
                        </div>
                        
                        <div class="col-md-12 m-2"></div>
                        <div class="col-md-2 pt-2">
                            <label for="examplefile" class="form-label text-secondary fw-bold">อัพโหลดไฟล์</label>
                        </div>
                        <div class="col-md-10">
                            <input type="file" placeholder="helo" name="examplefile" id="examplefile">
                        </div>
                        <div class="text-end my-3">
                        <!-- reset Modal-->
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                ล้างข้อมูล
                            </button>
                            <div class="modal fade" id="basicModal" tabindex="-1">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">ล้างข้อมูล</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center">
                                            ท่านต้องการล้างขอมูลบนฟอร์มหรือไม่
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ล้างข้อมูล</button>
                                    </div>
                                </div>
                                </div>
                            </div><!-- End reset Modal-->
                            <button type="button" class="btn btn-primary" onclick="nextPgae('sumary-tab')">ถัดไป</button>
                        </div>
                    </form>
                    <!-- end ฟอร์มส่งเอกสาร -->
                </div>

                <div class="tab-pane fade" id="sumary" role="tabpanel" aria-labelledby="sumary-tab">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-dark fw-bold">รายการเอกสาร</p>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>แบบยืนยันการเบิกเงินกู้ยืม</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                       
                        <div class="text-end my-1">
                            <button type="button" class="btn btn-primary">ส่งเอกสาร</button>
                        </div>
                    </div>
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