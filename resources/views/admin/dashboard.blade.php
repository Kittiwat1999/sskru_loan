@extends('layout')
@section('title')
admin index
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">ตัวช่วยการค้นหา</h5>
            <form class="row" action="">
                <div class="col-md-3">
                    <label for="yearStadies" class="col-form-label text-secondary">ปีการศึกษา</label>
                    <select id="yearStadies" class="form-select" aria-label="Default select example" name="yearStadies">
                        <option disabled selected>ทั้งหมด</option>
                        <option value="1">2567</option>
                        <option value="2">2566</option>
                        <option value="3">2565</option>
                        <option value="4">2564</option>
                    </select>
                </div>
                <div class="col-md-3">
                  <label for="educationLevel" class="col-form-label text-secondary">ระดับการศึกษา</label>
                  <select id="educationLevel" class="form-select" aria-label="Default select example" name="educationLevel">
                      <option disabled selected>ทั้งหมด</option>
                      <option value="1">ปริญญาตรี</option>
                      <option value="2">ปริญญาโท</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="term" class="col-form-label text-secondary">ภาคเรียน</label>
                  <select id="term" class="form-select" aria-label="Default select example" name="term">
                      <option disabled selected>ทั้งหมด</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                  <select id="grade" class="form-select" aria-label="Default select example" name="grade">
                      <option selected value="*">ทั้งหมด</option>
                      <option value="1">1</option>
                      <option value="2">2</option></option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                  </select>
                </div>
              <label for="start_date" class="col-form-label text-secondary">วันที่ยื่นคำขอ</label>
              <div class="col-md-3">
                  <div class="input-group date" id="">
                      <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                      <input type="text" name="start_date" id="start_date" class="form-control need-custom-validate" placeholder="วว/ดด/ปปปป"/>
                  </div>
              </div>
              -
              <div class="col-md-3">
                <div class="input-group date" id="">
                  <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                  <input type="text" name="end_date" id="end_date" class="form-control need-custom-validate" placeholder="วว/ดด/ปปปป"/>
                </div>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-3">
                <label for="faculty" class="col-form-label text-secondary">คณะ</label>
                <select id="faculty" class="form-select" aria-label="Default select example" name="faculty">
                    <option disabled selected>ทั้งหมด</option>
                    <option value="1">ศิลปศาสตร์</option>
                    <option value="2">วิศวกรรมศาสตร์</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="major" class="col-form-label text-secondary">สาขา</label>
                <select id="major" class="form-select" aria-label="Default select example" name="major">
                    <option disabled selected>ทั้งหมด</option>
                    <option value="1">วิศวกรรมโยธา</option>
                    <option value="2">วิศวกรรมยาโธ</option>
                </select>
              </div>
              <div class="col-md-3">
                  <label for="course" class="col-form-label text-secondary">หลักสูตร</label>
                  <select id="course" class="form-select" aria-label="Default select example" name="course">
                      <option disabled selected>ทั้งหมด</option>
                      <option value="1">วิศวกรรมศาสตรบัณฑิต</option>
                      <option value="2">ครุศาสตรบัณฑิต</option>
                  </select>
              </div>
                <div class="text-end mt-3">
                <!-- reset Modal-->
                    <button type="reset" class="btn btn-secondary">ล้างค่า</button>
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
      <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 class="card-title">รายละเอียดคำขอกู้ยืมเงิน</h5>
            <button class="btn btn-primary mb-3 mt-3">ดาวน์โหลดรายชื่อ</button>
          </div>
          <div class="table-responsive mb-3">
              <table class="table table-striped" id="documents-table">
                  <thead>
                      <tr>
                          <th></th>
                          <th>วันที่ยื่นคำขอ</th>
                          <th>ชื่อ - นามสกุล</th>
                          <th>ระดับการศึกษา</th>
                          <th>ชั้นปี/ภาคเรียน</th>
                          <th>คณะ/สาขาวิชา</th>
                          <th>หลักสูตร/รหัสหลักสูตร</th>
                          <th>สถาะคำขอ/สถานะสัญญา</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $documents = array(
        
                        array('id'=>'1','date'=>'31 ก.ค. 2567','docID'=>'L2567004426100933','name'=>'นาย อาทิตย์ ศรีภา','studentID'=>'1-3396-00067-90-8','educationLevel'=>'ปริญญาตรี','grade'=>'ชั้นปีที่ 3','term'=>'ภาคเรียนที่ 1','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'วิทยาสตร์การกีฬา','course'=>'หลักสูตรวิทยาศาสตร์บัณฑิต สาขาวิชาวิทยาศาสตร์การกีฬา มหาวิทยาลัยราชภัฎศรีสะเกษ','courseID'=>'25571631100048','status'=>'อยู่ระหว่างการตรวจสอบ',),

                      );
                    ?>

                      @foreach($documents as $document)
                          <tr>
                              <td class="text-center">{{$document['id']}}</td>
                              <td>
                                <span>{{$document['date']}}</span><br>
                                <span class="text-secondary fw-lighter">{{$document['docID']}}</span>
                              </td>
                              <td>
                                <span>{{$document['name']}}</span><br>
                                <span class="text-secondary fw-lighter">{{$document['studentID']}}</span>
                              </td>
                              <td>{{$document['educationLevel']}}</td>
                              <td>
                                <span>{{$document['grade']}}</span><br>
                                <span class="text-secondary fw-lighter">{{$document['term']}}</span>
                              </td>
                              <td>
                                <span>{{$document['faculty']}}</span><br>
                                <span class="text-secondary fw-lighter">{{$document['major']}}</span>
                              </td>
                              <td>
                                <span>{{$document['course']}}</span><br>
                                <span class="text-secondary fw-lighter">{{$document['courseID']}}</span>
                              </td>
                              <td class="text-danger">{{$document['status']}}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        $.datetimepicker.setLocale('th'); 

        $('#start_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });

        $('#end_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });
      })
      $(document).ready(function() {
            $('#documents-table').DataTable({
                "language": {
                    "sProcessing": "กำลังประมวลผล...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "แรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "สุดท้าย"
                    }
                }
            });
      });
    </script>
@endsection
