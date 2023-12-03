@extends('layout')
@section('title')
รายการขอกู้ยืมเกินหลักสูตร
@endsection
@section('content')
    
    <section class="section dashboard">
        <div class="card">
            <div class="card-body pt-3">
                <!-- <h5 class="card-title">title</h5> -->
                <!-- loan_list Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="over-course-tab" data-bs-toggle="tab" data-bs-target="#over-course" type="button" role="tab" aria-controls="over-course" aria-selected="true">รายการคำขอกู้เกินหลักสูตร</button>
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
                </ul>
                <?php 
                  date_default_timezone_set("Asia/Bangkok");
                  $loan_request = array(
                    array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24'),
                    array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23'),
                    array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21'),
                    array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน'],['comname'=>'ใบแสดงผลการเรียน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21'),
                  );
                ?>
                <div class="tab-content pt-2" id="myTabContent">
                  <!-- รายการยื่นกู้ -->
                  <div class="tab-pane fade pt-3 show active" id="over-course" role="tabpanel" aria-labelledby="over-course-tab">
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
                                  <th scope="col">วันที่ส่ง</th>
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
                  <!-- รายการยื่นกู้รอแก้ใข -->
                  <div class="tab-pane fade" id="wait-for-edit" role="tabpanel" aria-labelledby="wait-for-edit-tab">
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
                                  <th scope="col">วันที่ตีกลับ</th>
                                  <th scope="col">หมายเหตุ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr onclick="showEditModal({{$borrower['id']}})">
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
                                   @foreach($borrower['comment'] as $comment)
                                     <span class="text-danger">{{$comment['comname']}} : {{$comment['comdescript']}}</span><br>
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
                  <!-- end รายการยื่นกู้รอแก้ใข -->
                  <!-- รายการยื่นกู้แก้ใขแล้ว -->
                  <div class="tab-pane fade" id="finished-editing" role="tabpanel" aria-labelledby="finished-editing-tab">
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
                                  @foreach($borrower['comment'] as $comment)
                                     <span class="text-success">{{$comment['comname']}} : {{$comment['comdescript']}}</span><br>
                                   @endforeach
                                  </td>
                                  <button id="doc-button{{$borrower['id']}}" type="button" class="d-none btn btn-primary" data-bs-toggle="modal" data-bs-target="#docModal">
                                    Vertically centered
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
                  <!-- end รายการยื่นกู้แก้ใขแล้ว -->
                  <!-- รายการยื่นกู้ตรวจแล้ว -->
                  <div class="tab-pane fade" id="approve" role="tabpanel" aria-labelledby="approve-tab">
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
                                  <th scope="col">ผู้อนุมัติ</th>
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
                                  <td><span class="text-secondary fw-light">{{$borrower['ckeker_name']}}</span></td>
                                  <button id="button{{$borrower['id'];}}" style="display:none;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                                    Extra Large Modal
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
                  <!-- end รายการยื่นกู้ตรวจแล้ว -->
                </div><!-- End loan_list Tabs -->
            </div>
        </div>
    </section>
    <!-- doc Modal-->
    <div class="modal fade" id="docModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title">เอกสารคำขอกู้เกินหลักสูตร</h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><I class="bi bi-x-lg"></I></button>
        </div>
        <!-- modal content -->
        <div class="modal-body" id="doc-content">
            <!-- เอกสารคำขอกู้เกินหลักสูตร -->
            <div class="card">
              <div class="card-body">
                <h5 class="fw-bold my-3">เอกสารคำขอกู้เกินหลักสูตร</h5>
                <div class="d-flex flex-row justify-content-center">
                  <iframe  src="{{asset('assets/pdf/ขอกู้ยืมเกินหลักสูตร.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
                </div>
                <fieldset class="row mb-3 mt-3">
                  <legend class="col-form-label col-sm-2 pt-0 fw-bold">ให้ความเห็น</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="over_course_confirm" id="over_course_confirm_radio" value="true" checked onchange="enableCheckbox('over_course_')">
                      <label class="form-check-label" for="over_course_confirm_radio">
                        เอกสารถูกต้อง
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="over_course_confirm" id="over_course_to_edit" value="false" onchange="enableCheckbox('over_course_')">
                      <label class="form-check-label" for="over_course_to_edit">
                        เอกสารไม่ถูกต้อง
                      </label>
                    </div>
                  </div>
                </fieldset>
                <div class="row mb-3 mt-2 text-dark text-start">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="over_course_comment_1" disabled>
                      <label class="form-check-label" for="over_course_comment_1" name="over_course_comment_1">
                        เอกสารไม่ชัดเจน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="over_course_comment_2" disabled>
                      <label class="form-check-label" for="over_course_comment_2" name="over_course_comment_2">
                        บัตรประชาชนหมดอายุ
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="over_course_more_radio" disabled onchange="enableInputArea('over_course_')">
                      <label class="form-check-label" for="over_course_more_radio" >
                        อื่นๆ
                      </label>
                    </div>
                    <div class="input-group">
                      <label for="over_course_moreText"></label>
                      <textarea class="form-control" name="over_course_moreText" id="over_course_moreText" cols="30" rows="4" disabled></textarea>
                    </div>
                  </div>
                  <div class="col-sm-5">
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="over_course_comment_3" disabled>
                      <label class="form-check-label" for="over_course_comment_3" name="over_course_comment_3">
                        ลายมือชื่อในเอกสารกับสำเนาบัตรไม่ตรงกัน
                      </label>
                    </div>
  
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="over_course_comment_4" disabled>
                      <label class="form-check-label" for="over_course_comment_4" name="over_course_comment_4">
                        สำเนาบัตรประชาชนไม่ถูกต้อง
                      </label>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          <!-- end เอกสารคำขอกู้เกินหลักสูตร -->

          <!-- สำเนาบัตรผู้กู้ -->
          <div class="card">
            <div class="card-body">
              <h5 class="fw-bold my-3">สำเนาบัตรผู้กู้</h5>
              <div class="d-flex flex-row justify-content-center">
                <iframe  src="{{asset('assets/pdf/ยินยอมให้เปิดเผยข้อมูล.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
              </div>
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
          <!-- end สำเนาบัตรผู้กู้ -->
          <!-- บันทึกกิจกรรมจิตอาสา -->
          <div class="card">
            <div class="card-body">
              <h5 class="fw-bold my-3">บันทึกกิจกรรมจิตอาสา</h5>
              <div class="d-flex flex-row justify-content-center">
                <iframe  src="{{asset('assets/pdf/กิจกรรม.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
              </div>
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
          <!-- end บันทึกกิจกรรมจิตอาสา -->
          <!-- ใบแสดงผลการเรียน -->
          <div class="card">
            <div class="card-body">
              <h5 class="fw-bold my-3">ใบแสดงผลการเรียน</h5>
              <div class="d-flex flex-row justify-content-center">
                <iframe  src="{{asset('assets/pdf/ใบเกรด.pdf#zoom=100')}}" width="100%" height="1500" ></iframe>
              </div>
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
        fetch(`/over_course/to_edit/${borrowerId}`)
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