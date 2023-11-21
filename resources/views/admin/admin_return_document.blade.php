@extends('admin_layout')
@section('title')
คำร้องขอแก้ใขข้อมูล
@endsection
@section('content')
    
    <section class="section dashboard">
        <div class="card">
            <div class="card-body pt-3">
                <!-- <h5 class="card-title">title</h5> -->
                <!-- loan_list Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="return-document-tab" data-bs-toggle="tab" data-bs-target="#return-document" type="button" role="tab" aria-controls="return-document" aria-selected="true">รายการขอแก้ใขเอกสาร</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approve-tab" data-bs-toggle="tab" data-bs-target="#approve" type="button" role="tab" aria-controls="approve" aria-selected="true">อนุมัติแล้ว</button>
                    </li>
                </ul>
                <?php 
                  $loan_request = array(
                    array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y/m/d"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน'),'data'=>'แบบยืนยันการเบิกเงิน'),
                    array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y/m/d"),'comment'=>array('สำเนาบัตรผู้ปกครอง'=>'เอกสารไม่ชัดเจน','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน'),'data'=>'แบบคำขอกู้ยืม'),
                    array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y/m/d"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','ใบรายงานผลการเรียน'=>'เอกสารไม่ชัดเจน'),'data'=>'แบบยืนยันการเบิกเงิน'),
                    array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y/m/d"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน','สำเนาบัตรผู้แทน'=>'เอกสารไม่ชัดเจน'),'data'=>'แบบยืนยันการเบอกเงิน')
                  );
                ?>
                <div class="tab-content pt-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="return-document" role="tabpanel" aria-labelledby="return-document-tab">
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
                                  <th scope="col">เอกสารที่ต้องการแก้ใข</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr onclick="showModal({{$borrower['id']}})">
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td>
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                                    <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                                  </td>
                                  <td>{{$borrower['data']}}</td>
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
                                  <th scope="col">เอกสารที่ต้องการแก้ใข</th>
                                  <th scope="col">ผู้อนุมัติ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $i = 1?>
                                @foreach($loan_request as $borrower)
                                <tr onclick="showModal({{$borrower['id']}})">
                                  <td>{{ $i++ }}</td>
                                  <td>{{$borrower['id']}}</td>
                                  <td>
                                    <span>{{$borrower['name']}}</span><br>
                                    <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                                    <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                                    <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                                  </td>
                                  <td>{{$borrower['data']}}</td>
                                  <td>{{$borrower['ckeker_name']}}</td>
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
                </div><!-- End loan_list Tabs -->
            </div>
        </div>
    </section>
    <!-- Extra Large Modal-->
    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Extra Large Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-content">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
      </div>
    </div>
        <!-- End Extra Large Modal -->
    <script>
      async function showModal(borrowerId)
          {
              const modalContent = document.getElementById('modal-content');
              modalContent.innerHTML = borrowerId;
              const modalButton = document.getElementById("button"+borrowerId);
              modalButton.click();
          }
    </script>
@endsection