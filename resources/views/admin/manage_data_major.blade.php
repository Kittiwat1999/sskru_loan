@extends('layout')
@section('title','manage data')
@section('content')
    <section class="section dashboard">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">สาขา</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
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
                                        <button type="button" class="btn btn-primary w-25"><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light w-25"><i class="bi bi-trash"></i></button>
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
                            + เพิ่มสาขา
                          </button>
                    </div>
                    <div class="col-md-9"></div>
                </div>
            </div>
        </div>
    </section>
@endsection