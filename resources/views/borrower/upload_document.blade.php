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
    @foreach($child_documents as $child_document)
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{$child_document->child_document_title}}</h5>
            <div class="row">
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ไฟล์ประกอบไปด้วย</label>
                    <div class="col-sm-10">
                        <ul class="list-group list-borderless">
                            <li class="list-group-item">
                                - {{$child_document->child_document_title}}
                            </li>
                            @foreach($child_document->addon_documents as $addon_document)
                                @if($addon_document->for_minors && $borrower_age < 20)
                                    <li class="list-group-item">
                                        - {{$addon_document->title}}
                                    </li>
                                @elseif(!$addon_document->for_minors)
                                    <li class="list-group-item">
                                        - {{$addon_document->title}}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="component-file">ตัวอย่างเอกสาร</label>
                    <div class="col-sm-10">
                        <a href="http://" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger w-100">คลิกเพื่อดูไฟล์ตัวอย่าง</a>
                    </div>
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" class="row">
                @csrf
                <input type="hidden" name="year" value="" required>
                <input type="hidden" name="term" value="" required>
                <div class="col-md-12 row my-2">
                    <label class="col-sm-2 col-form-label text-secondary" for="citizen_card_file" >เลือกไฟล์</label>
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
    @endforeach

    {{-- กิจกรรมจิตอาสา --}}
    @if($document->need_useful_activity)
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
                            <th scope="col-2" class="text-center">แก้ใข/ลบ</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @php
                            $i = 1;
                            $hour_count = 0;
                        @endphp
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"></td>
                                <td></td>
                                <td class="text-center">
                                    {{-- <a class="btn btn-danger" href="{{url('/borrower/show_actv_file',['filepath' => $activity->display_path])}}" rel="noopener noreferrer"><i class="bi bi-filetype-pdf" ></i></a> --}}
                                    <button  class="btn btn-success" onclick="openFile('')"><i class="bi bi-journal-bookmark"></i></button>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a class="btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <button type="button" class="dropdown-item text-warning" onclick="fetchActivitiesData()">
                                                แก้ใข <i class="bi bi-pencil"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                    ลบ <i class="bi bi-trash"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="delete-modalLabel">ลบกิจกรรม</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                คุณต้องการลบ <span class="text-danger"></span> หรือไม่
                                            </div>
                                            <div class="modal-footer">
                                                <form action="" method="post">
                                                    @csrf
                                                    <input type="hidden" name="activity_id" value="">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                                    <button type="submit" class="btn btn-danger">ลบกิจกรรมนี้</button>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>
                            {{-- @php --}}
                                {{-- $hour_count += (int)$activity->hour_count --}}
                            {{-- @endphp --}}
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
                            <td class="text-center"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
             <!-- add activitiy Modal -->
            <div class="modal fade" id="add-activitiy-modal" tabindex="-1" aria-labelledby="add-activitiy-modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="add-activitiy-modalLabel">เพิ่มข้อมูลกิจกรรม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" class="row" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="year" value="" required>
                            <div class="col-sm-12 mb-3">
                                <label class="form-label" for="project_name">ชื่อโครงการ/ กิจกรรมที่เป็นประโยชน์ต่อสังคมหรือสาธารณะ</label>
                                <input class="form-control" type="text" name="project_name" id="project_name">
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label class="form-label" for="project_location">สถานที่ดำเนินโครงการ</label>
                                <input class="form-control" type="text" name="project_location" id="project_location">
                            </div>
                            <div class="row col-sm-12 mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="start-date" class="form-label text-secondary">วันที่เริ่ม</label>
                                    <div class="input-group date" id="">
                                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                        <input type="text" name="start_date" id="start-date" class="form-control"
                                        placeholder="วว/ดด/ปปปป ชม"/>
                                        <div class="invalid-feedback">
                                            กรุณากรอกวันเกิด
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end-date" class="form-label text-secondary">ถึงวันที่</label>
                                    <div class="input-group date" id="">
                                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                        <input type="text" name="end_date" id="end-date" class="form-control"
                                        placeholder="วว/ดด/ปปปป ชม"/>
                                        <div class="invalid-feedback">
                                            กรุณากรอกวันเกิด
                                        </div>
                                    </div>
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
        </div>
    </div>
    @endif
    {{-- end กิจกรรมจิตอาสา --}}
</section>
@endsection

@section('script')
<script>
    $("#start-date").datetimepicker({
        format: 'd-m-Y H:i', 
        timepicker: true, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });

    $("#end-date").datetimepicker({
        format: 'd-m-Y H:i', 
        timepicker: true, 
        yearOffset: 543, 
        closeOnDateSelect: true,
    });

</script>
@endsection