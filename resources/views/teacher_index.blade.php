@extends('teacher_layout')
@section('title')
    teacher home
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการคำขอกู้</h5>
                <!-- Default Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="wait-for-appove-tab" data-bs-toggle="tab" data-bs-target="#wait-for-appove" type="button" role="tab" aria-controls="wait-for-appove" aria-selected="true">คำขอกู้รออาจารย์ที่ปรึกษาให้ความเห็น</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="appove-tab" data-bs-toggle="tab" data-bs-target="#appove" type="button" role="tab" aria-controls="appove" aria-selected="false">ให้ความเห็นแล้ว</button>
                    </li>
                </ul>
                <?php 
                    date_default_timezone_set("Asia/Bangkok");
                    $loan_requests = array(
                        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'กู้มาผ่อน Iphone 15 promax','age'=>'24','comment'=>array('ครอบครัวขาดแคลน iphone 15','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'สาขาที่เป็นความต้องการหลัก','age'=>'23','comment'=>array('เป็นสาขาที่เป็นความต้องการหลัก','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    array('id'=>'6410014101','name'=>'กฤษฎา เจริญวิเชียรฉาย','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'สารขาที่ขาดแคลน','age'=>'21','comment'=>array('เป็นสารขาที่ขาดแคลน','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'กู้มาผ่อนบ้าน','age'=>'21','comment'=>array('นักศึกษาขาดแคลนที่อยู่อาศัย','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    );
                    $i = 0;
                ?>
                <div class="tab-content pt-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="wait-for-appove" role="tabpanel" aria-labelledby="wait-for-appove-tab">
                        <div class="row">
                            <div class="col-md-3 mt-3">
                                <p class="text-secondary">ทั้งหมด {{count($loan_requests)}} รายการ</p>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-1 text-end">
                                <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                            </div>
                            <div class="col-md-2">
                                <select id="grade" class="form-select" aria-label="Default select example">
                                    <option selected>ทั้งหมด</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสนักศึกษา</th>
                                        <th></th>
                                        <th>ลักษณะผู้กู้</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan_requests as $loan_req)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$loan_req['id']}}</td>
                                        <td>
                                            <sapn class="fw-bold">{{$loan_req['name']}}</sapn><br>
                                            <span class="fw-light text-secondary">{{$loan_req['faculty']}}</span><br>
                                            <span class="fw-light text-secondary">{{$loan_req['major']}}</span><br>
                                            <span class="fw-light text-secondary">ชั้นปี: {{$loan_req['grade']}}</span>
                                        </td>
                                        <td>{{$loan_req['type']}}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-secondary"  data-bs-toggle="modal" data-bs-target="#docModal">ดูรายละเอียดเอกสาร <i class="bi bi-file-pdf"></i></button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#comment-modal"><i class="bi bi-chat-right-quote"></i> ให้ความเห็น</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="appove" role="tabpanel" aria-labelledby="appove-tab">
                    <div class="row">
                            <div class="col-md-3 mt-3">
                                <p class="text-secondary">ทั้งหมด {{count($loan_requests)}} รายการ</p>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-1 text-end">
                                <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                            </div>
                            <div class="col-md-2">
                                <select id="grade" class="form-select" aria-label="Default select example">
                                    <option selected>ทั้งหมด</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสนักศึกษา</th>
                                        <th></th>
                                        <th>ลักษณะผู้กู้</th>
                                        <th>ความคิดเห็นอาจารย์ที่ปรึกษา</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan_requests as $loan_req)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$loan_req['id']}}</td>
                                        <td>
                                            <sapn class="fw-bold">{{$loan_req['name']}}</sapn><br>
                                            <span class="fw-light text-secondary">{{$loan_req['faculty']}}</span><br>
                                            <span class="fw-light text-secondary">{{$loan_req['major']}}</span><br>
                                            <span class="fw-light text-secondary">ชั้นปี: {{$loan_req['grade']}}</span>
                                        </td>
                                        <td>{{$loan_req['type']}}</td>
                                        <td>
                                            @foreach($loan_req['comment'] as $comment)
                                                <span class="text-success">{{$comment}}</span><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Default Tabs -->
            </div>
        </div>
        <!-- end card -->
        <!-- doc Modal -->
        <div class="modal fade" id="docModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เอกสารยื่นกู้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-row justify-content-center">
                    <iframe scrolling="no" src="{{asset('assets/pdf/รวมขอกู้.pdf#zoom=100')}}" width="100%" height="1500"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        <!-- End doc Modal-->
        <!-- comment Modal -->
        <div class="modal fade" id="comment-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละอียดผู้กู้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 text-end text-secondary fw-bold">ชื่อ-นามสกุล</div>
                        <div class="col-sm-8">{{$loan_requests['0']['name']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">ลักษณะผู้กู้</div>
                        <div class="col-sm-8">{{$loan_requests['0']['type']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">อายุ</div>
                        <div class="col-sm-8">{{$loan_requests['0']['age']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">รหัสนักศึกษา</div>
                        <div class="col-sm-8">{{$loan_requests['0']['id']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">คณะ</div>
                        <div class="col-sm-8">{{$loan_requests['0']['faculty']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">สาขา</div>
                        <div class="col-sm-8">{{$loan_requests['0']['major']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">ชั้นปี</div>
                        <div class="col-sm-8">{{$loan_requests['0']['grade']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">โทรศัพท์</div>
                        <div class="col-sm-8">{{$loan_requests['0']['tel']}}</div>
                        <div class="col-sm-4 text-end text-secondary fw-bold">ผลการเรียนเฉลี่ย</div>
                        <div class="col-sm-8">{{$loan_requests['0']['gpa']}}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="#" class="form-label">ให้ความเห็น</label>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                ครอบครัวของนักศึกษาขาดแคลนคุณทรัพย์
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck2">
                                <label class="form-check-label" for="gridCheck2">
                                เป็นสาขาที่เป็นความต้องการหลักของประเทศ
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                เป็นสารขาที่ขาดแคลนของประเทศ
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck2">
                                <label class="form-check-label" for="gridCheck2">
                                เพื่อส่งต่อโอกาศทางการศึกษาให้นักศึกษาได้สำเร็จการศึกษา
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                เห็นควรพิจารณาอนุมัติให้กู้ยืม
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck2" onchange="enableInputText()">
                                <label class="form-check-label" for="gridCheck2">
                                อื่นๆ
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="morecommnet" id="morecommnet" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- End comment Modal-->
    </section>
    <script>
        function enableInputText(){
            const inputText = document.getElementById('morecommnet');
            inputText.disabled = !inputText.disabled;
        }
    </script>
@endsection