@extends('layout')
@section('title')
    teacher home
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการเอกสาร</h5>
                @php
                    $select_grade = Session::get('select_grade');
                    $select_status = Session::get('select_status');
                @endphp
                <form class="row mb-3" action="{{route('teacher.select.option')}}" method="POST">
                    @csrf
                    <div class="col-md-4 mb-3">
                        <span for="grade" class="col-form-label text-secondary">คณะ/วิทยาลัย: <span class="text-dark">{{$teacher->faculty_name}}</span></span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <span for="grade" class="col-form-label text-secondary">สาขาวิชา: <span class="text-dark">{{$teacher->major_name}}</span></span>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-1">
                        <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-3">
                        <select id="grade" name="select_grade" class="form-select" aria-label="Default select example" onchange="getUsersByGrade(this.value)">
                            <option @selected($select_grade == 'all') value="all">ทั้งหมด</option>
                            <option @selected($select_grade == '1') value="1">1</option>
                            <option @selected($select_grade == '2') value="2">2</option>
                            <option @selected($select_grade == '3') value="3">3</option>
                            <option @selected($select_grade == '4') value="4">4</option>
                            <option @selected($select_grade == '5') value="5">5</option>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <label for="inputNanme4" class="col-form-label">สถานะเอกสาร</label>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <select id="status" name="select_status" class="form-select" aria-label="Default select example">
                            <option @selected($select_status == 'wait-approve') value="wait-approve">รออนุมัติ</option>
                            <option @selected($select_status == 'rejected') value="rejected">ต้องแก้ไข</option>
                            <option @selected($select_status == 'response-reject') value="response-reject">แก้ไขแล้ว</option>
                            <option @selected($select_status == 'approved') value="approved">อนุมัติแล้ว</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <button type="submit" class="btn btn-primary w-100">นำไปใช้</button>
                    </div>
                </form>
                       
                <div class="table-responsive">
                    <table id="borrower-documents-table" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th scope="col">ชื่อ-สกุล</th>
                                <th scope="col">คณะ-สาขา</th>
                                <th scope="col">วันที่ส่งเอกสาร</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
        <!-- end card -->
    </section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
            $('#borrower-documents-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('teacher.get.borrower.document') }}",
                    type:'GET',
                },
                columns: [
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
</script>
@endsection

