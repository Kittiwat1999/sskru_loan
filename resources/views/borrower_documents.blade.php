@extends('layout')
@section('title')
    borrower document
@endsection
@section('content')
<section class="section">
    <?php 
    date_default_timezone_set("Asia/Bangkok");

    $user = array('prefix'=>'นาย','fname'=>'กิตติวัฒน์','lname'=>'เทียนเพ็ชร','loantype'=>'ผู้กู้ที่ขาดแคลนคุณทรัพย์','age'=>'24','stuId'=>'6410014103','faculty'=>'ศิลปศาสตร์และวิทยาศาสตร์','major'=>'วิศวกรรมซอฟต์แวร์','grade'=>'3','tel'=>'0931037881');

    $borrowers = array(
        array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2566','term'=>'2','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'ฝ่ายทุนกำลังดำเนินการ','waitQue'=>'125','karTerm'=>'9,000','karkrongchip'=>'18,000'),
        array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2566','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'9,000','karkrongchip'=>'18,000'),
        array('docName'=>'ยื่นกู้รายเก่า(ต่อเนื่อง)','year'=>'2566','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'','karkrongchip'=>''),
        array('docName'=>'แบบยืนยันการเบิกเงิน','year'=>'2565','term'=>'2','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'9,000','karkrongchip'=>'18,000'),
        array('docName'=>'สัญญาและแบบยืนยัน','year'=>'2565','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'9,000','karkrongchip'=>'18,000'),
        array('docName'=>'แบบคำขอกู้ยืม','year'=>'2565','term'=>'1','lastUpdate'=>date('Y-m-d H:i:s'),'status'=>'อนุมัติแล้ว','waitQue'=>'','karTerm'=>'','karkrongchip'=>''),
    );
    $i = 1;
    ?>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">รายละเอียดผู้กู้</h5>
                    <div class="card-body">
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">ชื่อ</div>
                            <div class="col-sm-8">{{$user['prefix']}}{{$user['fname']}} {{$user['lname']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">ประเภทผู้กู้</div>
                            <div class="col-sm-8">{{$user['loantype']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">อายุ</div>
                            <div class="col-sm-8">{{$user['age']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">รหัสนักศึกษา</div>
                            <div class="col-sm-8">{{$user['stuId']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">คณะ</div>
                            <div class="col-sm-8">{{$user['faculty']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">สาขา</div>
                            <div class="col-sm-8">{{$user['major']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">ชั้นปีที่</div>
                            <div class="col-sm-8">{{$user['grade']}}</div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-sm-4 label fw-bold text-secondary ">โทรศัพท์</div>
                            <div class="col-sm-8">{{$user['tel']}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">รายการเอกสาร</h5>
                
                    <div>
                        <!-- Dark Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">รายการเอกสาร</th>
                                    <th scope="col">วันที่ส่ง</th>
                                    <th scope="col">สถานะ</th>
                                    <th scope="col">ค่าเทอม/ค่าครองชีพ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowers as $borrower)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                    <span class="">{{$borrower['docName']}}</span><br>
                                    <span class="fw-light text-secondary">{{$borrower['year']}} / {{$borrower['term']}}</span>
                                    </td>
                                    <td>
                                    <span class="text-secondary">
                                        {{$borrower['lastUpdate']}}
                                    </span>
                                    </td>
                                    <td>
                                    @if($borrower['status'] == "ฝ่ายทุนกำลังดำเนินการ")
                                        <button class="btn btn-sm btn-outline-warning">{{$borrower['status']}}</button><br>
                                    @else
                                        <button class="btn btn-sm btn-success">{{$borrower['status']}}</button>
                                    @endif
                                    @if($borrower['waitQue'] !='')
                                        <span class="fw-light text-secondary">(คิวที่ {{$borrower['waitQue']}})</span>
                                    @endif
                                    </td>
                                    <td>
                                        @if($borrower['karTerm'] && $borrower['karkrongchip'])
                                            <sapn class="text-dark">{{$borrower['karTerm']}} / {{$borrower['karkrongchip']}}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection