@extends('layout')
@section('title')
แคชและความเห็น
@endsection
@section('content')
 <section class="main">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">แคชการตรวจเอกสาร</h5>
            <span class="text-warning">*พนักงานกำลังดำเนินการตรวจเอกสารเหล่านี้</span>
            <section class="my-3">
                <div class="table-responsive">
                    <table class="table" id="cache-table">
                        <thead>
                            <tr>
                                <th>เอกสาร</th>
                                <th>ชื่อ-สกุล</th>
                                <th>คณะ-สาขา</th>
                                <th>วันที่ส่งเอกสาร</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrower_documents as $borrower_document)
                            <tr>
                                <td>
                                    {{$borrower_document['doctype_title']}}
                                </td>
                                <td>
                                    <span>{{$borrower_document['prefix'].$borrower_document['firstname']. ' ' .$borrower_document['lastname']}}</span><br/>
                                    <span class="text-secondary">{{$borrower_document['student_id']}}</span>
                                </td>
                                <td>
                                    <span>{{$borrower_document['faculty_name']}}</span><br/>
                                    <span class="text-secondary">{{$borrower_document['major_name']}}</span><br/>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $borrower_document['delivered_date'])->format('d-m-Y H:i:s')}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#clearCacheModal-{{$borrower_document['id']}}">
                                        เคลียแคช
                                    </button>
                                    <div class="modal fade" id="clearCacheModal-{{$borrower_document['id']}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">เคลียแคช</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    เคลียแคชการตรวจเอกสาร {{$borrower_document['doctype_title']}} {{$borrower_document['prefix'].$borrower_document['firstname']. ' ' .$borrower_document['lastname']}} <br/>
                                                    คลิก <span class="text-danger">เคลียแคช</span> เพื่อดำเนินการต่อ
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ไม่</button>
                                                    <a href="{{route('admin.clear.cache.one', ['borrower_document_id' => $borrower_document['id']])}}" class="btn btn-danger">เคลียแคช</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="row">
                <div class="col-md-3 col-sm-12">
                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#clearAllCacheModal">
                        เคลียแคชทั้งหมด
                    </button>
                </div>
                <div class="modal fade" id="clearAllCacheModal" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">เคลียแคชทั้งหมด</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                แคชการตรวจเอกสารทั้งหมดจะถูกล้าง คลิก <span class="text-danger">เคลียแคชทั้งหมด</span> เพื่อดำเนินการต่อ
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">ไม่</button>
                                <a href="{{route('admin.clear.cache.all')}}" class="btn btn-danger">เคลียแคชทั้งหมด</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- ความคิดเห็นอาจารย์ที่ปรึกษา --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">ความคิดเห็นอาจารย์ที่ปรึกษา</h5>
            <section class="">
                <div class="table-responsive">
                    <table class="table" id="cache-table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ความคิดเห็น</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teacher_comments as $teacher_comment)
                            <tr>
                                <td>
                                    {{$loop->index + 1}}
                                </td>
                                <td>
                                    <span>{{$teacher_comment['comment']}}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editTeacherCommentModal-{{$teacher_comment['id']}}">
                                            แก้ไข
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light w-100" data-bs-toggle="modal" data-bs-target="#deleteTeacherCommentModal-{{$teacher_comment['id']}}">
                                            ลบ
                                        </button>
                                    </div>
                                    <div class="modal fade" id="editTeacherCommentModal-{{$teacher_comment['id']}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">แก้ไขความคิดเห็น</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-teacher-comment-{{$teacher_comment['id']}}" class="row" action="{{route('admin.edit.teahcer.comment',['teacher_comment_id' => $teacher_comment['id'] ]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-12">
                                                            <label for="faculty_name" class="form-label">แก้ไขความคิดเห็น</label>
                                                            <input type="text" class="form-control need-custom-validate" id="comment" name="comment" value="{{$teacher_comment['comment']}}" required >
                                                            <div class="invalid-feedback">
                                                                กรุณากรอกความคิดเห็น
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                                    <button type="button" class="btn btn-primary" onclick="submitForm('edit-teacher-comment-{{$teacher_comment['id']}}')">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                      </div>

                                    <div class="modal fade" id="deleteTeacherCommentModal-{{$teacher_comment['id']}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">เคลียแคช</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    คุณแน่ใจหรือไม่ว่าต้องการลบความเห็น <span class="text-danger">{{$teacher_comment['comment']}}</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                                    <a href="{{route('admin.delete.teahcer.comment', ['teacher_comment_id' => $teacher_comment['id'] ])}}" class="btn btn-danger">ลบความเห็น</a>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="row">
                <div class="col-md-3 col-sm-12">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addTeacherCommentModal">
                        เพิ่มความคิดเห็น
                    </button>
                </div>
                <div class="modal fade" id="addTeacherCommentModal" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">เพิ่มความคิดเห็น</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-teacher-comment" class="row" action="{{route('admin.add.teahcer.comment')}}" method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <label for="faculty_name" class="form-label">เพิ่มความคิดเห็น</label>
                                        <input type="text" class="form-control need-custom-validate" id="comment" name="comment" required >
                                        <div class="invalid-feedback">
                                            กรุณากรอกความคิดเห็น
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary" onclick="submitForm('add-teacher-comment')">เพิ่มความคิดเห็น</button>
                            </div>
                        </div>
                    </div>
                  </div>
            </section>
        </div>
    </div>
    {{-- ความคิดเห็นอาจารย์ที่ปรึกษา --}}

    {{-- ความคิดเห็น--}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ความคิดเห็นของผู้ตรวจเอกสาร</h5>
            <section class="">
                <div class="table-responsive">
                    <table class="table" id="cache-table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ความคิดเห็น</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    {{$loop->index + 1}}
                                </td>
                                <td>
                                    <span>{{$comment['comment']}}</span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editCommentModal-{{$comment['id']}}">
                                            แก้ไข
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light w-100" data-bs-toggle="modal" data-bs-target="#deleteCommentModal-{{$comment['id']}}">
                                            ลบ
                                        </button>
                                    </div>
                                    <div class="modal fade" id="editCommentModal-{{$comment['id']}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">แก้ไขความคิดเห็น</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-comment-{{$comment['id']}}" class="row" action="{{route('admin.edit.comment',['comment_id' => $comment['id'] ]) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-12">
                                                            <label for="faculty_name" class="form-label">แก้ไขความคิดเห็น</label>
                                                            <input type="text" class="form-control need-custom-validate" id="comment" name="comment" value="{{$comment['comment']}}" required >
                                                            <div class="invalid-feedback">
                                                                กรุณากรอกความคิดเห็น
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                                    <button type="button" class="btn btn-primary" onclick="submitForm('edit-comment-{{$comment['id']}}')">บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                      </div>

                                    <div class="modal fade" id="deleteCommentModal-{{$comment['id']}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">เคลียแคช</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    คุณแน่ใจหรือไม่ว่าต้องการลบความเห็น <span class="text-danger">{{$comment['comment']}}</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                                    <a href="{{route('admin.delete.comment', ['comment_id' => $comment['id'] ])}}" class="btn btn-danger">ลบความเห็น</a>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="row">
                <div class="col-md-3 col-sm-12">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                        เพิ่มความคิดเห็น
                    </button>
                </div>
                <div class="modal fade" id="addCommentModal" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">เพิ่มความคิดเห็น</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="add-comment" class="row" action="{{route('admin.add.comment')}}" method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <label for="faculty_name" class="form-label">เพิ่มความคิดเห็น</label>
                                        <input type="text" class="form-control need-custom-validate" id="comment" name="comment" required >
                                        <div class="invalid-feedback">
                                            กรุณากรอกความคิดเห็น
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary" onclick="submitForm('add-comment')">เพิ่มความคิดเห็น</button>
                            </div>
                        </div>
                    </div>
                  </div>
            </section>
        </div>
    </div>
    {{-- ความคิดเห็น --}}
 </section>
@endsection
@section('script')
<script>

    async function submitForm(form_id){
        var validation = await validateForm(form_id);
        if(validation){
            const form = document.getElementById(form_id);
            form.submit();
        } 
    }

    function validateForm(form_id){
        const form = document.getElementById(form_id);
        const input_text = form.querySelector('input[type="text"][required]');
        var validator = true;

        if(input_text.value == ''){
            validator = false;
            var invalid_element = input_text.nextElementSibling;
            if(invalid_element)invalid_element.classList.add('d-inline');
        }else{
            var invalid_element = input_text.nextElementSibling;
            if(invalid_element)invalid_element.classList.remove('d-inline');
        }

        return validator;
    }

    $(document).ready(function() {
        $('#cache-table').DataTable({
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
