@extends('layout')
@section('title')
@endsection
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ค้นหาเอกสาร</h5>
                <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="GET" action="{{route('search.document.borrower.student_id')}}">
                        @csrf
                        <input type="text" name="student_id" placeholder="กรอกรหัสนักศึกษา" title="" value="{{isset($input_id) ? $input_id : '' }}">
                        <button class="btn btn-sm btn-primary" type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </div><!-- End Search Bar -->

                <!-- start result table   -->
                <div class="table-responsive">
                <!-- Dark Table -->
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">รหัสนักศึกษา</th>
                        <th scope="col">ชื่อ-สกุล</th>
                        <th scope="col">สังกัดนักศึกษา</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($borrowers))
                        @forelse($borrowers as $borrower)
                        <tr>
                            <td>{{$borrower['student_id']}}</td>
                            <td>
                                <span>{{$borrower['prefix']}}{{$borrower['firstname']}} {{$borrower['lastname']}}</span><br>
                            </td>
                            <td>
                                <span class="text-secondary fw-lighter">{{$borrower['faculty_name']}}</span><br>
                                <span class="text-secondary fw-lighter">{{$borrower['major_name']}}</span><br>
                                <span class="text-secondary fw-lighter">ชั้นปี: {{$borrower['grade']}}</span><br>
                            </td>
                            <td>
                                <a href="{{route('serach.document.list.document',['borrower_uid' => Crypt::encryptString($borrower['user_id']) ])}}" class="btn btn-primary">ดูเอกสารที่ส่ง</a></a>
                            </td>
                        </tr>
                        @empty
                            <p>ไม่พบข้อมูล</p>
                        @endforelse
    
                    @endif
                        
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