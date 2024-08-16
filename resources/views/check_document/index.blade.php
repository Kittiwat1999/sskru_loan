@extends('layout')
@section('title')
ตรวจเอกสาร
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายการเอกสาร</h5>
            <div class="table-responsive mb-3">
                <table class="table table-striped" id="documents-table">
                    <thead>
                        <tr>
                            <th class="fw-bold">ID</th>
                            <th>เอกสาร</th>
                            <th class="text-center">วันที่เริ่ม</th>
                            <th class="text-center">วันที่สิ้นสุด</th>
                            <th class="text-center">เพิ่มโดย</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($documents as $document)
                            <tr>
                                <td>{{$document['id']}}</td>
                                <td>
                                    <span>{{$document['doctype_title']}}</span><br>
                                    <span class="text-secondary fw-lighter">{{$document['term']}}/{{$document['year']}}</span>
                                </td>
                                <td class="text-center">{{$document['start_date']}}</td>
                                <td class="text-center">{{$document['end_date']}}</td>
                                <td class="text-center">{{$document['last_access']}}</td>
                                <td class="text-center">
                                    <a href="{{ route('check_document.select_document',[ 'document_id' => $document['id']]) }}" class="bugget btn btn-primary mt-1">ตรวจเอกสาร</a>
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
            $('#documents-table').DataTable({
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