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
                            <a class="btn btn-sm btn-primary" href="{{route('check_document.get.borrower_child_document', ['borrower_child_document_id' => $child_document['borrower_child_document_id'], 'borrower_document_id' => $borrower_document['id']] )}}">ตรวจเอกสาร</a>
                        @else
                            <a class="btn btn-sm btn-outline-primary" href="{{route('check_document.get.borrower_child_document', ['borrower_child_document_id' => $child_document['borrower_child_document_id'], 'borrower_document_id' => $borrower_document['id']] )}}">ตรวจแล้ว</a>
                        @endif
                    </li>
                @endforeach
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
                    @if($useful_activities_status['status'] == 'delivered' || $child_document['status'] == 'response-reject')
                        <a class="btn btn-sm btn-primary" href="{{route('check_document.get.borrower.useful_activity', ['borrower_document_id' => $borrower_document['id'] ])}}">ตรวจเอกสาร</a>
                    @else
                        <a class="btn btn-sm btn-outline-primary" href="{{route('check_document.get.borrower.useful_activity', ['borrower_document_id' => $borrower_document['id'] ])}}">ตรวจแล้ว</a>
                    @endif
                </li>
            </ul>

            <div class="row pl-1 px-2">
                <div class="col-md-3 text-secondary fw-bold">ชื่อ-นามสกุล</div>
                <div class="col-md-4">{{$borrower['prefix']}}{{$borrower['firstname']}} {{$borrower['lastname']}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">ลักษณะผู้กู้</div>
                <div class="col-md-4">{{$borrower['title']}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">เกิดเมื่อ</div>
                <div class="col-md-4">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $borrower['birthday'])->format('d-m-Y')}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">อายุ</div>
                <div class="col-md-4" id="age"></div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">รหัสนักศึกษา</div>
                <div class="col-md-4">{{$borrower['student_id']}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">คณะ</div>
                <div class="col-md-4">{{$borrower['faculty_name']}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">สาขา</div>
                <div class="col-md-4">{{$borrower['major_name']}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">ชั้นปี</div>
                <div id="grade" class="col-md-4"></div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">โทรศัพท์</div>
                <div class="col-md-4">{{$borrower['phone']}}</div>
                <div class="col-md-5"></div>

                <div class="col-md-3 text-secondary fw-bold">ผลการเรียนเฉลี่ย</div>
                <div class="col-md-4">{{$borrower['gpa']}}</div>
                <div class="col-md-5"></div>
            </div>
            <div class="text-end">
                @if($checked_document < $document_to_check)
                <button class="btn btn-secondary col-4 col-md-3" disabled >สรุปผลการตรวจเอกสาร</button>
                @else
                    <a href="{{route('check_document.document.result',['borrower_document_id' => $borrower_document['id'] ])}}" class="btn btn-primary col-4 col-md-3">สรุปผลการตรวจเอกสาร</a>
                @endif
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

