<div class="card">
    <dic class="card-body">
        <h5 class="card-title">ส่งเอกสาร</h5>
        <div class="col-md-12 line-section mb-4"></div>
            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="yinyom-borrower-tab" data-bs-toggle="tab" data-bs-target="#yinyom-borrower" type="button" role="tab" aria-controls="yinyom-borrower" aria-selected="true">หนังสือยินยอมให้เปิดเผยข้อมูลผู้กู้</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="yinyom-parent-tab" data-bs-toggle="tab" data-bs-target="#yinyom-parent" type="button" role="tab" aria-controls="yinyom-parent" aria-selected="false">หนังสือยินยอมให้เปิดเผยข้อมูลผู้แทน</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="loan-document-tab" data-bs-toggle="tab" data-bs-target="#loan-document" type="button" role="tab" aria-controls="loan-document" aria-selected="false">แบบคำขอกู้ยืม</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rabrong-raidai-tab" data-bs-toggle="tab" data-bs-target="#rabrong-raidai" type="button" role="tab" aria-controls="rabrong-raidai" aria-selected="false">หนังสือรับรองรายได้</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kidjakam-tab" data-bs-toggle="tab" data-bs-target="#kidjakam" type="button" role="tab" aria-controls="kidjakam" aria-selected="false">กิจกรรมจิตรอาสา</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gpa-tab" data-bs-toggle="tab" data-bs-target="#gpa" type="button" role="tab" aria-controls="gpa" aria-selected="false">ใบรับรองผลการเรียน</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sumary-tab" data-bs-toggle="tab" data-bs-target="#sumary" type="button" role="tab" aria-controls="sumary" aria-selected="false">ตรวจสอบการส่งเอกสาร</button>
                </li>
            </ul>
            <div class="tab-content pt-2 mx-2" id="myTabContent">
                <div class="tab-pane fade show active" id="yinyom-borrower" role="tabpanel" aria-labelledby="yinyom-borrower-tab">
                    <!-- ฟอร์มส่งเอกสาร -->
                    <form class="row">
                        <div class="col-sm-12 my-3"></div>
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
                        <div class="col-md-10 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <!-- Slides with controls -->
                            <div id="borrower-document" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/บัตรประชาชนผู้กู็.jpg')}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" id="samnao">
                                        <img src="{{asset('assets/img/exmImg/หนังสือยินยอม.jpg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#borrower-document" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#borrower-document" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </button>
                    
                            </div>
                            <!-- End Slides with controls -->
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
                        </div>
                    </form>
                    <!-- end ฟอร์มส่งเอกสาร -->
                </div>
                <div class="tab-pane fade" id="yinyom-parent" role="tabpanel" aria-labelledby="yinyom-parent-tab">
                    <form class="row">
                        <div class="col-sm-12 my-3"></div>
                        <div class="col-md-2">
                            <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group list-borderless">
                                <li class="list-group-item">
                                    <i class="bi bi-dash"></i>
                                    หนังสือยินยิมให้เปิดเผยข้อมูลผู้แทนโดยชอบธรรม
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-dash"></i>
                                    สำเนาบัตรประชาชนผู้แทนโดยชอบธรรมพร้อมเซ็นสำเนาถูกต้อง
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 pt-2">
                            <label for="exampdoc" class="form-label text-secondary">ตัวอย่างเอกสาร</label>
                        </div>
                        <div class="col-md-10 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <!-- Slides with controls -->
                            <div id="parent-document" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/บัตรประชาชนผู้กู็.jpg')}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" id="samnao">
                                        <img src="{{asset('assets/img/exmImg/หนังสือยินยอม.jpg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#parent-document" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#parent-document" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </button>
                    
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="loan-document" role="tabpanel" aria-labelledby="loan-document-tab">
                    <form class="row">
                        <div class="col-sm-12 my-3"></div>
                        <div class="col-md-2">
                            <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group list-borderless">
                                <li class="list-group-item">
                                    <i class="bi bi-dash"></i>
                                    แบบคำขอกู้ยืม
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 pt-2">
                            <label for="exampdoc" class="form-label text-secondary">ตัวอย่างเอกสาร</label>
                        </div>
                        <div class="col-md-10 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <!-- Slides with controls -->
                            <div id="loan-doc" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/คำขอกู้1.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" id="samnao">
                                        <img src="{{asset('assets/img/exmImg/คำขอกู้2.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#loan-doc" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#loan-doc" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </button>
                    
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="rabrong-raidai" role="tabpanel" aria-labelledby="rabrong-raidai-tab">
                    <form class="row">
                        <div class="col-sm-12 my-3"></div>
                        <div class="col-md-2">
                            <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
                        </div>
                        <div class="col-md-10">
                            <!-- <label class="form-label text-secondary fw-bold">ประเภทรายได้ของผู้ปกครอง</label> -->
                            <div class="col-md-12 px-4">
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="salary_type" id="salary_type2" value="ไม่มีรายได้ประจำ"checked  onchange="showDoc(this.value)">
                                    <label class="form-check-label" for="salary_type2">
                                        ไม่มีรายได้ประจำ (กยศ.102 หนังสือรับรองรายได้ครอบครัว)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 px-4">
                                <div class="form-check my-2">
                                    <input class="form-check-input" type="radio" name="salary_type" id="sarary_type1" value="มีรายได้ประจำ" onchange="showDoc(this.value)">
                                    <label class="form-check-label" for="sarary_type1">
                                        มีรายได้ประจำ (หนังสือรับรองรายได้)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 pt-2">
                            <label for="exampdoc" class="form-label text-secondary">ตัวอย่างเอกสาร</label>
                        </div>
                        <div class="col-md-10 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <!-- Slides with controls -->
                            <div id="rabrong-doc1" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/กยศ102.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" id="samnao">
                                        <img src="{{asset('assets/img/exmImg/สำเนาบัตรเจ้าหน้าที่รัฐ.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#rabrong-doc1" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#rabrong-doc1" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </button>
                            </div><!-- End Slides with controls -->
                            <!-- Slides with controls -->
                            <div id="rabrong-doc2" class="carousel slide my-3 w-100 border" style="display:none;" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/รับรองรายได้.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#rabrong-doc2" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#rabrong-doc2" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </button>
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="kidjakam" role="tabpanel" aria-labelledby="kidjakam-tab">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th scope="col-2">ชื่อโครงการ</th>
                                <th scope="col-2">สถานที่</th>
                                <th scope="col-2">วัน/เดือน/ปี</th>
                                <th scope="col-2">จำนวนชั่วโมง</th>
                                <th scope="col-2">ลักษณะกิจกรรม</th>
                                <th scope="col-2">แนบหลักฐาน</th>
                            </tr>
                        </thead>
                        <tbody id="table-body" class="text-center">
                            <?php
                                $activity = array(
                                                    array('Project_name'=>'ปรับภูมิทัศน์โรงเรียน','location'=>'โรงเรียนบ้านดู่','date'=>'11/11/2566','hours'=>'12','Activity_details'=>'ถางหญ้าที่รกมากๆ'),
                                                    array('Project_name'=>'ปรับภูมิทัศน์โรงเรียน','location'=>'โรงเรียนบ้านดู่','date'=>'11/11/2566','hours'=>'12','Activity_details'=>'ถางหญ้าที่รกมากๆ'),
                                                    array('Project_name'=>'ปรับภูมิทัศน์โรงเรียน','location'=>'โรงเรียนบ้านดู่','date'=>'11/11/2566','hours'=>'12','Activity_details'=>'ถางหญ้าที่รกมากๆ'),
                                                    array('Project_name'=>'ปรับภูมิทัศน์โรงเรียน','location'=>'โรงเรียนบ้านดู่','date'=>'11/11/2566','hours'=>'12','Activity_details'=>'ถางหญ้าที่รกมากๆ'),
                                                    array('Project_name'=>'ปรับภูมิทัศน์โรงเรียน','location'=>'โรงเรียนบ้านดู่','date'=>'11/11/2566','hours'=>'12','Activity_details'=>'ถางหญ้าที่รกมากๆ'),
             
                                                );
                                                $i = 1;
                            ?>
                            @foreach($activity as $activity_0)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$activity_0['Project_name']}}</td>
                                    <td>{{$activity_0['location']}}</td>
                                    <td>{{$activity_0['date']}}</td>
                                    <td class="text-center">{{$activity_0['hours']}}</td>
                                    <td>{{$activity_0['Activity_details']}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger"><i class="bi bi-filetype-pdf"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">60</td>
                                <td></td>
                                <td class="text-center">

                                    <div>
                                        <div>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#verticalycentered">
                                                เพิ่มข้อมูล<i class="bi bi-file-earmark-plus"></i>
                                            </button>
                                        </div>
                                        <div class="modal fade" id="verticalycentered" tabindex="-1">
                                            <div class="modal-dialog modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">เพิ่มข้อมูลกิจกรรม</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>

                                                            <div class="row-cols-auto">

                                                                <div class="col-md-2 text-start">
                                                                    <label for="firstname"
                                                                        class="text-secondary">ชื่อโครงการ</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="firstname" type="text"
                                                                            class="form-control" id="firstname">
                                                                    </div><br>
                                                                </div>

                                                                <div class="col-md-2 text-start">
                                                                    <label for="lastname"
                                                                        class="text-secondary">สถานที่</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="lastname" type="text"
                                                                            class="form-control" id="lastname">
                                                                    </div><br>
                                                                </div>

                                                                <div class="col-md-2 text-start">
                                                                    <label for="username"
                                                                        class="text-secondary">วัน/เดือน/ปี</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="username" type="date"
                                                                            class="form-control" id="username">
                                                                    </div><br>
                                                                </div>

                                                                <div class="col-md-2 text-start">
                                                                    <label for="password"
                                                                        class="text-secondary">จำนวนชั่วโมง</label>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div>
                                                                        <input name="password" type="number"
                                                                            class="form-control" id="password">
                                                                    </div>
                                                                    <br>
                                                                </div>

                                                                <div class="row-cols-auto">
                                                                    <div class="col-md-2 text-start">
                                                                        <label for="password"
                                                                            class="text-secondary">ลักษณะกิจกรรม</label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div>
                                                                            <input name="password" type="text"
                                                                                class="form-control"
                                                                                id="password">
                                                                        </div>
                                                                        <br>

                                                                        <div class="col-md-2 text-start">
                                                                            <label for="password"
                                                                                class="text-secondary">แนบไฟล์</label>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div>
                                                                                <input name="password"
                                                                                    type="file"
                                                                                    class="form-control"
                                                                                    id="password">
                                                                            </div>
                                                                            <br>
                                                                        </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ยกเลิก</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">เพิ่มข้อมูล</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
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
                </div>
                <div class="tab-pane fade" id="gpa" role="tabpanel" aria-labelledby="gpa-tab">
                    <form class="row">
                        <div class="col-sm-12 my-3"></div>
                        <div class="col-md-2">
                            <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group list-borderless">
                                <li class="list-group-item">
                                    <i class="bi bi-dash"></i>
                                    ใบรับรองผลการเรียน(หน้า,หลัง)
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2 pt-2">
                            <label for="exampdoc" class="form-label text-secondary">ตัวอย่างเอกสาร</label>
                        </div>
                        <div class="col-md-10 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <!-- Slides with controls -->
                            <div id="gpa-doc" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/gpa1.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" id="samnao">
                                        <img src="{{asset('assets/img/exmImg/gpa2.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#gpa-doc" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#gpa-doc" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </button>
                    
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('')">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="sumary" role="tabpanel" aria-labelledby="sumary-tab">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-dark fw-bold">รายการเอกสาร</p>
                        </div>
                        <div class="col-sm-12 my-1">
                            <span>หนังสือยินยอมให้เปืดเผยข้อมูลผู้กู้</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>หนังสือยินยอมให้เปืดเผยข้อมูลผู้แทนโดยชอบธรรม</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>แบบคำขอกู้ยืม(กยศ.101)</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>หนังสือรับรองรายได้ครอบครัว</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>กิจกรรมจิตอาสา</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                       
                        <div class="col-sm-12 my-1">
                            <span>ใบรายงานผลการเรียน</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        <div class="text-end my-1">
                            <button type="button" class="btn btn-primary">ส่งเอกสาร</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Default Tabs -->
    </dic>
</div>
<script>
    function showDoc(docName){
        console.log(docName);
        if(docName == 'มีรายได้ประจำ'){
            document.getElementById('rabrong-doc1').style.display = "none";
            document.getElementById('rabrong-doc2').style.display = "block";
        }else{
            document.getElementById('rabrong-doc1').style.display = "block";
            document.getElementById('rabrong-doc2').style.display = "none";
        }
    }
</script>
    