@extends('layout')
@section('title')
แก้ใขเอกสาร
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการหนังสือ</h5>
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>เอกสาร</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doc_types as $doc_type)
                            <tr>
                                <td class="text-center fw-bold">{{$loop->index+1}}</td>
                                <td>{{$doc_type->doctype_title}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDocTypeModal" ><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#deleteDocTypeModal" ><i class="bi bi-trash"></i></button>
                                    </div>

                                    <!-- edit Modal -->
                                    <div class="modal fade" id="editDocTypeModal" tabindex="-1" aria-labelledby="editDocTypeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDocTypeModalLabel">แก้ไขหนังสือ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row" action="" method="post" id="addDocTypeForm">
                                                        @csrf
                                                        <div class="col-12">
                                                            <label for="doctype_title" class="form-label">หนังสือ</label>
                                                            <input type="text" class="form-control" id="doctype_title" required>
                                                        </div>
                                                        {{-- </form>  must be closed here --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                    <button type="button" class="btn btn-primary">บันทึก</button>
                                                </div>
                                                </form> <!-- but i'm lazy and here it easy to validate-->
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- delete Modal -->
                                    <div class="modal fade" id="deleteDocTypeModal" tabindex="-1" aria-labelledby="deleteDocTypeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteDocTypeModalLabel">ลบหนังสือ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row" action="" method="post" id="addDocTypeForm">
                                                        @csrf
                                                            <label for="" class="form-label">ต้องการลบเอกสารนี้หรือไม่</label>
                                                    {{-- </form>  must be closed here --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                                    <button type="button" class="btn btn-secondary">ลบ</button>
                                                </div>
                                                </form> <!-- but i'm lazy and here it easy to validate-->
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addDocTypeModal">
                            + เพิ่มหนังสือ
                          </button>
                    </div>
                    <div class="col-md-9"></div>
                </div>
                <div>
                    <!-- Modal -->
                    <div class="modal fade" id="addDocTypeModal" tabindex="-1" aria-labelledby="addDocTypeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDocTypeModalLabel">เพิ่มหนังสือ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row" action="" method="post" id="addDocTypeForm">
                                        @csrf
                                        <div class="col-12">
                                            <label for="doctype_title" class="form-label">หนังสือ</label>
                                            <input type="text" class="form-control" id="doctype_title" required>
                                        </div>
                                        {{-- </form>  must be closed here --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="button" class="btn btn-primary">บันทึก</button>
                                </div>
                                </form> <!-- but i'm lazy and here it easy to validate-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการเอกสาร</h5>
                
                <div class="table-responsive mb-3">
                    <table class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">#</th>
                                <th>เอกสาร</th>
                                <th class="text-center">ข้อมูลยอดเงินกู้</th>
                                <th class="text-center">ตัวอย่างเอกสาร</th>
                                <th class="text-center">ตัวอย่างเอกสาร<br>(ผู้มีอายุต่ำกว่า 20 ปี)</th>
                                <th class="text-center">แก้ไข/ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($child_documents as $child_document)
                            <tr>
                                <td class="text-center fw-bold">{{$loop->index+1}}</td>
                                <td>{{$child_document->child_document_title}}</td>
                                <td class="text-center">
                                    @if ($child_document->need_loan_balance)
                                        <i class="bi bi-check-circle text-success fw-bold fs-5"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-dark">ดูเอกสาร</button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-dark">ดูเอกสาร</button>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editChildDocModal"><i class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-light" data-bs-toggle="modal"   data-bs-target="#deleteDocChildModal"><i class="bi bi-trash"></i></button>
                                    </div>

                                    <div>
                                        <div class="modal fade" id="editChildDocModal" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">เพิ่มเอกสาร</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="row" action="" method="post" id="addChildDocForm" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="col-12 mb-3">
                                                                <label for="child_doc_title" class="form-label">เอกสาร</label>
                                                                <input type="text" class="form-control" id="child_doc_title" name="child_doc_title" required>
                                                            </div>
                                                            <div class="col-12 mb-5">
                                                                <label for="need_laon_balance" class="form-label">ข้อมูลยอดเงินกู้</label>
                                                                <select id="need_laon_balance" class="form-select" name="need_laon_balance" required>
                                                                    <option selected disabled value="" >เลือก...</option>
                                                                    <option value="true">ต้องการ</option>
                                                                    <option value="false">ไม่ต้องการ</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div id="file_everyone_area">
                                                                <div class="col-12 mb-3">
                                                                    <label for="file_everyone" class="form-label">ตัวอย่างเอกสาร 1</label>
                                                                    <input type="file" class="form-control" id="file_everyone" name="file_everyone[]" required>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label for="description" class="form-label">คำอธิบายสำหรับตัวอย่างเอกสาร 1</label>
                                                                    <input type="text" class="form-control" id="description" name="description[]" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <button type="button" class="btn btn-success" onclick="addfile()"> + เพิ่มไฟล์</button>
                                                                <button type="button" class="btn btn-light" onclick="deletefile()"> ลบไฟล์</button>
                                                            </div>
                                                            <div class="col-12 mt-3">
                                                                <label for="file_minors" class="form-label">ตัวอย่างเอกสารสำหรับผู้มีอายุต่ำกว่า 20 ปี</label>
                                                                <input type="file" class="form-control" id="file_minors" name="file_minors">
                                                            </div>
                                                        {{-- </form>  must be closed here --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="sumbit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                    </form> <!-- but i'm lazy and here it easy to validate-->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- delete Modal -->
                                    <div class="modal fade" id="deleteDocChildModal" tabindex="-1" aria-labelledby="deleteDocChildModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteDocChildModalLabel">ลบหนังสือ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row" action="" method="post" id="addDocTypeForm">
                                                        @csrf
                                                            <label for="" class="form-label">ต้องการลบเอกสารนี้หรือไม่</label>
                                                    {{-- </form>  must be closed here --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ไม่</button>
                                                    <button type="button" class="btn btn-secondary">ลบ</button>
                                                </div>
                                                </form> <!-- but i'm lazy and here it easy to validate-->
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
                <div class="row mb-3">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addChildDocModal">
                            + เพิ่มเอกสาร
                          </button>
                    </div>
                    <div class="col-md-9"></div>
                    <div>
                        {{-- modal --}}
                        <div class="modal fade" id="addChildDocModal" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">เพิ่มเอกสาร</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row" action="" method="post" id="addChildDocForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-12 mb-3">
                                                <label for="child_doc_title" class="form-label">เอกสาร</label>
                                                <input type="text" class="form-control" id="child_doc_title" name="child_doc_title" required>
                                            </div>
                                            <div class="col-12 mb-5">
                                                <label for="need_laon_balance" class="form-label">ข้อมูลยอดเงินกู้</label>
                                                <select id="need_laon_balance" class="form-select" name="need_laon_balance" required>
                                                    <option selected disabled value="" >เลือก...</option>
                                                    <option value="true">ต้องการ</option>
                                                    <option value="false">ไม่ต้องการ</option>
                                                </select>
                                            </div>
                                            
                                            <div id="file_everyone_area">
                                                <div class="col-12 mb-3">
                                                    <label for="file_everyone" class="form-label">ตัวอย่างเอกสาร 1</label>
                                                    <input type="file" class="form-control" id="file_everyone" name="file_everyone[]" required>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="description" class="form-label">คำอธิบายสำหรับตัวอย่างเอกสาร 1</label>
                                                    <input type="text" class="form-control" id="description" name="description[]" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <button type="button" class="btn btn-success" onclick="addfile()"> + เพิ่มไฟล์</button>
                                                <button type="button" class="btn btn-light" onclick="deletefile()"> ลบไฟล์</button>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <label for="file_minors" class="form-label">ตัวอย่างเอกสารสำหรับผู้มีอายุต่ำกว่า 20 ปี</label>
                                                <input type="file" class="form-control" id="file_minors" name="file_minors">
                                            </div>
                                        {{-- </form>  must be closed here --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="sumbit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                    </form> <!-- but i'm lazy and here it easy to validate-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var fileIndex = 1;
        
        function addfile() {
            var file_everyone_area = document.getElementById('file_everyone_area');
            ++fileIndex;
            file_everyone_area.innerHTML += `
                <div class="col-12 mb-3" id="file_everyone${fileIndex}">
                    <label for="file_everyone" class="form-label">ไฟล์ตัวอย่าง ${fileIndex}</label>
                    <input type="file" class="form-control" name="file_everyone[]" required>
                </div>
                <div class="col-12 mb-3" id="description${fileIndex}">
                    <label for="description" class="form-label">คำอธิบายสำหรับไฟล์ตัวอย่าง ${fileIndex}</label>
                    <input type="text" class="form-control" name="description[]" required>
                </div>
            `;
        }

        function deletefile(){
            var file_element = document.getElementById(`file_everyone${fileIndex}`);
            var text_element = document.getElementById(`description${fileIndex}`);
            if(file_element)file_element.remove();
            if(text_element)text_element.remove();

            if(fileIndex > 1)fileIndex-- ;
        }
    </script>
@endsection