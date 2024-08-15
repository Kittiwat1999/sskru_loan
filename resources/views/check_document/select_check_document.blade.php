@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
@section('content')
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-4 mt-4 mb-3">
                    <select id="menu" class="form-select" aria-label="Default select example">
                        <option selected>สถานะเอกสาร</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>

            <?php
                date_default_timezone_set("Asia/Bangkok");

                $loan_request = array(
                array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s")),
                array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s")),
                array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s")),
                array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s")),
                );
            ?>

            <div class="row">
                <div class="col-md-4">
                    <label for="borrower-type" class="col-form-label text-secondary">คณะ</label>
                    <select id="faculty" class="form-select" aria-label="Default select example">
                        <option selected>ทั้งหมด</option>
                        <option value="1">คณะอะไร</option>
                        <option value="2">หมูกรอบ</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="borrower-type" class="col-form-label text-secondary">สาขา</label>
                    <select id="major" class="form-select" aria-label="Default select example">
                        <option selected>ทั้งหมด</option>
                        <option value="1">สาขาอะไร</option>
                        <option value="2">สักอย่าง</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                    <select id="grade" class="form-select" aria-label="Default select example">
                        <option selected>ทั้งหมด</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="col-md-12"><p class="text-secondary mt-3 mb-3">จำนวน {{ count($loan_request) }} ราย</p></div>
                <div class="col-md-12">
                    <div class="table-responsive">
                    <!-- Dark Table -->
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">รหัสนักศึกษา</th>
                            <th scope="col"></th>
                            <th scope="col">วันที่ส่งเอกสาร</th>
                            <th class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody >
                        <?php $i = 1?>
                        @foreach($loan_request as $borrower)
                        <tr onclick="showdocModal({{$borrower['id']}})">
                            <td>{{ $i++ }}</td>
                            <td>{{$borrower['id']}}</td>
                            <td>
                            <span>{{$borrower['name']}}</span><br>
                            <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                            <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                            <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                            </td>
                            <td>
                            {{$borrower['date_return']}}
                            </td>
                            <td>
                            <a href="{{ url('check_document/check_documents') }}" class="btn btn-primary mt-4">ตรวจเอกสาร</a>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    </div>
                    <!-- End Dark Table -->
                </div>
            </div>
        </div>
    </div>
@endsection
