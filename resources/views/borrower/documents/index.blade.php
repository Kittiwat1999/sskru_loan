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
                        @foreach($borrower_documents as $document)
                        <tr>
                            <td>{{$document->id}}</td>
                            <td>
                            <span class="">{{$document->doctype_title}}</span><br>
                            <span class="fw-light text-secondary">{{$document->term}} / {{$document->year}}</span>
                            </td>
                            <td>
                              <span class="text-secondary">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $document->delivered_date)->format('d-m-Y H:i:s')}}
                              </span>
                            </td>
                            <td>
                              <span class="text-secondary">
                                @if($document->check_date == null)
                                  -
                                @else
                                  {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $document->check_date)->format('d-m-Y H:i:s')}}
                                @endif
                              </span>
                            </td>
                            <td>
                            @if($document['status'] == "wait-employee-approve" || $document['status'] == 'wait-teacher-comment')
                                <span class="badge bg-warning">รอการอนุมัติ</span>
                            @elseif($document['status'] == "rejected")
                                <span class="badge bg-danger text-light">ต้องแก้ไข</span>
                            @elseif($document['status'] == "approved")
                                <span class="badge bg-success text-light">อนุมัติแล้ว</span>
                            @endif
                            </td>
                            <td class="text-center">
                              @if($document['status'] == "rejected")
                                <button type="button" class="btn btn-sm btn-warning">แก้ใขไฟล์</button>
                              @else
                                <a href="{{route('borrower.document.page',['document_id' => $document->document_id ])}}" class="btn btn-sm btn-outline-primary">ดูไฟล์ที่ส่ง</a>
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