@extends('layout')
@section('title')
index loanrequest
@endsection
@section('content')
<section class="content">
    @if($errors->any())
        <div class="card">

            <div class="card-body">
                <h5 class="card-title text-danger">ข้อผิดพลาด!</h5>
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">เพิ่มเอกสารคำขอกู้ยืมรายเก่า</h5>
            <form action="{{route('add.loan.request')}}" method="POST" class="row">
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
    @if(!isset($loanRequestDocuments))
        <p class="text-secondary">ยังไม่มีเอกสาร</p>
    @else
    @foreach($loanRequestDocuments as $loanRequestDocument)
        <div class="card mb-2">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-md-3 mt-2">
                        <span class="fw-bold text-dark">คำขอกู้ยืมรายเก่าเลื่อนชั้นปี</span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <span class="text-secondary">ปีการศึกษา:</span> <span class="text-dark">{{$loanRequestDocument->year}}</span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <span class="text-secondary">ภาคเรียนที่:</span> <span class="text-dark">{{$loanRequestDocument->term}}</span>
                    </div>
                    <div class="col-md-5">
                        <a href="{{url('/borrower/loan_request/upload',['doc_id' => $loanRequestDocument->id])}}" class="btn btn-success w-100">ไปหน้าเพิ่มไฟล์ <i class="bi bi-box-arrow-in-right"></i></a>
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