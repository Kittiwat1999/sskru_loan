@extends('admin_layout')
@section('title')
รายการยื่นกู้รายใหม่
@endsection
@section('content')
    
    <section class="section dashboard">
        <div class="card">
            <div class="card-body pt-3">
                <!-- <h5 class="card-title">title</h5> -->
                <!-- loan_list Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="loan-submission-tab" data-bs-toggle="tab" data-bs-target="#loan-submission" type="button" role="tab" aria-controls="loan-submission" aria-selected="true">รายการยื่นกู้</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="wait-for-edit-tab" data-bs-toggle="tab" data-bs-target="#wait-for-edit" type="button" role="tab" aria-controls="wait-for-edit" aria-selected="false">รอแก้ใข</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="finished-editing-tab" data-bs-toggle="tab" data-bs-target="#finished-editing" type="button" role="tab" aria-controls="finished-editing" aria-selected="false">แก้ใขแล้ว</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approve-tab" data-bs-toggle="tab" data-bs-target="#approve" type="button" role="tab" aria-controls="approve" aria-selected="true">อนุมัติแล้ว</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="no-approval-tab" data-bs-toggle="tab" data-bs-target="#no-approval" type="button" role="tab" aria-controls="no-approval" aria-selected="false">รอการอนุมัติจากคณะ/วิทยาลัย,อาจารย์ที่ปรึกษา</button>
                    </li>
                </ul>
                <?php 
                date_default_timezone_set("Asia/Bangkok");

                  $loan_request = array(
                    array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน'),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์'),
                    array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('สำเนาบัตรผู้ปกครอง'=>'เอกสารไม่ชัดเจน','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน'),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์'),
                    array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','ใบรายงานผลการเรียน'=>'เอกสารไม่ชัดเจน'),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์'),
                    array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน','สำเนาบัตรผู้แทน'=>'เอกสารไม่ชัดเจน'),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์'),
                  );
                ?>
                <div class="tab-content" id="myTabContent">
                    <!-- รายการยื่นกู้ -->
                    <div class="tab-pane fade pt-3 show active" id="loan-submission" role="tabpanel" aria-labelledby="loan-submission-tab">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="faculty" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">คณะอะไร</option>
                              <option value="2">หมูกรอบ</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">สาขา</label>
                          <select id="major" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">สาขาอะไร</option>
                              <option value="2">สักอย่าง</option>
                          </select>
                        </div>
                        <div class="col-md-2">
                          <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                          <select id="grade" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                          </select>
                        </div>
                        <div class="col-md-12"><p class="text-secondary mt-3 mb-3">จำนวน {{ count($loan_request) }} ราย</p></div>
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <!-- Dark Table -->
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">รหัสนักศึกษา</th>
                                  <th scope="col"></th>
                                  <th scope="col">วันที่ส่งเอกสาร</th>
                                  <th class="text-center" scope="col">ความเห็นคณะ</th>
                                  <th scope="col">อาจารย์ที่ปรึกษา</th>
                                </tr>
                              </thead>
                              <tbody >
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr onclick="showdocModal({{$borrower['id']}})">
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td>
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                                    <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                                  </td>
                                  <td>
                                    {{$borrower['date_return']}}
                                  </td>
                                  <td class="text-center"><span class="text-success fw-light">{{$borrower['faculty_check']}}</span></td>
                                  <td><span class="text-secondary fw-light"> {{$borrower['professor']}}</span></td>
                                  <button id="doc-button{{$borrower['id']}}" type="button" class="d-none btn btn-primary" data-bs-toggle="modal" data-bs-target="#docModal">
                                    Vertically centered
                                  </button>
                                </tr>
                                @endforeach
                                  
                              </tbody>
                            </table>
                          </div>
                          <!-- End Dark Table -->
                        </div>
                      </div>
                    </div>
                    <!-- end รายการยื่นกู้ -->
                    <!-- รอแก้ใข -->
                    <div class="tab-pane fade pt-3" id="wait-for-edit" role="tabpanel" aria-labelledby="wait-for-edit-tab">

                      <div class="row">
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="faculty" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">คณะอะไร</option>
                              <option value="2">หมูกรอบ</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="major" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">สาขาอะไร</option>
                              <option value="2">สักอย่าง</option>
                          </select>
                        </div>
                        <div class="col-md-2">
                          <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                          <select id="grade" class="form-select" aria-label="Default select example">
                            <option selected>ทั้งหมด</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>
                        <div  class="col-md-12"><p id="to-edit-count" class="text-secondary mt-3 mb-3"></p></div>
                        <div class="col-md-12">
                          <!-- Dark Table -->
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">รหัสนักศึกษา</th>
                                  <th scope="col"></th>
                                  <th scope="col">วันที่ตีกลับ</th>
                                  <th scope="col">หมายเหตุ</th>
                                </tr>
                              </thead>
                              <tbody id="toEdit">
                              <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr onclick="showEditModal({{$borrower['id']}})">
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td> 
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br> 
                                    <span class="text-secondary fe-lighter"> ชั้นปี: {{$borrower['grade']}}</span>
                                  </td>
                                  <td>{{$borrower['date_return']}}</td>
                                  <td>
                                   @foreach($borrower['comment'] as $key => $value)
                                    <p class="text-danger">{{$key}} : {{$value}}</p>
                                   @endforeach
                                  </td>
                                  <button id="edit-button{{$borrower['id'];}}" style="display:none;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                                    Extra Large Modal
                                  </button>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          <!-- Dark Table -->
                        </div>
                      </div>
                    </div>
                    <!-- end รอแก้ใข -->
                    <!-- แก้ใขแล้ว -->
                    <div class="tab-pane fade pt-3" id="finished-editing" role="tabpanel" aria-labelledby="finished-editing-tab">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="faculty" class="form-select" aria-label="Default select example">
                              <option selected>คณะ/วิทยาลัย</option>
                              <option value="1">คณะอะไร</option>
                              <option value="2">หมูกรอบ</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="major" class="form-select" aria-label="Default select example">
                              <option selected>สาขา</option>
                              <option value="1">สาขาอะไร</option>
                              <option value="2">สักอย่าง</option>
                          </select>
                        </div>
                          <div class="col-md-2">
                          <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                          <select id="grade" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                          </select>
                        </div>
                        <div class="col-md-12"><p class="text-secondary mt-3 mb-3">จำนวน {{ count($loan_request) }} ราย</p></div>
                        <div class="col-md-12">
                          <!-- Dark Table -->
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">รหัสนักศึกษา</th>
                                  <th scope="col"></th>
                                  <th scope="col">วันที่แก้ใข</th>
                                  <th scope="col">หมายเหตุ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr onclick="showdocModal({{$borrower['id']}})">
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td> 
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                                    <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
  
                                  </td>
                                  <td>{{$borrower['date_return']}}</td>
                                  <td>
                                   @foreach($borrower['comment'] as $key => $value)
                                    <p class="text-success">{{$key}} : {{$value}}</p>
                                   @endforeach
                                  </td>
                                  <button id="doc-button{{$borrower['id'];}}doc" style="display:none;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#docModal">
                                    Extra Large Modal
                                  </button>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          <!-- Dark Table -->
                        </div>
                      </div>
                    </div>
                    <!-- end แก้ใขแล้ว -->
                    <!-- อนุมัติแล้ว -->
                    <div class="tab-pane fade pt-3" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="faculty" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">คณะอะไร</option>
                              <option value="2">หมูกรอบ</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="major" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">สาขาอะไร</option>
                              <option value="2">สักอย่าง</option>
                          </select>
                        </div>
                        <div class="col-md-2">
                          <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                          <select id="grade" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                          </select>
                        </div>
                        <div class="col-md-12"><p class="text-secondary mt-3 mb-3">จำนวน {{ count($loan_request) }} ราย</p></div>
                        <div class="col-md-12">
                          <!-- Dark Table -->
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">รหัสนักศึกษา</th>
                                  <th scope="col"></th>
                                  <th scope="col">วันที่อนุมัติ</th>
                                  <th class="text-center" scope="col">ความเห็นคณะ</th>
                                  <th scope="col">อาจารย์ที่ปรึกษา</th>
                                  <th scope="col">ผู้ตรวจ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr>
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td>
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                                    <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                                  </td>
                                  <td>
                                    {{$borrower['date_return']}}
                                  </td>
                                  <td class="text-center"><span class="text-success fw-light">{{$borrower['faculty_check']}}</span></td>
                                  <td><span class="text-secondary fw-light"> {{$borrower['professor']}}</span></td>
                                  <td><span class="text-secondary fw-light">{{$borrower['ckeker_name']}}</span></td>
                                </tr>
                                @endforeach
                                  
                              </tbody>
                            </table>
                          </div>
                          <!-- End Dark Table -->
                        </div>
                      </div>
                    </div>
                    <!-- อนุมัติแล้ว -->
                    <!-- ยังไม่มีการอนุมัติ -->
                    <div class="tab-pane fade pt-3" id="no-approval" role="tabpanel" aria-labelledby="no-approval-tab">
                    <div class="row">
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">เลือกดูสถานะ</label>
                          <select id="major" class="form-select" aria-label="Default select example">
                              <option selected value="0">ทั้งหมด</option>
                              <option value="1">อาจารย์ที่ปรึกษายังไม่อนุมัติ</option>
                              <option value="2">คณะยังไม่อนุมัติ</option>
                              <option value="3">ยังไม่มีการอนุมัติใดๆ</option>
                          </select>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="faculty" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">คณะอะไร</option>
                              <option value="2">หมูกรอบ</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                          <select id="major" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">สาขาอะไร</option>
                              <option value="2">สักอย่าง</option>
                          </select>
                        </div>
                        <div class="col-md-2">
                          <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                          <select id="grade" class="form-select" aria-label="Default select example">
                              <option selected>ทั้งหมด</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                          </select>
                        </div>
                       
                        <div class="col-md-12"><p class="text-secondary mt-3 mb-3">จำนวน {{ count($loan_request) }} ราย</p></div>
                        <div class="col-md-12">
                          <!-- Dark Table -->
                          <?php 
                            $loan_request = array(
                              array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'-','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน')),
                              array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'-','ckeker_name'=>'กรวี','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('สำเนาบัตรผู้ปกครอง'=>'เอกสารไม่ชัดเจน','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน')),
                              array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'-','ckeker_name'=>'มาโนช','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','ใบรายงานผลการเรียน'=>'เอกสารไม่ชัดเจน')),
                              array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'-','faculty_check'=>'-','ckeker_name'=>'สถาพร','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน','สำเนาบัตรผู้แทน'=>'เอกสารไม่ชัดเจน')),
                            )
                          ?>
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead >
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">รหัสนักศึกษา</th>
                                  <th scope="col"></th>
                                  <th scope="col">วันที่ส่งเอกสาร</th>
                                  <th class="text-center" scope="col">ความเห็นคณะ</th>
                                  <th scope="col">อาจารย์ที่ปรึกษา</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr>
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td>
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                                    <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                                  </td>
                                  <td>{{$borrower['date_return']}}</td>
                                  <td class="text-center"><span class="text-dark fw-light">{{$borrower['faculty_check']}}</span></td>
                                  <td><span class="text-dark fw-light">{{$borrower['professor']}}</span></td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          <!-- End Dark Table -->
                        </div>
                      </div>
                    </div>
                    <!-- ยังไม่มีการอนุมัติ -->

                </div><!-- End loan_list Tabs -->
            </div>
        </div>
    </section>
    <!-- doc Modal-->
    <div class="modal fade" id="docModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content  bg-dark">
        <div class="modal-header">
          <h5 class="modal-title text-light">เอกสารยื่นกู้</h5>
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close"><I class="bi bi-x-lg"></I></button>
        </div>
        <!-- modal content -->
        <div class="modal-body" id="doc-content">
          <div class="mt-3 mb-3">

            <!-- หนังสือยินยอมให้เปิดเผยข้อมูลผู้กู้ -->
            <h5 class="fw-bold text-light">หนังสือยินยอมให้เปิดเผยข้อมูลผู้กู้</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/ยินยอมให้เปิดเผยข้อมูล.pdf#zoom=100')}}" width="100%" height="1500"></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="borrower_confirm" id="borrower_confirm_radio" value="true" checked onchange="enableCheckbox('borrower_')">
                      <label class="form-check-label" for="borrower_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="borrower_confirm" id="borrower_to_edit" value="false" onchange="enableCheckbox('borrower_')">
                      <label class="form-check-label" for="borrower_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="borrower_comment_1" disabled>
                      <label class="form-check-label" for="borrower_comment_1" name="borrower_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="borrower_comment_2" disabled>
                      <label class="form-check-label" for="borrower_comment_2" name="borrower_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="borrower_more_radio" disabled onchange="enableInputArea('borrower_')">
                      <label class="form-check-label" for="borrower_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="borrower_moreText"></label>
                      <textarea class="form-control" name="borrower_moreText" id="borrower_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="borrower_comment_3" disabled>
                      <label class="form-check-label" for="borrower_comment_3" name="borrower_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="borrower_comment_4" disabled>
                      <label class="form-check-label" for="borrower_comment_4" name="borrower_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end หนังสือยินยอมให้เปิดเผยข้อมูลผู้กู้ -->
          <!-- หนังสือยินยอมให้เปิดเผยข้อมูลผู้แทน -->
          <div class="mb-3 mt-3">
            <h5 class="fw-bold text-light">หนังสือยินยอมให้เปิดเผยข้อมูลผู้แทน</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/ยินยอมให้เปิดเผยข้อมูล.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="agent_confirm" id="agent_confirm_radio" value="true" checked onchange="enableCheckbox('agent_')">
                      <label class="form-check-label" for="agent_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="agent_confirm" id="agent_to_edit" value="false" onchange="enableCheckbox('agent_')">
                      <label class="form-check-label" for="agent_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="agent_comment_1" disabled>
                      <label class="form-check-label" for="agent_comment_1" name="agent_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="agent_comment_2" disabled>
                      <label class="form-check-label" for="agent_comment_2" name="agent_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="agent_more_radio" disabled onchange="enableInputArea('agent_')">
                      <label class="form-check-label" for="agent_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="agent_moreText"></label>
                      <textarea class="form-control" name="agent_moreText" id="agent_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="agent_comment_3" disabled>
                      <label class="form-check-label" for="agent_comment_3" name="agent_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="agent_comment_4" disabled>
                      <label class="form-check-label" for="agent_comment_4" name="agent_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end หนังสือยินยอมให้เปิดเผยข้อมูลผู้แทน -->
          <!-- หนังสือรับรองรายได้ครอบครัว -->
          <div class="mb-3 mt-3">
            <h5 class="fw-bold text-light">หนังสือรับรองรายได้ครอบครัว</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/รับรองรายได้.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="income_confirm" id="income_confirm_radio" value="true" checked onchange="enableCheckbox('income_')">
                      <label class="form-check-label" for="income_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="income_confirm" id="income_to_edit" value="false" onchange="enableCheckbox('income_')">
                      <label class="form-check-label" for="income_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="income_comment_1" disabled>
                      <label class="form-check-label" for="income_comment_1" name="income_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="income_comment_2" disabled>
                      <label class="form-check-label" for="income_comment_2" name="income_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="income_more_radio" disabled onchange="enableInputArea('income_')">
                      <label class="form-check-label" for="income_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="income_moreText"></label>
                      <textarea class="form-control" name="income_moreText" id="income_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="income_comment_3" disabled>
                      <label class="form-check-label" for="income_comment_3" name="income_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="income_comment_4" disabled>
                      <label class="form-check-label" for="income_comment_4" name="income_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end หนังสือรับรองรายได้ครอบครัว -->
          <!-- บันทึกกิจกรรมจิตอาสา -->
          <div class="mb-3 mt-3">
            <h5 class="fw-bold text-light">บันทึกกิจกรรมจิตอาสา</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/กิจกรรม.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="volunteer_activities_confirm" id="volunteer_activities_confirm_radio" value="true" checked onchange="enableCheckbox('volunteer_activities_')">
                      <label class="form-check-label" for="volunteer_activities_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="volunteer_activities_confirm" id="volunteer_activities_to_edit" value="false" onchange="enableCheckbox('volunteer_activities_')">
                      <label class="form-check-label" for="volunteer_activities_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="volunteer_activities_comment_1" disabled>
                      <label class="form-check-label" for="volunteer_activities_comment_1" name="volunteer_activities_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="volunteer_activities_comment_2" disabled>
                      <label class="form-check-label" for="volunteer_activities_comment_2" name="volunteer_activities_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="volunteer_activities_more_radio" disabled onchange="enableInputArea('volunteer_activities_')">
                      <label class="form-check-label" for="volunteer_activities_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="volunteer_activities_moreText"></label>
                      <textarea class="form-control" name="volunteer_activities_moreText" id="volunteer_activities_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="volunteer_activities_comment_3" disabled>
                      <label class="form-check-label" for="volunteer_activities_comment_3" name="volunteer_activities_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="volunteer_activities_comment_4" disabled>
                      <label class="form-check-label" for="volunteer_activities_comment_4" name="volunteer_activities_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end บันทึกกิจกรรมจิตอาสา -->
          <!-- แบบคำขอกู้ยืม -->
          <div class="mb-3 mt-3">
            <h5 class="fw-bold text-light">แบบคำขอกู้ยืม</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/คำขอกู้.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="loan_req_confirm" id="loan_req_confirm_radio" value="true" checked onchange="enableCheckbox('loan_req_')">
                      <label class="form-check-label" for="loan_req_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="loan_req_confirm" id="loan_req_to_edit" value="false" onchange="enableCheckbox('loan_req_')">
                      <label class="form-check-label" for="loan_req_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="loan_req_comment_1" disabled>
                      <label class="form-check-label" for="loan_req_comment_1" name="loan_req_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="loan_req_comment_2" disabled>
                      <label class="form-check-label" for="loan_req_comment_2" name="loan_req_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="loan_req_more_radio" disabled onchange="enableInputArea('loan_req_')">
                      <label class="form-check-label" for="loan_req_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="loan_req_moreText"></label>
                      <textarea class="form-control" name="loan_req_moreText" id="loan_req_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="loan_req_comment_3" disabled>
                      <label class="form-check-label" for="loan_req_comment_3" name="loan_req_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="loan_req_comment_4" disabled>
                      <label class="form-check-label" for="loan_req_comment_4" name="loan_req_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end แบบคำขอกู้ยืม -->
          <!-- ความคิดเห็นอาจารย์ที่ปรึกษา -->
          <div class="mb-3 mt-3">
            <h5 class="fw-bold text-light">ความคิดเห็นอาจารย์ที่ปรึกษา</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/ความเห็นอาจารย์.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="comment_teacher_confirm" id="comment_teacher_confirm_radio" value="true" checked onchange="enableCheckbox('comment_teacher_')">
                      <label class="form-check-label" for="comment_teacher_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="comment_teacher_confirm" id="comment_teacher_to_edit" value="false" onchange="enableCheckbox('comment_teacher_')">
                      <label class="form-check-label" for="comment_teacher_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="comment_teacher_comment_1" disabled>
                      <label class="form-check-label" for="comment_teacher_comment_1" name="comment_teacher_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="comment_teacher_comment_2" disabled>
                      <label class="form-check-label" for="comment_teacher_comment_2" name="comment_teacher_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="comment_teacher_more_radio" disabled onchange="enableInputArea('comment_teacher_')">
                      <label class="form-check-label" for="comment_teacher_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="comment_teacher_moreText"></label>
                      <textarea class="form-control" name="comment_teacher_moreText" id="comment_teacher_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="comment_teacher_comment_3" disabled>
                      <label class="form-check-label" for="comment_teacher_comment_3" name="comment_teacher_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="comment_teacher_comment_4" disabled>
                      <label class="form-check-label" for="comment_teacher_comment_4" name="comment_teacher_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end ความคิดเห็นอาจารย์ที่ปรึกษา -->
          <!-- ใบแสดงผลการเรียน -->
          <div class="mb-3 mt-3">
            <h5 class="fw-bold text-light">ใบแสดงผลการเรียน</h5>
            <div class="d-flex flex-row justify-content-center">
              <iframe scrolling="no" src="{{asset('assets/pdf/ใบเกรด.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
            </div>
            <div class="card mt-3">
              <div class="card-body">
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_confirm_radio" value="true" checked onchange="enableCheckbox('gpa_')">
                      <label class="form-check-label" for="gpa_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gpa_confirm" id="gpa_to_edit" value="false" onchange="enableCheckbox('gpa_')">
                      <label class="form-check-label" for="gpa_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gpa_comment_1" disabled>
                      <label class="form-check-label" for="gpa_comment_1" name="gpa_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gpa_comment_2" disabled>
                      <label class="form-check-label" for="gpa_comment_2" name="gpa_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gpa_more_radio" disabled onchange="enableInputArea('gpa_')">
                      <label class="form-check-label" for="gpa_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="gpa_moreText"></label>
                      <textarea class="form-control" name="gpa_moreText" id="gpa_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gpa_comment_3" disabled>
                      <label class="form-check-label" for="gpa_comment_3" name="gpa_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gpa_comment_4" disabled>
                      <label class="form-check-label" for="gpa_comment_4" name="gpa_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end ใบแสดงผลการเรียน -->
        </div>
        <!-- end modal content -->
        <!-- modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">บันทึก</button>
        </div>
        <!-- end modal footer -->
        </div>
      </div>
    </div>
    <!-- End doc Modal -->
    <!-- edit Modal -->
    <div class="modal fade" id="verticalycentered" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">รายละอียดผู้กู้</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="edit-content">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          </div>
        </div>
      </div>
    </div><!-- End edit Modal-->

    <script>
      function showdocModal(borrowerId){
        // $("#doc-content").html('');
        // $("#doc-content").append(`<span>${borrowerId}</span>`);
        $("#doc-button"+borrowerId).click();
      }

      function enableCheckbox(roleName){
        const isDisabled = $(`:checkbox[id^=${roleName}]`).prop('disabled');
        $(`:checkbox[id^=${roleName}]`).prop('disabled', !isDisabled);
        if($(`#${roleName}confirm_radio`).prop('checked')){
          console.log('reset form');
          $(`:checkbox[id^=${roleName}]`).prop('checked', false);
          $(`#${roleName}moreText`).prop({'value':'','disabled':true});
        }
      }
      function enableInputArea(roleName){
        const isDisabled = $(`#${roleName}moreText`).prop('disabled');
        $(`#${roleName}moreText`).prop({'value':'','disabled': !isDisabled});
      }

      function showEditModal(borrowerId){
        fetch(`/new_loan_submission/to_edit/${borrowerId}`)
        .then(response => {
            // Check if the request was successful
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // Parse the response (assuming it's JSON in this example)
            return response.json();
        })
        .then(data => {
            // Do something with the data
            console.log(data.comment);
            $("#edit-content").html(`
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">ชื่อ</div>
                  <div class="col-sm-8">${data.name}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">ประเภทผู้กู้</div>
                  <div class="col-sm-8">${data.type}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">อายุ</div>
                  <div class="col-sm-8">${data.age}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">รหัสนักศึกษา</div>
                  <div class="col-sm-8">${data.id}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">คณะ</div>
                  <div class="col-sm-8">${data.faculty}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">สาขา</div>
                  <div class="col-sm-8">${data.major}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">ชั้นปีที่</div>
                  <div class="col-sm-8">${data.grade}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">โทรศัพท์</div>
                  <div class="col-sm-8">${data.tel}</div>
              </div>
              <div class="row mt-3 mb-3">
                  <div class="col-sm-4 label fw-bold text-secondary ">หมายเหตุ</div>
                  <div class="col-sm-8 text-danger">${
                    data.comment.map((obj)=>{
                      return obj.comname+': '+obj.comdescript+'<br>';
                    })
                  }</div>
              </div>
            `);
            $("#edit-button"+borrowerId).click();

        })
        .catch(error => {
            // Handle errors
            console.error('Fetch error:', error);
        });
      }
    </script>
@endsection