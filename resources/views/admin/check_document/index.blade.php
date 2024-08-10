@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายการเอกสาร</h5>
            <div class="table-responsive mb-3">
                <table class="table table-striped table-bordered" id="check-documents-table">
                    <thead>
                        <tr>
                            <th class="fw-bold">#</th>
                            <th>เอกสาร</th>
                            <th class="text-center">วันที่เริ่ม</th>
                            <th class="text-center">วันที่สิ้นสุด</th>
                            <th class="text-center">เพิ่มโดย</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $doc = array(
                                
                                array('doc'=>'ยื่นกู้รายเก่าลื่นชั้นปี','year'=>'2/2566','date_start'=>'19/02/2567','date_end'=>'01/09/2567','added_by'=>'กิตติวัตน์'),
                                array('doc'=>'สัญญาและแบบยืนยันการเบิกเงิน','year'=>'2/2567','date_start'=>'06/08/2567','date_end'=>'30/11/3110','added_by'=>'กิตติวัตน์'),
                                    
                            );
                            $i = 1;
                        ?>
                        @foreach($doc as $doc_1)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <span>{{$doc_1['doc']}}</span><br>
                                    <span class="text-secondary fw-lighter">{{$doc_1['year']}}</span>
                                </td>
                                <td class="text-center">{{$doc_1['date_start']}}</td>
                                <td class="text-center">{{$doc_1['date_end']}}</td>
                                <td class="text-center">{{$doc_1['added_by']}}</td>
                                <td class="text-center">
                                    <a href="{{ url('/admin/check_document/select_check_document') }}" class="bugget btn btn-primary mt-1">ตรวจเอกสาร</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#check-documents-table').DataTable({
                "language": {
                    "sProcessing": "กำลังประมวลผล...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
                    "sSearch": "ค้นหา:",
                    "oPaginate": {
                        "sFirst": "แรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "สุดท้าย"
                    }
                }
            });
        });
    </script>
@endsection