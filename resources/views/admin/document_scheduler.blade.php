@extends('layout')
@section('title')
admin document scheduler
@endsection
@section('content')
<section class="section dashboard">
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">เพิ่มรายการส่งเอกสารสำหรับผู้กู้</h5>
                <form class="row" action="#" method="post">
                    <div class="col-sm-3">
                        <label for="year" class="col-form-label text-secondary">เลือกปีการศึกษา</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="term" id="term" class="form-control" value="" placeholder="1">
                    </div>
                    <div class="col-sm-1">
                        <label for="term" class="col-form-label text-secondary">/</label>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="year" id="year" class="form-control" value="" placeholder="{{date('Y')+543}}">
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3 mt-3">
                        <label for="select-document" class="col-form-label text-secondary">เลือกหนังสือ</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <select id="select-document" name="select-document" class="form-select" aria-label="Default select example">
                            <option selected disabled value="" >เลือกหนังสือ...</option>
                            @foreach($doc_types as $doc_type)
                            <option value="{{$doc_type->id}}">{{$doc_type->doctype_title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="start-date" class="col-form-label text-secondary">เลือกเอกสาร</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        @foreach($child_documents as $child_document)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="document{{$loop->index+1}}" name="child_documents[]" value="{{$child_document->id}}">
                            <label class="form-check-label" for="document">
                                {{$child_document->child_document_title}}
                            </label>
                        </div>
                        @endforeach
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="useful-act" name="need_useful_activity" value="true">
                            <label class="form-check-label" for="useful-act">
                                กิจกรรมจิตอาสา
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="start_date" class="col-form-label text-secondary">วันที่เริมต้น</label>
                    </div>
                    <div class="col-sm-9 mt-3">
                        <div class="input-group date" id="">
                            <input type="text" name="start_date" id="start_date" class="form-control"
                                placeholder="วว/ดด/ปปปป" required />
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="end_date" class="col-form-label text-secondary">วันที่สิ้นสุด</label>
                        
                    </div>
                    <div class="col-sm-9 mt-3">
                        <div class="input-group date" id="">
                            <input type="text" name="end_date" id="end_date" class="form-control"
                                placeholder="วว/ดด/ปปปป" required />
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-3 mt-3">
                        <label for="description" class="col-form-label text-secondary">คำอธิบาย</label>
                        
                    </div>
                    <div class="col-sm-9 mt-3">
                        <div class="input-group" id="description">
                            <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                        </div>
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

@section('script')
<script>
    $(document).ready(function () {
        $.datetimepicker.setLocale('th'); 
  
        $('#start_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });

        $('#end_date').datetimepicker({
            format: 'd-m-Y', 
            timepicker: false, 
            yearOffset: 543, 
            closeOnDateSelect: true 
        });
    })
</script>
@endsection