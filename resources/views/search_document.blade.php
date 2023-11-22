@extends('layout')
@section('title')
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ค้นหาเอกสาร</h5>
                <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                        <input type="text" name="query" placeholder="กรอกรหัสนักศึกษา" value="6410014103" title="Enter search keyword">
                        <button class="btn btn-sm btn-primary" type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </div><!-- End Search Bar -->
                <?php 
                  $loan_request = array(
                    array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y/m/d"),'comment'=>array('คำยินยอมผู้แทน'=>'ลายเซ็นไม่ตรงสำเนาบัตร','หนังสือรับรองรายได้'=>'เอกสารไม่ชัดเจน')),
                  )
                ?>
                <div class="col-md-12"><p class="text-secondary mt-3 mb-3">ผลลัพธ์การค้นหา</p></div>

                <!-- start result table   -->
                <div class="table-responsive">
                <!-- Dark Table -->
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">รหัสนักศึกษา</th>
                        <th scope="col">ชื่อ-สกุล</th>
                        <th scope="col">สังกัดนักศึกษา</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1?>
                    @foreach($loan_request as $borrower)
                    <tr onclick="openDocPage({{$borrower['id']}})">
                        <td>{{ $i++ }}</td>
                        <td>{{$borrower['id']}}</td>
                        <td>
                            <span>{{$borrower['name']}}</span><br>
                        </td>
                        <td>
                            <span class="text-secondary fw-lighter">คณะ: {{$borrower['faculty']}}</span><br>
                            <span class="text-secondary fw-lighter">สาขา: {{$borrower['major']}}</span><br>
                            <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                        </td>
                    </tr>
                    @endforeach
                        
                    </tbody>
                </table>
                </div>
                <!-- start result table   -->
            </div>
        </div>
    </section>
    <script>
        function openDocPage(borrowerId){
            window.open(hostName+'/search_document/borrower_documents','_self')
        }
    </script>
@endsection