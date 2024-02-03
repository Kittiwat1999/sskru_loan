@extends('layout')
@section('title')
@endsection
@section('content')
<section class="content">
    @if($errors->any())
        <div class="card">

            <div class="card-body">
                <h5 class="card-title text-danger">ข้อผิดพลาด!</h5>
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-3 mt-2 text-center">
                    <span class="fw-bold text-dark">คำขอกู้ยืมรายเก่าเลื่อนชั้นปี</span>
                </div>
                <div class="col-md-2 mt-2">
                    <span class="text-secondary">ปีการศึกษา:</span> <span class="text-dark">{{$loanRequestDocument->year}}</span>
                </div>
                <div class="col-md-2 mt-2">
                    <span class="text-secondary">ภาคเรียนที่:</span> <span class="text-dark">{{$loanRequestDocument->term}}</span>
                </div>
                <div class="col-md-4 mt-2">
                    <span class="text-secondary">สถานะ: </span>
                    @if($loanRequestDocument->status == "nonsend")
                        <span class="text-warning">รอดำเนินการ....</span>
                    @elseif($loanRequestDocument->status == "send")
                        <span class="text-success"><i class="bi bi-check2-circle"></i> ส่งแล้ว </span> <span class="text-warning"> <i class="bi bi-exclamation-triangle-fill text-warning"></i> รอฝ่ายทุนอนุมัติ....</span>
                    @elseif($loanRequestDocument->status == "approve")
                        <span class="text-success"><i class="bi bi-check2-circle"></i> ฝ่ายทุนอนุมัติแล้ว</span>
                    @endif
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
                                <form action="{{route('send.loanrequest.doc')}}" method="post">
                                    @csrf 
                                    <input type="hidden" name="doc_id" value="{{$loanRequestDocument->id}}">
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

    {{-- ส่งสำเนาบัตรประชาชน --}}
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
                        <button type="button" data-bs-toggle="modal" data-bs-target="#citizen-modal" class="btn btn-outline-primary w-100"><i class="bi bi-eye"></i> ดูตัวอย่างไฟล์</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="citizen-modal" tabindex="-1" aria-labelledby="citizen-modal-label" aria-hidden="true">
                            <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="citizen-modal-label">ตัวอย่างไฟล์สำเนาบัตรประชาชน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row my-2">
                                        <div class="col-sm-12 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                                        <div class="col-sm-12">
                                            <!-- Slides with controls -->
                                            <div id="borrower-document_1" class="carousel slide my-3 w-100 border" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active" id="yinyorm">
                                                        <img src="{{asset('assets/img/exmImg/บัตรประชาชนผู้กู็.jpg')}}" class="d-block w-100" alt="...">
                                                    </div>
                                                </div>
                                            </div><!-- End Slides with controls -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--end modal-->
                    </div>
                </div>
            </div>
            <form action="{{route('store.citizencardfile')}}" method="POST" enctype="multipart/form-data" class="row">
                @csrf
                <input type="hidden" name="year" value="{{$loanRequestDocument->year}}" required>
                <input type="hidden" name="term" value="{{$loanRequestDocument->term}}" required>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="citizen_card_file" >เพิ่มไฟล์</label>
                    <div class="col-sm-4">
                        <input type="file" name="citizen_card_file" id="citizen_card_file" accept=".jpg, .jpeg, .png, .pdf" required onchange="show_submit_button('citizen')">
                    </div>
                </div>
                @if(isset($citizencardfile))
                <div class="col-md-12 row text-warning my-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <i class="bi bi-exclamation-lg"></i>
                        <span>หากต้องการแก้ใขไฟล์ให้เพิ่มไพล์และกดอัพโหลดอีกครั้ง</span>
                    </div>
                </div>
                @endif
                <div class="row col-md-12 mt-4">
                    <div class="col-md-8">
                        @if(isset($citizencardfile))
                        <i class="bi bi-check2-circle text-success fw-bold"></i>
                        <span class=" text-success fw-bold">อัพโหลดไฟล์แล้ว </span> &emsp; 
                        <span>
                            <a href="{{asset($citizencardfile->display_path)}}" target="_blank" rel="ดูไฟล์">
                                คลิกเพื่อดูไฟล์...
                            </a>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <button type="submit" class="btn btn-primary w-100 {{(isset($citizencardfile)) ? 'd-none' : '' }}" id="citizen-submit-button" ><i class="bi bi-save"></i> บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end ส่งสำเนาบัตรประชาชน --}}

    {{-- ใบรายงานผลการเรียน --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ส่งใบรายงานผลการเรียน</h5>
            <div class="row">

                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ไฟล์ประกอบไปด้วย</label>
                    <div class="col-sm-10">
                        <ul class="list-group list-borderless">
                            <li class="list-group-item">
                                <i class="bi bi-dash"></i>
                                ใบรายงานผลการเรียน
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="citizen_card_file">ตัวอย่างไฟล์</label>
                    <div class="col-md-5 col-sm-12">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#gpa-modal" class="btn btn-outline-primary w-100"><i class="bi bi-eye"></i> ดูตัวอย่างไฟล์</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="gpa-modal" tabindex="-1" aria-labelledby="gpa-modal-label" aria-hidden="true">
                            <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gpa-modal-label">ใบรายงานผลการเรียน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row my-2">
                                        <div class="col-sm-12 my-2 text-warning">*คลิกที่ขอบซ้ายหรือขวาของรูปภาพเพื่อดูตัวอย่างถัดไป*</div>
                                        <div class="col-sm-12">
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
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--end modal-->
                    </div>
                </div>
            </div>
            <form action="{{route('store.gpafile')}}" method="POST" enctype="multipart/form-data" class="row">
                @csrf
                <input type="hidden" name="year" value="{{$loanRequestDocument->year}}" required>
                <input type="hidden" name="term" value="{{$loanRequestDocument->term}}" required>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="gpa_file">เพิ่มไฟล์</label>
                    <div class="col-sm-4">
                        <input type="file" name="gpa_file" id="gpa_file" accept=".jpg, .jpeg, .png, .pdf" required  onchange="show_submit_button('gpa')">
                    </div>
                </div>
                @if(isset($gpafile))
                <div class="col-md-12 row text-warning my-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <i class="bi bi-exclamation-lg"></i>
                        <span>หากต้องการแก้ใขไฟล์ให้เพิ่มไพล์และกดอัพโหลดอีกครั้ง</span>
                    </div>
                </div>
                @endif
                <div class="row col-md-12 mt-4">
                    <div class="col-md-8">
                        @if(isset($gpafile))
                        <i class="bi bi-check2-circle text-success fw-bold"></i>
                        <span class=" text-success fw-bold">อัพโหลดไฟล์แล้ว </span> &emsp; 
                        <span>
                            <a href="{{asset($gpafile->display_path)}}" target="_blank" rel="ดูไฟล์">
                                คลิกเพื่อดูไฟล์...
                            </a>
                        </span>
                        @endif
                        
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <button type="submit" class="btn btn-primary w-100 {{(isset($gpafile)) ? 'd-none' : '' }}" id="gpa-submit-button" ><i class="bi bi-save"></i> บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end ใบรายงานผลการเรียน --}}

    {{-- กิจกรรมจิตอาสา --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">กิจกรรมจิตอาสา</h5>
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col-2">ชื่อโครงการ</th>
                            <th scope="col-2">สถานที่</th>
                            <th scope="col-2">วัน/เดือน/ปี</th>
                            <th scope="col-2">จำนวนชั่วโมง</th>
                            <th scope="col-2">ลักษณะกิจกรรม</th>
                            <th scope="col-2">ไฟล์หลักฐาน</th>
                            <th scope="col-2">:</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @php
                            $i = 1;
                            $hour_count = 0;
                        @endphp
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{$activity->project_name}}</td>
                                <td>{{$activity->project_location}}</td>
                                <td>{{$activity->date}}<br>{{$activity->time}}</td>
                                <td class="text-center">{{$activity->hour_count}}</td>
                                <td>{{$activity->description}}</td>
                                <td class="text-center">
                                    <button  class="btn btn-danger" onclick="openFile('{{asset($activity->display_path)}}')"><i class="bi bi-filetype-pdf" ></i></button>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn" type="button" id="dropdownMenuButton-{{$activity->id}}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{$activity->id}}">
                                            <li>
                                                <button type="button" class="dropdown-item text-warning" onclick="fetchActivitiesData({{$activity->id}})">
                                                แก้ใข <i class="bi bi-pencil"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-{{$activity->id}}">
                                                    ลบ <i class="bi bi-trash"></i>
                                                </button>
                                                
                                                
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="delete-modal-{{$activity->id}}" tabindex="-1" aria-labelledby="delete-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="delete-modalLabel">ลบกิจกรรม</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                คุณต้องการลบ <span class="text-danger">{{$activity->project_name}}</span> หรือไม่
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{route('delete.activity')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                                    <button type="submit" class="btn btn-danger">ลบกิจกรรมนี้</button>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>
                            @php
                                $hour_count += (int)$activity->hour_count
                            @endphp
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-activitiy-modal">
                                        <i class="bi bi-plus"></i> เพิ่มข้อมูล
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">{{$hour_count}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    {{-- end กิจกรรมจิตอาสา --}}

    <!-- add activitiy Modal -->
    <div class="modal fade" id="add-activitiy-modal" tabindex="-1" aria-labelledby="add-activitiy-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="add-activitiy-modalLabel">เพิ่มข้อมูลกิจกรรม</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('store.activities')}}" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="year" value="{{$loanRequestDocument->year}}" required>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="project_name">ชื่อโครงการ/ กิจกรรมที่เป็นประโยชน์ต่อสังคมหรอสาธารณะ</label>
                        <input class="form-control" type="text" name="project_name" id="project_name">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="project_location">สถานที่ดำเนินโครงการ</label>
                        <input class="form-control" type="text" name="project_location" id="project_location">
                    </div>
                    <div class="row col-sm-12 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="date">วันที่</label>
                            <input class="form-control" type="date" name="date" id="date">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="time">เวลา</label>
                            <input class="form-control" type="text" name="time" id="time" placeholder="9:00">
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="hour_count">จำนวนชั่วโมงรวม</label>
                        <input class="form-control" type="number" name="hour_count" id="hour_count">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="description">ลักษณะของกิจกรรม</label>
                        <input class="form-control" type="text" name="description" id="description">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="file">แนบไฟล์หลักฐาน</label>
                        <input class="form-control" type="file" name="file" id="file" accept=".png, .jpg, .jpeg, .pdf">
                    </div>
                {{-- </form> ควรจะปิดตรงนี้แต่อยากได้ button modal footer เป็น submit เลยเอาไปไว้ข้างล่าง--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>
                </form> 
        </div>
        </div>
    </div>
    {{-- end add activitiy Modal --}}


    <button class="d-none" id="edit-modal-button" type="button"data-bs-toggle="modal" data-bs-target="#edit-activitiy-modal"></button>

    <!-- add edit activitiy Modal -->
    <div class="modal fade" id="edit-activitiy-modal" tabindex="-1" aria-labelledby="edit-activitiy-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content" id="edit-activity-modal-content">
            
        </div>
        </div>
    </div>
    {{-- end edit activitiy Modal --}}
  
    

</section>
<script>
    var hour_count = @json($hour_count);
    var citizencardfile = @json(isset($citizencardfile));
    var gpafile = @json(isset($gpafile));

    if(hour_count >= 36 && (citizencardfile && gpafile)){
        const sendDocButton = document.getElementById('sendDocBtn');
        const explanation = document.getElementById('explanation');
        sendDocButton.disabled = false;
        explanation.innerHTML = `<span class="text-success"><i class="bi bi-check2-circle"></i>ท่านสามารถส่งเอกสารได้แล้วตอนนี้</span>`
    }else{
        const explanation = document.getElementById('explanation');
        explanation.innerHTML = `<span class="text-danger">**สามารถส่งได้ก็ต่อเมื่ออัพโหลดไฟล์ครบและมีชั่วโมงกิจกรรมครบ 36 ชั่วโมง**</span>`
    }

     function openFile(path) {
        window.open(path, '_blank');
    }

    function fetchActivitiesData(activitiy_id){
        console.log(activitiy_id);

        fetch(`{{url('borrower/getActivity/${activitiy_id}')}}`)
        .then(response => {
            if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
            }

            return response.json();
        })
        .then(activity => {
            // console.log(activity);
            const modalContent = document.getElementById('edit-activity-modal-content');
            modalContent.innerHTML = '';
            modalContent.innerHTML = `
            <div class="modal-header">
                <h5 class="modal-title" id="edit-activitiy-modalLabel">แก้ใขข้อมูลกิจกรรม ${activity.project_name}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('edit.activity')}}" method="POST" class="row" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="year" value="${activity.year}" required>
                    <input type="hidden" name="activity_id" value="${activity.id}">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="project_name">ชื่อโครงการ/ กิจกรรมที่เป็นประโยชน์ต่อสังคมหรอสาธารณะ</label>
                        <input class="form-control" type="text" name="project_name" id="project_name" value="${activity.project_name}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="project_location">สถานที่ดำเนินโครงการ</label>
                        <input class="form-control" type="text" name="project_location" id="project_location" value="${activity.project_location}">
                    </div>
                    <div class="row col-sm-12 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="date">วันที่</label>
                            <input class="form-control" type="date" name="date" id="date" value="${activity.date}">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="time">เวลา</label>
                            <input class="form-control" type="text" name="time" id="time" value="${activity.time}">
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="hour_count">จำนวนชั่วโมงรวม</label>
                        <input class="form-control" type="number" name="hour_count" id="hour_count" value="${activity.hour_count}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="description">ลักษณะของกิจกรรม</label>
                        <input class="form-control" type="text" name="description" id="description" value="${activity.description}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="file">แนบไฟล์หลักฐาน <span class="text-warning"> หากไม่ต้องการเปลี่ยนแปลงไฟล์ให้ข้ามขั้นตอนนี้</span></label>
                        <input class="form-control" type="file" name="file" id="file" accept=".png, .jpg, .jpeg, .pdf">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                    </form> 
            </div>
            `

            document.getElementById('edit-modal-button').click();
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }

    function show_submit_button(form_button){
        const submitButton = document.getElementById(form_button+'-submit-button');
        if(submitButton.classList.contains('d-none')){
            submitButton.classList.remove('d-none');
        }
    }
</script>
@endsection