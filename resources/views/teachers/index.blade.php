@extends('layout')
@section('title')
    teacher home
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">รายการรออาจารย์ที่ปรึกษาให้ความเห็น</h5>
                <!-- Default Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="wait-for-appove-tab" data-bs-toggle="tab" data-bs-target="#wait-for-appove" type="button" role="tab" aria-controls="wait-for-appove" aria-selected="true">คำขอกู้รออาจารย์ที่ปรึกษาให้ความเห็น</button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="appove-tab" data-bs-toggle="tab" data-bs-target="#appove" type="button" role="tab" aria-controls="appove" aria-selected="false">ให้ความเห็นแล้ว</button>
                    </li>
                </ul>
                @php
                    $select_grade = Session::get('select_grade');
                    date_default_timezone_set("Asia/Bangkok");
                    $loan_requests = array(
                        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'กู้มาผ่อน Iphone 15 promax','age'=>'24','comment'=>array('ครอบครัวขาดแคลน iphone 15','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'สาขาที่เป็นความต้องการหลัก','age'=>'23','comment'=>array('เป็นสาขาที่เป็นความต้องการหลัก','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    array('id'=>'6410014101','name'=>'กฤษฎา เจริญวิเชียรฉาย','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'สารขาที่ขาดแคลน','age'=>'21','comment'=>array('เป็นสารขาที่ขาดแคลน','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','send_date'=>date("Y-m-d H:i:s"),'approve_date'=>date("Y-m-d H:i:s"),'tel'=>'0931037881','type'=>'กู้มาผ่อนบ้าน','age'=>'21','comment'=>array('นักศึกษาขาดแคลนที่อยู่อาศัย','เห็นควรพิจารณาอนุมัติให้กู้ยืม'),'gpa'=>'3.56'),
                    );
                    $i = 0;
                @endphp
                <div class="tab-content pt-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="wait-for-appove" role="tabpanel" aria-labelledby="wait-for-appove-tab">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="grade" class="col-form-label text-secondary">คณะ/วิทยาลัย: <span class="text-dark">{{$teacher->faculty_name}}</span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="grade" class="col-form-label text-secondary">สาขาวิชา: <span class="text-dark">{{$teacher->major_name}}</span></label>
                            </div>
                            <div class="col-md-2 text-end">
                                <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                            </div>
                            <div class="col-md-2">
                                <select id="grade" class="form-select" aria-label="Default select example" onchange="getUsersByGrade(this.value)">
                                    <option @selected($select_grade == 'all') value="all">ทั้งหมด</option>
                                    <option @selected($select_grade == '1') value="1">1</option>
                                    <option @selected($select_grade == '2') value="2">2</option>
                                    <option @selected($select_grade == '3') value="3">3</option>
                                    <option @selected($select_grade == '4') value="4">4</option>
                                    <option @selected($select_grade == '5') value="5">5</option>
                                </select>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>รหัสนักศึกษา</th>
                                        <th></th>
                                        <th>วันที่ส่งเอกสาร</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrower_documents as $borrower_document)
                                    <tr>
                                        <td>{{$borrower_document['student_id']}}</td>
                                        <td>
                                            <sapn class="">{{$borrower_document['prefix']}}{{$borrower_document['firstname']}} {{$borrower_document['lastname']}}</sapn><br>
                                            <span class="fw-light text-secondary">{{$borrower_document['faculty_name']}}</span><br>
                                            <span class="fw-light text-secondary">{{$borrower_document['major_name']}}</span><br>
                                            <span class="fw-light text-secondary">ชั้นปี: {{$borrower_document['grade']}}</span>
                                        </td>
                                        <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $borrower_document['delivered_date'])->format('d-m-Y H:i:s')}}</td>
                                        <td>
                                            <a href="{{ route('teacher.comment.borrower.document', ['borrower_document_id' => $borrower_document['id']]) }}" class="btn btn-primary">ดูเอกสาร <i class="bi bi-file-pdf"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="appove" role="tabpanel" aria-labelledby="appove-tab">
                    <div class="row">
                            <div class="col-md-3 mt-3">
                                <p class="text-secondary">ทั้งหมด {{count($loan_requests)}} รายการ</p>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-1 text-end">
                                <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                            </div>
                            <div class="col-md-2">
                                <select id="grade" class="form-select" aria-label="Default select example">
                                    <option selected>ทั้งหมด</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสนักศึกษา</th>
                                        <th></th>
                                        <th>ลักษณะผู้กู้</th>
                                        <th>ความคิดเห็นอาจารย์ที่ปรึกษา</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan_requests as $loan_req)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$loan_req['id']}}</td>
                                        <td>
                                            <sapn class="fw-bold">{{$loan_req['name']}}</sapn><br>
                                            <span class="fw-light text-secondary">{{$loan_req['faculty']}}</span><br>
                                            <span class="fw-light text-secondary">{{$loan_req['major']}}</span><br>
                                            <span class="fw-light text-secondary">ชั้นปี: {{$loan_req['grade']}}</span>
                                        </td>
                                        <td>{{$loan_req['type']}}</td>
                                        <td>
                                            @foreach($loan_req['comment'] as $comment)
                                                <span class="text-success">{{$comment}}</span><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Default Tabs -->
            </div>
        </div>
        <!-- end card -->
    </section>
@endsection
@section('scirpt')
    <script>
        function enableInputText(){
            const inputText = document.getElementById('morecommnet');
            inputText.disabled = !inputText.disabled;
        }

        function getUsersByGrade(grade){
            window.location.href = '{{ route('teacher.select.grade', ['grade' => ':grade']) }}'.replace(':grade', grade);
        }
    </script>
@endsection

