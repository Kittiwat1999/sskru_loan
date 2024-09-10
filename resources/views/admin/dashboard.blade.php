@extends('layout')
@section('title')
dashboard
@endsection
@section('content')
    <div class="card mb-3">
      @php
        $sessionData = Session::get('dashboard_data');
      @endphp
        <div class="card-body">
          <h5 class="card-title">ตัวช่วยการค้นหา</h5>
            <form id="dashbord-form" class="row" action="{{route('admin.dashboard.set-data')}}" method="POST">
              @csrf
                <div class="col-md-8">
                    <label for="doc_type" class="col-form-label text-secondary">เอกสาร</label>
                    <select class="form-select" name="doc_type" id="doc_type">
                      @foreach($doc_types as $doc_type)
                        <option @selected($sessionData['doc_type'] == $doc_type['id']) value="{{$doc_type['id']}}">{{$doc_type['doctype_title']}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      กรุณาเลือกเอกสาร
                    </div>
                </div>
                <div class="col-md-4">
                  <label for="status" class="col-form-label text-secondary">สถานะเอกสาร</label>
                    <select id="status" class="form-select" aria-label="Default select example" name="status">
                        <option @selected($sessionData['status'] == 'wait-approve') value="wait-approve">รออนุมัติ</option>
                        <option @selected($sessionData['status'] == 'wait-teacher-approve') value="wait-teacher-approve">รออารจารย์ที่ปรึกษาให้ความเห็น</option>
                        <option @selected($sessionData['status'] == 'approved') value="approved">อนุมัติแล้ว</option>
                        <option @selected($sessionData['status'] == 'rejected') value="rejected">ต้องแก้ไข</option>
                        <option @selected($sessionData['status'] == 'response-reject') value="response-reject">แก้ไขแล้ว</option>
                        <option @selected($sessionData['status'] == 'sending') value="sending">ผู้กู้ยืมกำลังดำเนินการ</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="col-form-label text-secondary">ปีการศึกษา</label>
                    <input type="number" name="year" id="year" class="form-control" value="{{$sessionData['year']}}">
                    <div class="invalid-feedback">
                      กรุณากรอก ปีการศึกษา
                    </div>
                </div>
                <div class="col-md-4">
                  <label for="term" class="col-form-label text-secondary">ภาคเรียน</label>
                  <select id="term" class="form-select" aria-label="Default select example" name="term">
                    <option @selected($sessionData['term'] == '1') value="1">1</option>
                    <option @selected($sessionData['term'] == '2') value="2">2</option>
                    <option @selected($sessionData['term'] == '3') value="3">3</option>
                  </select>
                  <div class="invalid-feedback">
                    กรุณาเลือกภาคเรียน
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                  <select id="grade" class="form-select" aria-label="Default select example" name="grade">
                      <option @selected($sessionData['grade'] == '*') value="*">ทั้งหมด</option>
                      <option @selected($sessionData['grade'] == '1') value="1">1</option>
                      <option @selected($sessionData['grade'] == '2') value="2">2</option>
                      <option @selected($sessionData['grade'] == '3') value="3">3</option>
                      <option @selected($sessionData['grade'] == '4') value="4">4</option>
                      <option @selected($sessionData['grade'] == '5') value="5">5</option>
                  </select>
                </div>
              <label for="" class="col-form-label text-secondary">วันที่ยื่นคำขอ</label>
              <div class="col-md-4">
                  <div class="input-group date" id="">
                      <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                      <input type="text" name="start_date" id="start_date" class="form-control need-custom-validate" placeholder="วว/ดด/ปปปป" value="{{$sessionData['start_date'] != null ? $sessionData['start_date'] : '' }}" />
                  </div>
              </div>
              -
              <div class="col-md-4">
                <div class="input-group date" id="">
                  <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                  <input type="text" name="end_date" id="end_date" class="form-control need-custom-validate" placeholder="วว/ดด/ปปปป" value="{{$sessionData['end_date'] != null ? $sessionData['end_date'] : '' }}" />
                </div>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-4">
                <label for="faculty" class="col-form-label text-secondary">คณะ</label>
                <select id="faculty" class="form-select" aria-label="Default select example" name="faculty" onchange="getMajorByFacultyId(this.value)">
                    <option selected value="*">ทั้งหมด</option>
                    @foreach($faculties as $faculty)
                    <option @selected($sessionData['faculty'] == $faculty['id']) value="{{$faculty['id']}}">{{$faculty['faculty_name']}}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label for="major" class="col-form-label text-secondary">สาขา</label>
                <select id="major" class="form-select" aria-label="Default select example" name="major">
                    <option selected value="*" >ทั้งหมด</option>
                    @foreach($majors as $major)
                    <option @selected($sessionData['major'] == $major['id']) value="{{$major['id']}}">{{$major['major_name']}}</option>
                    @endforeach
                </select>
              </div>
                <div class="text-end mt-3">
                <!-- reset Modal-->
                    <button type="reset" class="btn btn-outline-primary">ล้างค่า</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm('dashbord-form')">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
      <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 class="card-title">รายละเอียดคำขอกู้ยืมเงิน</h5>
            <a href="{{url('/admin/dashboard/get-xcel')}}" class="btn btn-outline-primary mb-3 mt-3">ดาวน์โหลดรายชื่อ</a>
          </div>
          <div class="table-responsive mb-3">
              <table id="my-table" class="table table-striped w-100">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>วันที่ยื่นคำขอ</th>
                          <th>ชื่อ - นามสกุล</th>
                          <th>ระดับการศึกษา</th>
                          <th>ชั้นปี/ภาคเรียน</th>
                          <th>คณะ/สาขาวิชา</th>
                          <th>สถาะคำขอ/สถานะสัญญา</th>
                      </tr>
                  </thead>
              </table>
          </div>
      </div>
    </div>
@endsection
@section('script')
<script>
  termInput();
  function getMajorByFacultyId(faculty_id){
    fetch(`{{url('/admin/dashboard/${faculty_id}/get-major/')}}`)
    .then(response => {
        if (!response.ok) {
        throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(majors => {
        var major_element = document.getElementById('major');
        major_element.innerHTML = `<option selected disabled value="admin">ทั้งหมด</option>`;
        majors.forEach((major) => {
            var option = document.createElement('option');
            option.value = major.id;
            option.innerText = major.major_name;
            major_element.appendChild(option);
        })
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
  }

  function termInput(){
    const d = new Date();
    var year = d.getFullYear();
    const input_year = document.getElementById('year');
    input_year.value = year + 543;
  }

  function submitForm(form_id){
    var validation = validateForm(form_id);
    const form = document.getElementById(form_id);
    if(validation){
      form.submit();
    }
  }

  function validateForm(form_id){
    const form = document.getElementById(form_id);
    const input_doctype = form.querySelector('#doc_type');
    var validator = true;

    if(input_doctype.value == ""){
      validator = false;
      var invalid_element = input_doctype.nextElementSibling;
      if(invalid_element)invalid_element.classList.add('d-inline');
    }else{
      var invalid_element = input_doctype.nextElementSibling;
      if(invalid_element)invalid_element.classList.remove('d-inline');
    }

    return validator;
  }

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

    $('#my-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:"{{ url('/admin/dashboard/get-data') }}",
              type:'GET',
          },
          columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              { data: 'delivered_date', name: 'delivered_date' },
              { data: 'fullname', name: 'fullname' },
              { data: 'education', name: 'education' },
              { data: 'grade_term', name: 'grade_term' },
              { data: 'faculty_major', name: 'faculty_major' },
              { data: 'status', name: 'status'},
          ],
          responsive: true,
          language: {
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

  })

</script>
@endsection
