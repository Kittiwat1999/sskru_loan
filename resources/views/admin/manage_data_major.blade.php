@extends('layout')
@section('title','manage data')
@section('content')
    <section class="section dashboard">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">สาขาที่สังกัด {{$faculty->faculty_name}}</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-striped table-bordered" id="major-table">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($majors as $major)
                            <tr>
                                <td class="text-center">{{$major->id}}</td>
                                <td>{{$major->major_name}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#edit_major{{$major->id}}"><i class="bi bi-pencil-fill"></i></button>
                                        <button type="submit" class="btn btn-light w-25"  data-bs-toggle="modal" data-bs-target="#delete_major{{$major->id}}"><i class="bi bi-trash"></i></button>
                                    </div>
                                    <div class="modal fade" id="delete_major{{$major->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">ลบสาขา</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('admin.manage.data.delete.major',['major_id' => $major->id])}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div>ท่านต้องการลบสาขา <span class="text-danger">{{$major->major_name}}</span></div>
                                                        @method('DELETE')
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-secondary">ลบ</button>
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="edit_major{{$major->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">แก้ไขชื่อ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('admin.manage.data.edit.major',['major_id' => $major->id])}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="col-12">
                                                            <label for="major_name" class="form-label">ชื่อสาขา</label>
                                                            <input type="text" class="form-control need-custom-validate" id="major_name"  name="major_name" value="{{$major->major_name}}">
                                                            <div class="invalid-feedback">
                                                                กรุณากรอกชื่อสาขา
                                                            </div>
                                                        </div>
                                                        @method('PUT')
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addMajor">
                            + เพิ่มสาขา
                        </button>
                        <div class="modal fade" id="addMajor" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">เพิ่มสาขา</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admin.manage.data.add.major',['faculty_id' => $faculty->id])}}" method="post">
                                    <div class="modal-body">
                                            @csrf
                                            <div class="col-12">
                                                <label for="major_name" class="form-label">ชื่อสาขา</label>
                                                <input type="text" class="form-control need-custom-validate" id="major_name"  name="major_name">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกชื่อสาขา
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#major-table').DataTable({
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
