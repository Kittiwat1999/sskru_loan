@extends('layout')
@section('title','manage data')
@section('content')
    <section class="section dashboard">

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">คณะ</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>คณะ</th>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faculties as $faculty)
                            <tr>
                                <td class="text-center">{{$faculty->id}}</td>
                                <td>{{$faculty->faculty_name}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.manage.data.major',['faculty_id' => $faculty->id])}}" type="button" class="btn btn-danger">จัดการข้อมูลสาขา</a>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#edit_faculty{{$faculty->id}}"><i class="bi bi-pencil-fill"></i></button>
                                        <button type="submit" class="btn btn-light w-25"  data-bs-toggle="modal" data-bs-target="#delete_faculty{{$faculty->id}}"><i class="bi bi-trash"></i></button>
                                    </div>
                                    <div class="modal fade" id="delete_faculty{{$faculty->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">ลบคณะ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('admin.manage.data.delete.faculty',['faculty_id' => $faculty->id])}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div>ท่านต้องการลบคณะ <span class="text-danger">{{$faculty->faculty_name}}</span></div>
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
                                    <div class="modal fade" id="edit_faculty{{$faculty->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">แก้ไขชื่อ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('admin.manage.data.edit.faculty',['faculty_id' => $faculty->id])}}" method="post">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="col-12">
                                                            <label for="faculty_name" class="form-label">ชื่อคณะ</label>
                                                            <input type="text" class="form-control need-custom-validate" id="faculty_name"  name="faculty_name" value="{{$faculty->faculty_name}}">
                                                            <div class="invalid-feedback">
                                                                กรุณากรอกชื่อคณะ
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
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addFaculty">
                            + เพิ่มคณะ
                        </button>
                        <div class="modal fade" id="addFaculty" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">เพิ่มคณะ</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admin.manage.data.add.faculty')}}" method="post">
                                    <div class="modal-body">
                                            @csrf
                                            <div class="col-12">
                                                <label for="faculty_name" class="form-label">ชื่อคณะ</label>
                                                <input type="text" class="form-control need-custom-validate" id="faculty_name"  name="faculty_name">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกชื่อคณะ
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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ประเภทผู้กู้</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th class="text-center">ประเภทผู้กู้</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                            <tbody>
                                @foreach ($borrowerapprearancetype as $apprearancetype)
                                    <tr>
                                        <td class="text-center">{{$apprearancetype->id}}</td>
                                        <td>{{$apprearancetype->title}}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#edit_apprearancetype{{$apprearancetype->id}}"><i class="bi bi-pencil-fill"></i></button>
                                                <button type="submit" class="btn btn-light w-25"  data-bs-toggle="modal" data-bs-target="#delete_apprearancetype{{$apprearancetype->id}}"><i class="bi bi-trash"></i></button>
                                            </div>
                                            <div class="modal fade" id="delete_apprearancetype{{$apprearancetype->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">ลบประเภทผู้กู้</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{route('admin.manage.data.delete.apprearancetype',['apprearancetype_id' => $apprearancetype->id])}}" method="post">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <div>ท่านต้องการลบ <span class="text-danger">{{$apprearancetype->title}}</span></div>
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
                                            <div class="modal fade" id="edit_apprearancetype{{$apprearancetype->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">แก้ไขประเภทผู้กู้ {{$apprearancetype->apprearancetype_title}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{route('admin.manage.data.edit.apprearancetype',['apprearancetype_id' => $apprearancetype->id])}}" method="post">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <div class="col-12">
                                                                    <label for="apprearancetype_title" class="form-label">ประเภทผู้กู้</label>
                                                                    <input type="text" class="form-control need-custom-validate" id="apprearancetype_title"  name="apprearancetype_title" value="{{$apprearancetype->title}}">
                                                                    <div class="invalid-feedback">
                                                                        กรุณากรอกประเภทผู้กู้
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
                        </thead>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addApprearancetype">
                            + เพิ่มประเภทผู้กู้
                        </button>
                        <div class="modal fade" id="addApprearancetype" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">เพิ่มประเภทผู้กู้</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admin.manage.data.add.apprearancetype')}}" method="post">
                                    <div class="modal-body">
                                            @csrf
                                            <div class="col-12">
                                                <label for="apprearancetype_title" class="form-label">ประเภทผู้กู้</label>
                                                <input type="text" class="form-control need-custom-validate" id="apprearancetype_title"  name="apprearancetype_title">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกประเภทผู้กู้
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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">คุณสมบัติผู้กู้</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th class="text-center">คุณสมบัติผู้กู้</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                            <tbody>
                                @foreach ($properties as $property)
                                <tr>
                                    <td class="text-center">{{$property->id}}</td>
                                    <td>{{$property->property_title}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#edit_property{{$property->id}}"><i class="bi bi-pencil-fill"></i></button>
                                            <button type="submit" class="btn btn-light w-25"  data-bs-toggle="modal" data-bs-target="#delete_property{{$property->id}}"><i class="bi bi-trash"></i></button>
                                        </div>
                                        <div class="modal fade" id="delete_property{{$property->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">ลบคุณสมบัติผู้กู้</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{route('admin.manage.data.delete.property',['property_id' => $property->id])}}" method="post">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div>ท่านต้องการลบ <span class="text-danger">{{$property->property_title}}</span></div>
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
                                        <div class="modal fade" id="edit_property{{$property->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ไขคุณสมบัติผู้กู้</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{route('admin.manage.data.edit.property',['property_id' => $property->id])}}" method="post">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div class="col-12">
                                                                <label for="property_title" class="form-label">คุณสมบัติผู้กู้</label>
                                                                <input type="text" class="form-control need-custom-validate" id="property_title"  name="property_title" value="{{$property->property_title}}">
                                                                <div class="invalid-feedback">
                                                                    กรุณากรอกคุณสมบัติผู้กู้
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
                        </thead>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addProperty">
                            + เพิ่มคุณสมบัติผู้กู้
                        </button>
                        <div class="modal fade" id="addProperty" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">เพิ่มคุณสมบัติผู้กู้</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admin.manage.data.add.property')}}" method="post">
                                    <div class="modal-body">
                                            @csrf
                                            <div class="col-12">
                                                <label for="property_title" class="form-label">คุณสมบัติผู้กู้</label>
                                                <input type="text" class="form-control need-custom-validate" id="property_title"  name="property_title">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกคุณสมบัติผู้กู้
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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">เหตุผลจำเป็นของการกู้ยืม</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th class="text-center">เหตุผลจำเป็นของการกู้ยืม</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                            <tbody>
                                @foreach ($nessessities as $nessessity)
                                <tr>
                                    <td class="text-center">{{$nessessity->id}}</td>
                                    <td>{{$nessessity->nessessity_title}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#edit_nessessity{{$nessessity->id}}"><i class="bi bi-pencil-fill"></i></button>
                                            <button type="submit" class="btn btn-light w-25"  data-bs-toggle="modal" data-bs-target="#delete_nessessity{{$nessessity->id}}"><i class="bi bi-trash"></i></button>
                                        </div>
                                        <div class="modal fade" id="delete_nessessity{{$nessessity->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">ลบเหตุผลจำเป็นของการกู้ยืม</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{route('admin.manage.data.delete.nessessity',['nessessity_id' => $nessessity->id])}}" method="post">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div>ท่านต้องการลบ <span class="text-danger">{{$nessessity->nessessity_title}}</span></div>
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
                                        <div class="modal fade" id="edit_nessessity{{$nessessity->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ไขเหตุผลจำเป็นของการกู้ยืม</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{route('admin.manage.data.edit.nessessity',['nessessity_id' => $nessessity->id])}}" method="post">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div class="col-12">
                                                                <label for="nessessity_title" class="form-label">เหตุผลจำเป็นของการกู้ยืม</label>
                                                                <input type="text" class="form-control need-custom-validate" id="nessessity_title"  name="nessessity_title" value="{{$nessessity->nessessity_title}}">
                                                                <div class="invalid-feedback">
                                                                    กรุณากรอกเหตุผลจำเป็นของการกู้ยืม
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
                        </thead>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addNessessity">
                            + เพิ่มเหตุผลจำเป็นของการกู้ยืม
                        </button>
                        <div class="modal fade" id="addNessessity" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">เพิ่มเหตุผลจำเป็นของการกู้ยืม</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('admin.manage.data.add.nessessity')}}" method="post">
                                    <div class="modal-body">
                                            @csrf
                                            <div class="col-12">
                                                <label for="nessessity_title" class="form-label">เหตุผลจำเป็นของการกู้ยืม</label>
                                                <input type="text" class="form-control need-custom-validate" id="nessessity_title"  name="nessessity_title">
                                                <div class="invalid-feedback">
                                                    กรุณากรอกเหตุผลจำเป็นของการกู้ยืม
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
