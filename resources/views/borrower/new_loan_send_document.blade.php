<div class="card">
    <dic class="card-body">
        <h5 class="card-title">ส่งเอกสาร</h5>
        <form class="row">
            <div class="col-md-11 line-section"></div>
            <h6 class="my-4 fw-bold">เอกสารคำยินยอมให้เปิดเผยข้อมูล</h6>
            <div class="col-md-2">
                <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
            </div>
            <div class="col-md-10">
                <ul class="list-group list-borderless">
                    <li class="list-group-item">
                        <i class="bi bi-dash"></i>
                        หนังสือยินยิมให้เปิดเผยข้อมูลผู้กู้
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-dash"></i>
                        สำเนาบัตรประชาชนผู้กู้พร้อมเซ็นสำเนาถูกต้อง
                    </li>
                </ul>
            </div>
            <div class="col-md-2 pt-2">
                <label for="exampdoc" class="form-label text-secondary">ตัวอย่างเอกสาร</label>
            </div>
            <div class="col-md-10">
                <!-- Slides with controls -->
                <div id="carouselExampleControls" class="carousel my-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" id="yinyorm">
                            <img src="{{asset('assets/img/slides-1.jpg')}}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" id="samnao">
                            <img src="{{asset('assets/img/slides-2.jpg')}}" class="d-block w-100" alt="...">
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div><!-- End Slides with controls -->
            </div>
            <div class="col-md-2 pt-2">
                <label for="downdoadbutton" class="form-label text-secondary">ดาวน์โหลดไฟล์</label>
            </div>
            <div class="col-md-10">
                <button type="button" class="btn btn-primary w-50"name="downdoadbutton" id="downdoadbutton">ดาวน์โหลดไฟล์</button>
            </div>
            <div class="col-md-12 m-2"></div>
            <div class="col-md-2 pt-2">
                <label for="examplefile" class="form-label text-secondary">เลือกไฟล์</label>
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
                <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
            </div>
        </form>
    </dic>
</div>
<script>
</script>