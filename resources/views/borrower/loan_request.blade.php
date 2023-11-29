@extends('layout')
@section('title')
index borrower
@endsection
@section('content')
    
    <section class="section dashboard">

            <!-- start card toggle -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">กรอกข้อมูล</h5>

          <ul class="nav nav-tabs" id="borderedTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="borrower-information-tab" data-bs-toggle="tab" data-bs-target="#borrower-information" type="button" role="tab" aria-controls="borrower-information" aria-selected="true">ข้อมูลผู้กู้</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="parent-information-tab" data-bs-toggle="tab" data-bs-target="#parent-information" type="button" role="tab" aria-controls="parent-information" aria-selected="false">ข้อมูลผู้ปกครอง</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="representative-tab" data-bs-toggle="tab" data-bs-target="#representative" type="button" role="tab" aria-controls="representative" aria-selected="false">ผู้แทนโดยชอบธรรม</button>
            </li>
          </ul>
          <!-- toggle content -->
          <div class="tab-content" id="borderedTabContent">
            <!-- borrower information toggle -->
            <div class="tab-pane fade show active" id="borrower-information" role="tabpanel" aria-labelledby="borrower-information-tab">
              @include('borrower/loan_request/borrower_inform')
            </div>
            <!-- end borrower information toggle -->
            <!-- parent information toggle -->
            <div class="tab-pane fade" id="parent-information" role="tabpanel" aria-labelledby="parent-information-tab">
              @include('borrower/loan_request/parent_inform')
            </div>
            <!-- end parent information toggle -->

            <div class="tab-pane fade" id="representative" role="tabpanel" aria-labelledby="representative-tab">
              
              <form class="row">
                @csrf
                <div class="col-md-3 mt-2">
                  <label for="grade" class="col-md-12 col-form-label text-secondary">เลือกผู้แทนโดยชอบธรรม</label>
                  <select id="grade" name="grade" class="form-select" aria-label="Default select example">
                      <option selected>เลือกผู้แทน</option>
                      <option value="1">บิดา (นายไกรวุฒิ จตุรอาชานันท์)</option>
                      <option value="2">มารดา (นางสณัญญา จตุรอาชานันท์)</option>
                  </select>
                </div>

                <div class="col-md-11 line-section mt-4 mb-4"></div>
                <h6 class="text-primary mb-4">ข้อมูลที่อยู่ของผู้แทนโดยชอบธรรม</h6>

                <div class="col-md-5 mt-3 mb-3">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="prop1">
                      <label class="form-check-label" for="prop1">
                      ที่อยู่เดียวกันกับผู้กู้
                      </label>
                  </div>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <label for="village" class="form-label text-secondary">หมู่บ้าน</label>
                    <input type="text" class="form-control" id="village" name="village">
                </div>

                <div class="col-md-3">
                    <label for="houseNo" class="form-label text-secondary">บ้านเลขที่</label>
                    <input type="text" class="form-control" id="houseNo" name="houseNo">
                </div>

                <div class="col-md-3">
                    <label for="villageNo" class="form-label text-secondary">หมู่ที่</label>
                    <input type="text" class="form-control" id="villageNo" name="villageNo">
                </div>

                <div class="col-md-5">
                    <label for="street" class="form-label text-secondary">ซอย</label>
                    <input type="text" class="form-control" id="street" name="street">
                </div>

                <div class="col-md-5">
                    <label for="road" class="form-label text-secondary">ถนน</label>
                    <input type="text" class="form-control" id="road" name="road">
                </div>

                <div class="col-md-5">
                    <label for="city" class="col-md-12 col-form-label text-secondary">จังหวัด</label>
                    <select id="city" name="city" class="form-select" aria-label="Default select example">
                        <option selected>เลือกจังหวัด</option>
                        <option value="1">1</option>
                    </select>
                </div>

                <div class="col-md-5">
                <label for="district" class="col-md-12 col-form-label text-secondary">อำเภอ</label>
                <select disabled id="district" name="district" class="form-select" aria-label="Default select example">
                    <option selected>เลือกอำเภอ</option>
                    <option value="1">1</option>
                </select>
                </div>

                <div class="col-md-5">
                <label for="subDistrict" class="col-md-12 col-form-label text-secondary">ตำบล</label>
                <select disabled id="subDistrict" name="subDistrict" class="form-select" aria-label="Default select example">
                    <option selected>เลือกตำบล</option>
                    <option value="1">1</option>
                </select>
                </div>

                <div class="col-md-7"></div>


                <div class="col-md-3 mt-3">
                    <label for="postcode" class="form-label text-secondary">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control" id="postcode" name="postcode">
                </div>

                <div class="col-md-9"></div>

                <div class="text-end">
                  <!-- reset Modal-->
                  <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#parant-reset-modal">
                      reset
                  </button>
                  <div class="modal fade" id="parant-reset-modal" tabindex="-1">
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

          </div>
          <!-- end toggle content -->

        </div>
        <!-- end card body -->

      </div>
      <!-- end card toggle -->

    </section>

    <script>
      function ageCal(role){
        var inputBirthday = document.getElementById(role+'_birthday');
        // Get the input value
        var birthDate = inputBirthday.value;

        // Parse the selected date
        var selectedDate = new Date(birthDate);

        // Calculate the current date
        var currentDate = new Date();

        // Calculate the age
        var age = currentDate.getFullYear() - selectedDate.getFullYear();

        // Check if the birthday has already occurred this year
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }
        if(age<0){
          document.getElementById(role+'_age').value = "สวัสดีผู้มาจากอนาคต";
        }else{
          document.getElementById(role+'_age').value = age;
          if(age>=20){
            document.getElementById('representative-tab').disabled = true;
          }else{
            document.getElementById('representative-tab').disabled = false;

          }
        }

      }

        var idCardNumber = document.getElementById('idCardNumber');
        idCardNumber.onkeyup = () =>{
          document.getElementById('formattedNumber').innerHTML = idCardNumber.value;
          }
        
        var moreProps = document.getElementById('morePropCheck');
        moreProps.onchange = () => {
          const isdisabled = document.getElementById('moreProp').disabled;
          document.getElementById('moreProp').disabled = !isdisabled;
        }
      function nextPgae(page){
        console.log(page);
        document.getElementById(page).click();
      }
    </script>
@endsection
