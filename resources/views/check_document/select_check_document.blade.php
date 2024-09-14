@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            @php
                $sessionData = Session::get('check_document');
            @endphp
            
            <form class="row mb-3" action="{{route('check_document.select.status', ['document_id' => $document->id])}}" method="POST">
                @csrf
                <div class="col-md-4 my-3">
                    <label for="status" class="col-form-label text-secondary">สถานะเอกสาร</label>
                    <select id="status" class="form-select" aria-label="Default select example" name="status">
                        <option @selected($sessionData['select_status'] == 'wait-approve') value="wait-approve">รออนุมัติ</option>
                        <option @selected($sessionData['select_status'] == 'wait-teacher-approve') value="wait-teacher-approve">รออารจารย์ที่ปรึกษาให้ความเห็น</option>
                        <option @selected($sessionData['select_status'] == 'approved') value="approved">อนุมัติแล้ว</option>
                        <option @selected($sessionData['select_status'] == 'rejected') value="rejected">ต้องแก้ไข</option>
                        <option @selected($sessionData['select_status'] == 'response-reject') value="response-reject">แก้ไขแล้ว</option>
                        <option @selected($sessionData['select_status'] == 'sending') value="sending">ผู้กู้ยืมกำลังดำเนินการ</option>
                    </select>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                    <select id="faculty" class="form-select" aria-label="Default select example" name="faculty" onchange="getMajors(this.value)">
                        <option @selected($sessionData['select_faculty'] == 'all') value="all">ทั้งหมด</option>
                        @foreach($faculties as $faculty)
                            <option @selected($sessionData['select_faculty'] == $faculty->id) value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="borrower-type" class="col-form-label text-secondary">สาขา</label>
                    <select id="major" class="form-select" aria-label="Default select example" name="major">
                        <option @selected($sessionData['select_major'] == 'all') value="all">ทั้งหมด</option>
                        @foreach($majors as $major)
                            <option @selected($sessionData['select_major'] == $major->id) value="{{$major->id}}">{{$major->major_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                    <select id="grade" class="form-select" aria-label="Default select example" name="grade">
                        <option @selected($sessionData['select_grade'] == 'all') value="all">ทั้งหมด</option>
                        <option @selected($sessionData['select_grade'] == '1') value="1">1</option>
                        <option @selected($sessionData['select_grade'] == '2') value="2">2</option>
                        <option @selected($sessionData['select_grade'] == '3') value="3">3</option>
                        <option @selected($sessionData['select_grade'] == '4') value="4">4</option>
                        <option @selected($sessionData['select_grade'] == '5') value="5">5</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex flex-column justify-content-end">
                    <button type="submit" class="btn btn-primary">นำไปใช้</button>
                </div>

            </form>
            <div class="table-responsive">
                <!-- Dark Table -->
                <table id="borrower-documents-table" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ชื่อ-สกุล</th>
                            <th scope="col">คณะ-สาขา</th>
                            <th scope="col">วันที่ส่งเอกสาร</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                </table>
            </div>
                <!-- End Dark Table -->
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
            $('#borrower-documents-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('select_document.borrower_documents.get', ['document_id' => $document['id'] ]) }}",
                    type:'GET',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fullname', name: 'fullname' },
                    { data: 'information', name: 'information' },
                    { data: 'delivered_date', name: 'delivered_date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                buttons: [],
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
        });

        function getMajors(faculty_id){
            fetch(`{{url('/check_document/select_document/get-major-by-faculty-id/${faculty_id}')}}`)
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(majors => {
                // console.log(majors);
                const major_select = document.getElementById('major');
                major_select.innerHTML = '';
                var first_option = document.createElement('option');
                first_option.value = 'all';
                first_option.textContent = 'ทั้งหมด';
                major_select.appendChild(first_option);
                majors.forEach((major) => {
                    var newOption = document.createElement('option');
                    newOption.value = major.id;
                    newOption.textContent = major.major_name;
                    major_select.appendChild(newOption);
                });
            })
            .catch(error => {
                console.error('There was a problem with the fetch majors operation:', error);
            });
        }
</script>
@endsection
