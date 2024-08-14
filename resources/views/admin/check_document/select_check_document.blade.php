@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
<style>
    .custom-dropdown-toggle {
        text-align: left;
        padding-left: 1rem;
        padding-right: 1.5rem;
        position: relative;
    }
    .custom-dropdown-toggle::after {
        position: absolute;
        right: 0.1rem;
        top: 50%;
        transform: translateY(-50%);
        border-top: 0.3em !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor'%3E%3Cpath d='M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .2rem center;
        background-size: 24px 30px;
        width: 100px;
        height: 100px;
    }
    .custom-button{
        border: 1px solid #ced4da;
        padding: .375rem 2.25rem .375rem .75rem;
        background-color: white;
        border-radius: 4px;
    }
    .dropdown-item:hover {
        background-color: #767676 !important;
        color: #ffffff !important;
        margin-top: 8px;
        margin-bottom: 8px;
  }
    .dropdown-item.active {
        background-color: #767676 !important;
        color: #ffffff;
        margin-top: 8px;
        margin-bottom: 8px;

  }
    .dropdown-item{
        border-radius: 10px;
  }
    .dropdown-menu{
        border-radius: 20px !important;
        padding-top: 0.1px !important;
        padding-bottom: 0.1px !important;
  }
</style>
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="dropdown pt-4">
                <button class="dropdown-toggle custom-dropdown-toggle custom-button col-12 col-md-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    สถานะเอกสาร
                </button>
                <ul class="dropdown-menu col-12 col-md-3" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item active" href="#tab1" onclick="showTab(event, '#tab1', 'สถานะเอกสาร')">สถานะเอกสาร</a></li>
                    <li><a class="dropdown-item" href="#tab2" onclick="showTab(event, '#tab2', 'Tab 2')">Tab 2</a></li>
                    <li><a class="dropdown-item" href="#tab3" onclick="showTab(event, '#tab3', 'Tab 3')">Tab 3</a></li>
                </ul>
            </div>
            <?php
                date_default_timezone_set("Asia/Bangkok");

                $loan_request = array(
                array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s")),
                array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s")),
                array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s")),
                array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s")),
                );
            ?>

            <div class="tab-content mt-3">

                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
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
                                  <th class="text-center"></th>
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
                                  <td>
                                    <a href="{{ url('/admin/check_document/check_documents') }}" class="btn btn-primary mt-4">ตรวจเอกสาร</a>
                                  </td>
                                </tr>
                                @endforeach

                              </tbody>
                            </table>
                          </div>
                          <!-- End Dark Table -->
                        </div>
                      </div>
                </div>

                <div class="tab-pane fade" id="tab2" role="tabpanel">
                    Content for Tab 2.
                </div>

                <div class="tab-pane fade" id="tab3" role="tabpanel">
                    Content for Tab 3.
                </div>

            </div>
        </div>
    </div>
    <script>
        function showTab(event, tabId, tabName) {
            event.preventDefault();

            var tabs = document.querySelectorAll('.tab-pane');
            tabs.forEach(function(tab) {
                tab.classList.remove('show', 'active');
            });

            var targetTab = document.querySelector(tabId);
            targetTab.classList.add('show', 'active');

            var dropdownButton = document.getElementById('dropdownMenuButton');
            dropdownButton.textContent = tabName;

            var dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(function(item) {
                item.classList.remove('active');
            });

            event.currentTarget.classList.add('active');
        }
    </script>
@endsection
