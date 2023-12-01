@extends('layout')
@section('title')
blank page
@endsection
@section('content')
    <section>
        <div class="card pt-3">
            <div class="card-body">
                <div class="row">
                <div class="container-fluid align-items-center p-0 m-0">
                    <div class="d-flex justify-content-around p-0 m-0">
                        <div class="d-flex flex-column">
                                <div class="text-center mb-1">
                                    <button
                                        class="btn bg-primary text-white btn-sm rounded-pill"
                                        style="width: 2rem; height: 2rem"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#company3"
                                        aria-expanded="false"
                                        aria-controls="company3"
                                        onclick="stepFunction(event)"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                                <small class="text-primary text-center text-progress-step fw-bold">กรอกข้อมูล</small>
                            </div>
                            <span
                                class="bg-secondary w-25 rounded mt-auto mb-auto me-1 ms-1"
                                style="height: 0.2rem"
                            >
                            </span>
                            <div class="d-flex flex-column">
                                <div class="text-center  mb-1">
                                    <button
                                        class="btn bg-secondary text-white btn-sm rounded-pill"
                                        style="width: 2rem; height: 2rem"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#company3"
                                        aria-expanded="false"
                                        aria-controls="company3"
                                        onclick="stepFunction(event)"
                                    >
                                        <i class="bi bi-file-earmark-check"></i>
                                    </button>
                                </div>
                                <small class="text-secondary text-center text-progress-step fw-bold">ส่งเอกสาร</small>
                            </div>
                            <span
                                class="bg-secondary w-25 rounded mt-auto mb-auto me-1 ms-1"
                                style="height: 0.2rem"
                            >
                            </span>
                            <div class="d-flex flex-column">
                                <div class="text-center  mb-1">
                                    <button
                                        class="btn bg-secondary text-white btn-sm rounded-pill"
                                        style="width: 2rem; height: 2rem"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#company3"
                                        aria-expanded="false"
                                        aria-controls="company3"
                                        onclick="stepFunction(event)"
                                    >
                                        <i class="bi bi-hourglass"></i>
                                    </button>
                                </div>
                                <small class="text-secondary text-center text-progress-step fw-bold">รออนุมัติ</small>
                            </div>
                            
                            <span
                                class="bg-secondary w-25 rounded mt-auto mb-auto me-1 ms-1"
                                style="height: 0.2rem"
                            >
                            </span>
                            <div class="d-flex flex-column">
                                <div class="text-center  mb-1">
                                    <button
                                        class="btn bg-secondary text-white btn-sm rounded-pill"
                                        style="width: 2rem; height: 2rem"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#company3"
                                        aria-expanded="false"
                                        aria-controls="company3"
                                        onclick="stepFunction(event)"
                                    >
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </div>
                                <small class="text-secondary text-center text-progress-step fw-bold">อนุมัติแล้ว</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

