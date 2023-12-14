@extends('layout')
@section('titile')
borrower loan request
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
                            <small class="text-primary text-center text-progress-step fw-bold">สำเนาบัตรประชาชนผู้กู้</small>
                        </div>
                        <span class="bg-secondary w-25 rounded mt-3 me-1 ms-1" style="height: 0.17rem">
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button class="btn bg-secondary text-white btn-sm rounded-pill" style="width: 2rem; height: 2rem" data-bs-toggle="collapse" data-bs-target="#company3" aria-expanded="false" aria-controls="company3" onclick="stepFunction(event)">
                                  <i class="bi bi-file-earmark-arrow-down"></i>
                                </button>
                            </div>
                            <small class="text-secondary text-center text-progress-step fw-bold">ใบรายงานผลการเรียน</small>
                        </div>
                        <span class="bg-secondary w-25 rounded mt-3 me-1 ms-1" style="height: 0.17rem">
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button class="btn bg-secondary text-white btn-sm rounded-pill" style="width: 2rem; height: 2rem" data-bs-toggle="collapse" data-bs-target="#company3" aria-expanded="false" aria-controls="company3" onclick="stepFunction(event)">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                                </button>
                            </div>
                            <small class="text-secondary text-center text-progress-step fw-bold">กิจกรรมจิตอาสา</small>
                        </div>
                        
                        <span class="bg-secondary w-25 rounded mt-3 me-1 ms-1" style="height: 0.17rem">
                        </span>
                        <div class="d-flex flex-column">
                            <div class="text-center  mb-1">
                                <button class="btn bg-secondary text-white btn-sm rounded-pill" style="width: 2rem; height: 2rem" data-bs-toggle="collapse" data-bs-target="#company3" aria-expanded="false" aria-controls="company3" onclick="stepFunction(event)">
                                    <i class="bi bi-check-circle"></i>
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
                    <button class="nav-link active" id="id-card-tab" data-bs-toggle="tab" data-bs-target="#id-card" type="button" role="tab" aria-controls="id-card" aria-selected="true">สำเนาบัตรประชาชนผู้กู้</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gpa-tab" data-bs-toggle="tab" data-bs-target="#gpa" type="button" role="tab" aria-controls="gpa" aria-selected="false">ใบรายงานผลการเรียน</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false">กิจกรรมจิตอาสา</button>
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
                            <label for="downdoadbutton" class="form-label text-secondary">เอกสารที่ต้องส่ง</label>
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group list-borderless">
                                <li class="list-group-item">
                                    <i class="bi bi-dash"></i>
                                    สำเนาบัตรประชาชนผู้กู้พร้อมรับรองสำเนาถูกต้อง
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
                                        <img src="{{asset('assets/img/exmImg/บัตรประชาชนผู้กู็.jpg')}}" class="d-block w-100" alt="...">
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('gpa-tab')">ถัดไป</button>
                        </div>
                    </form>
                    <!-- end ฟอร์มส่งเอกสาร -->
                </div>

                <div class="tab-pane fade" id="gpa" role="tabpanel" aria-labelledby="gpa-tab">
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
                                    ใบรายงานผลการเรียน(หน้า,หลัง)
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
                            <div id="borrower-document_2" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" id="yinyorm">
                                        <img src="{{asset('assets/img/exmImg/gpa1.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" id="samnao">
                                        <img src="{{asset('assets/img/exmImg/gpa2.jpeg')}}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                    
                                <button class="carousel-control-prev" type="button" data-bs-target="#borrower-document_2" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#borrower-document_2" data-bs-slide="next">
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
                            <button type="button" class="btn btn-primary" onclick="nextPgae('activity-tab')">ถัดไป</button>
                        </div>
                    </form>
                    <!-- end ฟอร์มส่งเอกสาร -->
                </div>

                <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
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
                        <button type="button" class="btn btn-primary" onclick="nextPgae('sumary-tab')">ถัดไป</button>
                    </div>
                </div>

                <div class="tab-pane fade" id="sumary" role="tabpanel" aria-labelledby="sumary-tab">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-dark fw-bold">รายการเอกสาร</p>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>สำเนาบัตรประชาชนผู้กู้</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>ใบรายงานผลการเรียน</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                        
                        <div class="col-sm-12 my-1">
                            <span>กิจกรรมจิตอาสา</span>&emsp;
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                    
                        <div class="text-end my-1">
                            <button type="button" class="btn btn-primary">ส่งเอกสาร</button>
                        </div>
                    </div>
                </div>    
            </div>
        </div><!-- End Default Tabs -->
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