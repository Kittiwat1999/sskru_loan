@extends('layout')
@section('title')
index loanrequest
@endsection
@section('content')
<section class="content">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function(){
                document.getElementById('alert').style.display = 'none';
            }, 3000); // Timeout in milliseconds (e.g., 5000 milliseconds = 5 seconds)
        </script>
    @endif
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">เพิ่มเอกสารคำขอกู้ยืมรายเก่า</h5>
            <form action="{{route('add.oldloan.request')}}" method="POST" class="row">
                @csrf
                <div class="col-md-5 my-2">
                    <select class="form-select" id="year-select" name="year" aria-label="select-year" onchange="yearSelected()">
                        <option disabled selected value="">เลือกปีการศึกษา...</option>
                    </select>
                </div>
                <div class="col-md-5 my-2">
                    <select class="form-select" id="term-select" name="term" aria-label="term-select" onchange="termSelected()">
                        <option disabled selected value="">เลือกภาคเรียน...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="col-md-2 my-2">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-plus"></i>
                        เพิ่มเอกสาร
                    </button>
                </div>
            </form>
        </div>
    </div>
    @if(!isset($loanRequestDocuments) || count($loanRequestDocuments) == 0)
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3 text-center">
                    <h2>ไม่พบเอกสารของคุณ</h2>
                    <p class="text-muted">ดูเหมือนว่าคุณยังไม่มีรายการยื่นกู้รายเก่าเลื่อนชั้นปีอยู่ในระบบ</p>
                    <!-- You can add additional buttons or links here -->
                </div>
            </div>
        </div>
    @else
    @foreach($loanRequestDocuments as $loanRequestDocument)
        <div class="card mb-2">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-3 mt-3">
                        <span class="fw-bold text-dark">คำขอกู้ยืมรายเก่าเลื่อนชั้นปี</span>
                    </div>
                    <div class="col-md-2 mt-3">
                        <span class="text-secondary">ปีการศึกษา:</span> <span class="text-dark">{{$loanRequestDocument->year}}</span>
                    </div>
                    <div class="col-md-2 mt-3">
                        <span class="text-secondary">ภาคเรียนที่:</span> <span class="text-dark">{{$loanRequestDocument->term}}</span>
                    </div>
                    <div class="col-md-5 row mx-0">
                        @if($loanRequestDocument->status == "nonsend")
                        <div class="col-md-9 col-sm-12 my-2">
                            <a href="{{url('/borrower/loan_request/upload',['doc_id' => $loanRequestDocument->id])}}" class="btn btn-success w-100">ไปหน้าเพิ่มไฟล์ <i class="bi bi-box-arrow-in-right"></i></a>
                        </div>
                        @elseif($loanRequestDocument->status == "send")
                        <div class="col-md-9 col-sm-12 my-2">
                            <a href="{{url('/borrower/loan_request/edit',['doc_id' => $loanRequestDocument->id])}}" class="btn btn-warning w-100">แก้ใข <i class="bi bi-pencil"></i></a>
                        </div>
                        {{-- @elseif($loanRequestDocument->status == "approve") --}}
                        @endif
                        <div class="col-md-3 col-sm-12 my-2">
                            <button type="button" class="btn btn-light w-100" data-bs-toggle="modal" data-bs-target="#deleteDocModal-{{$loanRequestDocument->id}}">
                                ลบ 
                                <i class="bi bi-trash"></i>
                            </button>

                              <!-- Modal -->
                            <div class="modal fade" id="deleteDocModal-{{$loanRequestDocument->id}}" tabindex="-1" aria-labelledby="deleteDocModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="deleteDocModalLabel">ลบเอกสาร</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    ท่านต้องการบลเอกสาร คำขอกู้ยืมรายเก่าเลื่อนชั้นปี {{$loanRequestDocument->year}} / {{$loanRequestDocument->term}} หรือไม่
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                    <form method="POST" action="{{ route('delete.oldloan.request') }}">
                                        @csrf 
                                        <input type="hidden" name="doc_id" value="{{$loanRequestDocument->id}}">
                                        <button type="submit" class="btn btn-light">ลบเอกสารนี้</button>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if($loanRequestDocument->status == "nonsend")
                            <span class="text-warning">รอดำเนินการ....</span>
                        @elseif($loanRequestDocument->status == "send")
                            <span class="text-success"><i class="bi bi-check2-circle"></i> ส่งแล้ว </span> <span class="text-warning"> <i class="bi bi-exclamation-triangle-fill text-warning"></i> รอฝ่ายทุนอนุมัติ....</span>
                        @elseif($loanRequestDocument->status == "approve")
                            <span class="text-success"><i class="bi bi-check2-circle"></i> ฝ่ายทุนอนุมัติแล้ว</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif

</section>

<script>
    let dateDropdown = document.getElementById('year-select'); 
    
    let currentYear = new Date().getFullYear()+543;    
    // console.log(currentYear);
    let earliestYear = currentYear;   
    while ((currentYear - 20)  <= earliestYear) {      
        let dateOption = document.createElement('option');          
        dateOption.text = earliestYear;      
        dateOption.value = earliestYear;        
        dateDropdown.add(dateOption);      
        earliestYear -= 1;    
    }
</script>
@endsection