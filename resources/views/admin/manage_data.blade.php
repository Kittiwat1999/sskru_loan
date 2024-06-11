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
                                <th class="text-center">คณะ</th>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">คณะศิลปศาสตร์และวิทยาศาสตร์</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger">จัดการข้อมูลสาขา</button>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
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
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">ลักษณะที่ 1</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                            <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
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
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">รายได้น้อย</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                            <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
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
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">ไม่มีเงินกินข้าว</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                            <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
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