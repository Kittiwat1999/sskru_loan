@extends('layout')
@section('title')
@endsection
@section('content')
    <style>
        #result-list {
            position: absolute;
            z-index: 1000;
            width: 100%;
        }
        #result-list li {
            padding: 8px 12px;
            cursor: pointer;
        }
        #result-list li:hover {
            background-color: #f1f1f1;
        }
    </style>

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">ค้นหาเอกสาร</h5>
                <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="GET" action="{{route('search.document.borrower.student_id')}}">
                        @csrf
                         <div class="position-relative">
                            <input type="text" id="search" name="fullname" class="form-control" placeholder="กรอกชื่อนักศึกษา..." autocomplete="off" value="{{isset($fullname) ? $fullname : '' }}">
                            <ul id="result-list" class="list-group mt-1 d-none"></ul>
                        </div>
                        {{-- <input type="text" name="fullname" placeholder="กรอกชื่อนักศึกษา" title="" value="{{isset($fullname) ? $fullname : '' }}"> --}}
                        <button class="btn btn-sm btn-primary h-100" type="submit" title="Search"><i class="bi bi-search"></i></button>
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
                                <span class="text-dark fw-lighter">{{$borrower['faculty_name']}}</span><br>
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
        const routeTemplate = "{{ route('serach.document.list.document', ['borrower_uid' => '__UID__']) }}";

        function openDocPage(borrowerId){
            window.open(hostName+'/search_document/borrower_documents','_self')
        }

        $(document).ready(function () {
            $('#search').on('keyup', function () {
                let query = $(this).val();

                if (query.length > 1) {
                    $.ajax({
                        url: '{{ route("search") }}',
                        type: 'GET',
                        data: { query: query },
                        success: function (data) {
                            let html = '';

                            if (data.length > 0) {
                                data.forEach(function (item) {
                                    let link = routeTemplate.replace('__UID__', item.encrypted_id);
                                    html += `<a class="list-group-item list-group-item-action" href="${link}">
                                                <span>${item.firstname} ${item.lastname}</span>
                                                <small class="text-dark fw-lighter">${item.student_id}</small><br>
                                                <small class="text-dark fw-lighter">${item.faculty_name}</small><br>
                                                <small class="text-secondary fw-lighter">${item.major_name}</small><br>
                                            </a>`;
                                });
                            } else {
                                html = `<li class="list-group-item text-muted">ไม่พบข้อมูล</li>`;
                            }

                            $('#result-list').html(html).removeClass('d-none');
                        }
                    });
                } else {
                    $('#result-list').html('').addClass('d-none');
                }
            });

            // คลิกเลือกผลลัพธ์
            $(document).on('click', '#result-list a', function () {
                $('#result-list').html('').addClass('d-none');
            });
        });
    </script>
@endsection