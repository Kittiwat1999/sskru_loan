@extends('layout')
@section('title')
index borrower
@endsection
@section('content')
    
<section class="section dashboard">
      <!-- start card table -->
      <div class="card">
          <div class="card-body">
              <h5 class="card-title">เอกสารที่ส่งแล้ว</h5>
              <div class="table-responsive">

                <table id="borrower-document-table" class="table table-striped">
                      <thead>
                          <tr>
                              <th scope="col">ID</th>
                              <th scope="col">รายการเอกสาร</th>
                              <th scope="col">วันที่ส่ง</th>
                              <th scope="col">วันที่ตรวจ</th>
                              <th scope="col">สถานะ</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($borrower_documents as $borrower_document)
                        <tr>
                            <td>{{$borrower_document->id}}</td>
                            <td>
                            <span class="">{{$borrower_document->doctype_title}}</span><br>
                            <span class="fw-light text-secondary">{{$borrower_document->term}} / {{$borrower_document->year}}</span>
                            </td>
                            <td>
                              <span class="text-secondary">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $borrower_document->delivered_date)->format('d-m-Y H:i:s')}}
                              </span>
                            </td>
                            <td>
                              <span class="text-secondary">
                                @if($borrower_document->check_date == null)
                                  -
                                @else
                                  {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $borrower_document->check_date)->format('d-m-Y H:i:s')}}
                                @endif
                              </span>
                            </td>
                            <td>
                            @if($borrower_document['status'] == "wait-approve")
                                <span class="badge bg-warning">รอการอนุมัติ</span>
                            @elseif($borrower_document['status'] == 'wait-teacher-approve')
                                <span class="badge bg-warning">รออาจารย์ที่ปรึกษาอนุมัติ</span>
                            @elseif($borrower_document['status'] == "rejected")
                                <span class="badge bg-danger text-light">ต้องแก้ไข</span>
                            @elseif($borrower_document['status'] == "response-reject")
                                <span class="badge bg-warning text-light">แก้ไขแล้ว</span>
                            @elseif($borrower_document['status'] == "approved")
                                <span class="badge bg-success text-light">อนุมัติแล้ว</span>
                            @endif
                            </td>
                            <td class="text-center">
                              @if($borrower_document['status'] == "rejected")
                                  @if($borrower_document['doctype_id'] == 1)
                                    <a href="{{url('/borrower/borrower_register')}}" class="btn btn-sm btn-outline-danger">ปฏิเสธโดยฝ่ายทุนฯ</a>
                                  @else
                                    <a href="{{route('borrower.upload.document.page', ['document_id' => $borrower_document['document_id']])}}" class="btn btn-sm btn-outline-danger">ปฏิเสธโดยฝ่ายทุนฯ</a>
                                  @endif
                              @elseif($borrower_document['teacher_status'] == "rejected")
                                @if($borrower_document['doctype_id'] == 1)
                                  <a href="{{url('/borrower/borrower_register')}}" class="btn btn-sm btn-outline-danger">ปฏิเสธโดยอาจารย์ที่ปรึกษา</a>
                                @else
                                  <a href="{{route('borrower.upload.document.page', ['document_id' => $borrower_document['document_id']])}}" class="btn btn-sm btn-outline-danger">ปฏิเสธโดยอาจารย์ที่ปรึกษา</a>
                                @endif
                              @else
                                <a href="{{route('borrower.view.document.page',['borrower_document_id' => $borrower_document->id ])}}" class="btn btn-sm btn-outline-primary">ดูไฟล์ที่ส่ง</a>
                              @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
          </div>
      </div>
      <!-- end card -->

</section>
@endsection
@section('script')
<script>
  $(document).ready(function() {
        $('#borrower-document-table').DataTable({
            language: {
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
            },
        });
    });
</script>
@endsection