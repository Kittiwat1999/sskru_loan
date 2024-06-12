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
                                        <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                        <button type="submit" class="btn btn-light w-25"  data-bs-toggle="modal" data-bs-target="#delete_faculty{{$faculty->id}}"><i class="bi bi-trash"></i></button>
                                    </div>
                                    <div class="modal fade" id="delete_faculty{{$faculty->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">ลบคณะ {{$faculty->faculty_name}}</h5>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100">
                            + เพิ่มคณะ
                          </button>
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
                                                <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                                <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
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
                        <button type="button" class="btn btn-outline-primary w-100">
                            + เพิ่มประเภทผู้กู้
                        </button>
                    </div>
                    <div class="col-md-9"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">คูณสมบัติผู้กู้</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th class="text-center">คูณสมบัติผู้กู้</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                            <tbody>
                                @foreach ($properties as $property)
                                <tr>
                                    <td class="text-center">{{$property->id}}</td>
                                    <td>{{$property->property_title}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                            <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
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
                        <button type="button" class="btn btn-outline-primary w-100">
                            + เพิ่มคูณสมบัติผู้กู้
                        </button>
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
                                            <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                            <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
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
                        <button type="button" class="btn btn-outline-primary w-100">
                            + เพิ่มเหตุผลจำเป็นของการกู้ยืม
                        </button>
                    </div>
                    <div class="col-md-9"></div>
                </div>
            </div>
        </div>
    
    </section>
@endsection