@extends('admin_layout')
@section('title')
admin settime
@endsection
@section('content')
<section class="section dashboard">
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">เพิ่มรายการ</h5>
                <form class="row" action="#" method="post">
                    <div class="col-sm-3">
                        <label for="year" class="col-form-label text-secondary">เลือกปีการศึกษา</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="term" id="term" class="form-control" value="1">
                    </div>
                    <div class="col-sm-1">
                        <label for="term" class="col-form-label text-secondary">/</label>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="year" id="year" class="form-control" value="{{date('Y')+543}}">
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3 mt-3">
                        <label for="select-document" class="col-form-label text-secondary">เลือกเอกสาร</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <select id="select-document" name="select-document" class="form-select" aria-label="Default select example">
                            <option selected>เลือกเอกสาร</option>
                            <option value="1">แบบยืนยัน</option>
                            <option value="2">แบบคำขอกู้ยืม(รายเก่า)</option>
                        </select>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="start-date" class="col-form-label text-secondary">วันที่เริมต้น</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <input id="start-date" name="start_date" class="form-control" type="date"></input>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="end-date" class="col-form-label text-secondary">วันที่สิ้นสุด</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <input id="end-date" name="end_date" class="form-control" type="date"></input>
                    </div>
                    <div class="text-end mt-3">
                        <button type="reset" class="btn btn-secondary">ล้างฟอร์ม</button>
                        <button type="submit" class="btn btn-success">เพิ่ม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการกำหนดการ</h5>
                <?php 
                $test_data = array(
                    array('name'=>'แบบยืนยันการเบิกเงิน','start_date'=>date("Y/m/d"),'end_date'=>date("Y/m/d"),'creater'=>'แล้วแต่','term'=>'1/2566'),
                    array('name'=>'แบบคำขอกู้ยืมรายเก่า','start_date'=>date("Y/m/d"),'end_date'=>date("Y/m/d"),'creater'=>'เธอ','term'=>'1/2566'),
                    array('name'=>'แบบยืนยันการเบิกเงิน','start_date'=>date("Y/m/d"),'end_date'=>date("Y/m/d"),'creater'=>'น่ารัก','term'=>'2/2565'),
                    array('name'=>'แบบคำขอกู้ยืมรายเก่า','start_date'=>date("Y/m/d"),'end_date'=>date("Y/m/d"),'creater'=>'ตามใจ','term'=>'2/2565')
                );
                $i=1;
                ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">เอกสาร</th>
                            <th scope="col">วันที่เริ่ม</th>
                            <th scope="col">วันที่สิ้นสุด</th>
                            <th scope="col">เพิ่มโดย</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($test_data as $list)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <span>{{$list['name']}}</span><br>
                                    <span class="text-secondary fw-light">{{$list['term']}}</span>
                                </td>
                                <td>{{$list['start_date']}}</td>
                                <td>{{$list['end_date']}}</td>
                                <td>{{$list['creater']}}</td>
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