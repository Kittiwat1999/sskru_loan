@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection

@section('content')
<section class="section Editing">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายการเอกสาร</h5>

            <ul class="list-group mb-4">
                @foreach($child_documents as $child_document)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span>{{$child_document['title']}}</span>
                            @if($child_document['status'] == 'approved')
                                <span class="text-success fw-bold">(อนุมัติ)</span>
                            @elseif($child_document['status'] == 'rejected')
                                <span class="text-danger fw-bold">(ไม่อนุมัติ)</span>
                            @elseif($child_document['status'] == 'response-reject')
                                <span class="text-warning fw-bold">(แก้ไขแล้ว)</span>
                            @endif
                        </div>
                        @if($child_document['status'] == 'delivered' || $child_document['status'] == 'response-reject')
                            <a class="btn btn-sm btn-primary" href="{{route('check_document.get.borrower_child_document', ['borrower_child_document_id' => Crypt::encryptString($child_document['borrower_child_document_id']), 'borrower_document_id' => Crypt::encryptString($borrower_document['id'])] )}}">ตรวจเอกสาร</a>
                        @else
                            <a class="btn btn-sm btn-outline-primary" href="{{route('check_document.get.borrower_child_document', ['borrower_child_document_id' => Crypt::encryptString($child_document['borrower_child_document_id']), 'borrower_document_id' => Crypt::encryptString($borrower_document['id']) ] )}}">ตรวจแล้ว</a>
                        @endif
                    </li>
                @endforeach
                @if($document['need_useful_activity'])
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span>บันทึกกิจกรรมจิตอาสา</span>
                        @if($useful_activities_status['status'] == 'approved')
                            <span class="text-success fw-bold">(อนุมัติ)</span>
                        @elseif($useful_activities_status['status'] == 'rejected')
                            <span class="text-danger fw-bold">(ไม่อนุมัติ)</span>
                        @elseif($useful_activities_status['status'] == 'response-reject')
                            <span class="text-warning fw-bold">(แก้ไขแล้ว)</span>
                        @endif
                    </div>
                    @if($useful_activities_status['status'] == 'delivered' || $useful_activities_status['status'] == 'response-reject')
                        <a class="btn btn-sm btn-primary" href="{{route('check_document.get.borrower.useful_activity', ['borrower_document_id' => Crypt::encryptString($borrower_document['id']) ])}}">ตรวจเอกสาร</a>
                    @else
                        <a class="btn btn-sm btn-outline-primary" href="{{route('check_document.get.borrower.useful_activity', ['borrower_document_id' => Crypt::encryptString($borrower_document['id']) ])}}">ตรวจแล้ว</a>
                    @endif
                </li>
                @endif
            </ul>

            <div class="card-body border mb-3">
                <div class="col-md-12 mt-3">
                    <h6 class="text-dark">ข้อมูลผู้กู้ยืมเงิน</h6>
                </div>
                <div class="row">
                    <div class="col-md-3 text-secondary fw-bold mb-2">ชื่อ - นามสกุล</div>
                    <div class="col-md-3">{{$borrower['prefix']}}{{$borrower['firstname']}} {{$borrower['lastname']}}</div>
                    
                    <div class="col-md-3 text-secondary fw-bold">วัน เดือน ปีเกิด</div>
                    <div class="col-md-3">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $borrower['birthday'])->format('d-m-Y')}}</div>
                    
                    <div class="col-md-3 text-secondary fw-bold">เลขประจำตัวประชาชน</div>
                    <div class="col-md-3">{{$borrower['citizen_id']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">อายุ</div>
                    <div class="col-md-3" id="age"></div>
                </div>

                <div class="border-top mt-4"></div>
                <div class="col-md-12 mt-3">
                    <h6 class="text-dark">ข้อมูลการติดต่อ</h6>
                </div>
                <div class="row">
                    <div class="col-md-3 text-secondary fw-bold">เบอร์โทรศัพท์มือถือ</div>
                    <div class="col-md-9">{{$borrower['phone']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">อีเมล</div>
                    <div class="col-md-9">{{$borrower['email']}}</div>
                </div>

                <div class="border-top mt-4"></div>
                <div class="col-md-12 mt-3">
                    <h6 class="text-dark">รายละเอียดข้อมูลการศึกษา</h6>
                </div>
                <div class="row">
                    <div class="col-md-3 text-secondary fw-bold mb-2">ปีการศึกษา</div>
                    <div class="col-md-3">{{$document['year']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">ภาคเรียน</div>
                    <div class="col-md-3">{{$document['term']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">ระดับการศึกษา</div>
                    <div class="col-md-9 mb-4">ปริญญาตรี</div>

                    <div class="col-md-3 text-secondary fw-bold mb-2">ชื่อสถานศึกษา</div>
                    <div class="col-md-9">มหาวิทยาลัยราชภัฎศรีสะเกษ</div>

                    <div class="col-md-3 text-secondary fw-bold mb-2">คณะ</div>
                    <div class="col-md-9">{{$borrower['faculty_name']}}</div>

                    <div class="col-md-3 text-secondary fw-bold mb-2">สาขาวิชา</div>
                    <div class="col-md-9">{{$borrower['major_name']}}</div>

                    <div class="col-md-3 text-secondary fw-bold mb-2">ชื่อ - นามสกุล</div>
                    <div class="col-md-3">{{$borrower['prefix']}}{{$borrower['firstname']}} {{$borrower['lastname']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">รหัสนักศึกษา</div>
                    <div class="col-md-3">{{$borrower['student_id']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">เกรดเฉลี่ยสะสมของปีการศึกษาก่อนหน้า/ระดับการศึกษาก่อนหน้า</div>
                    <div class="col-md-3">{{$borrower['gpa']}}</div>

                    <div class="col-md-3 text-secondary fw-bold">ชั้นปีที่จะกู้</div>
                    <div id="grade" class="col-md-3"></div>
                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="text-start col-6 m-0 p-0">
                    <a href="{{ route('check_document.select_document',[ 'document_id' => $document['id']]) }}" class="btn btn-light w-25">ย้อนกลับ</a>
                </div>
                <div class="text-end col-6 m-0 p-0">
                    @if($checked_document < $document_to_check)
                        <button class="btn btn-secondary" disabled >สรุปผลการตรวจเอกสาร</button>
                    @else
                        <a href="{{route('check_document.document.result',['borrower_document_id' => Crypt::encryptString($borrower_document['id']) ])}}" class="btn btn-primary">ถัดไป</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    var student_id = @json($borrower->student_id);
    var birthday = @json($borrower['birthday']);

    ageCal(birthday);
    calculateGrade(student_id);

    function calculateGrade(student_id){
        const date = new Date().getFullYear() + 543;
        let firstTwoDigits = Math.floor(date / 100);
        let buddhistCurrentYear = parseInt(Math.floor(date));
        let beginYear = parseInt(firstTwoDigits+student_id[0]+student_id[1]);
        let grade = (buddhistCurrentYear - beginYear) + 1;
        document.getElementById('grade').innerText = grade;
    }

    function ageCal(birthday) {
        var dateParts = birthday.split('-');
        var selectedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]); // Month is 0-based
        var currentDate = new Date();
        var buddhistCurrentYear = currentDate.getFullYear() + 543;
        var age = buddhistCurrentYear - (selectedDate.getFullYear());
        if (currentDate.getMonth() < selectedDate.getMonth() || (currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
            age--;
        }
        if (age < 0) {
            document.getElementById('age').innerText = "วันเกิดไม่ถูกต้อง";
        } else {
            document.getElementById('age').innerText = age+' ปี';
        }
    }
</script>
@endsection

