@extends('layout')
@section('title','manage account')
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">จัดการบัญชีผู้ใช้</h5>
                <div class="row mb-4">
                    <!-- <div class="col-md-2">
                        <label for="privilage" class="col-form-label text-secondary">ประเภทผู้ใช้</label>
                    </div> -->
                    @php
                        $select_privilage = Session::get('select_privilage');
                    @endphp
                    <div class="col-md-4">
                        <select id="select-level-show" class="form-select" aria-label="Default select example" name="privilage" required onchange="getUsersByPrivilage(this.value)">
                            <option {{($select_privilage == "admin") ? 'selected' : '' }} value="admin">แอดมิน</option>
                            <option {{($select_privilage == "employee") ? 'selected' : '' }} value="employee">พนักงานทุนฯ</option>
                            <option {{($select_privilage == "major") ? 'selected' : '' }} value="major">คณะ</option>
                            <option {{($select_privilage == "teacher") ? 'selected' : '' }} value="teacher">อาจารย์ที่ปรึกษา</option>
                            <option {{($select_privilage == "borrower") ? 'selected' : '' }} value="borrower">ผู้กู้</option>
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-3 col-sm-12">
                        <!-- form Modal-->
                        <button type="button" class="btn btn-success w-100"  data-bs-toggle="modal" data-bs-target="#form-modal"><i class="bi bi-plus"></i> เพิ่มผู้ใช้</button>
                        <div class="modal fade" id="form-modal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">เพิ่มผู้ใช้</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form class="row" action="{{route('admin.createUser')}}" method="post">
                                    @csrf
                                    <div class="col-md-5">
                                        <label for="prefix" class="col-form-label">คำนำหน้า</label>
                                        <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
                                            <option value="" disabled selected>---</option>
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                        </select>
                                    </div>

                                    @error('prefix')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="firstname" class="col-form-label">ชื่อ</label>
                                        <input type="text" name="firstname" class="form-control" required>
                                    </div>
                                    @error('firstname')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="lastname" class="col-form-label">นามสกุล</label>
                                        <input type="text" name="lastname" class="form-control" required>
                                    </div>
                                    @error('lanme')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="username" class="col-form-label">ชื่อผู้ใช้</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    @error('username')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="email" class="col-form-label">email</label>
                                        <input type="text" name="email" class="form-control" required>
                                    </div>
                                    @error('email')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="password" class="col-form-label">รหัสผ่าน</label>
                                        <input id="new-input-password" type="password" name="password" class="form-control" required>
                                    </div>
                                    @error('password')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="borrower-type" class="col-form-label text-secondary">ระดับผู้ใช้</label>
                                        <select id="major" class="form-select" aria-label="Default select example" name="privilage" required>
                                            <option selected disabled value="admin">---</option>
                                            <option value="admin">แอดมิน</option>
                                            <option value="employee">พนักงานทุนฯ</option>
                                            <option value="major">คณะ</option>
                                            <option value="teacher">อาจารย์ที่ปรึกษา</option>
                                            <option value="borrower">ผู้กู้</option>
                                        </select>
                                    </div>
                                    @error('privilage')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div><!-- End form Modal-->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable table-striped table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ชื่อ-สกุล</th>
                                <th scope="col">username</th>
                                <th scope="col">สิทธ์การใช้งาน</th>
                                <th scope="col">created_at</th>
                                <th scope="col">update-at</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            gettype($users)
                            ?>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td class="text-dark fw-light">{{$user->prefix}} {{$user->firstname}} {{$user->lastname}}</td>
                                <td>{{$user->username}}</td>
                                <td>
                                    @if($user->privilage == "admin")
                                        แอดมิน
                                    @elseif($user->privilage == "employee")
                                        พนักงานทุนฯ
                                    @elseif($user->privilage == "major")
                                        คณะ
                                    @elseif($user->privilage == "teacher")
                                        อาจารย์ที่ปรึกษา
                                    @elseif($user->privilage == "borrower")
                                        ผู้กู้
                                    @endif
                                </td>
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->updated_at}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="showUserModal({{$user->id}})" ><i class="bi bi-search"></i></button>
                                    <div class="mt-2"></div>
                                    <button id="button-delete-modal" type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteUserModal-{{$user->id}}">
                                        <i class="bi bi-trash"></i>
                                    </button> 

                                    <!-- delete user Modal-->
                                    <div class="modal fade" id="deleteUserModal-{{$user->id}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ลบบัญชีผู้ใช้</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div id="delete-modal-content" class="modal-body">
                                                ต้องการลบข้อมูลของผู้ใช้ {{$user->firstname}}
                                            </div>
                                            <div id="delete-button-area" class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <a class="btn btn-secondary" href="{{route('admin.deleteUser', ['id' => $user->id])}}">ลบบัญชีผู้ใช้</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End delete user Modal-->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

   

    


    <button id="button-showDataModal" class="d-none" type="button" data-bs-toggle="modal" data-bs-target="#showDataModal">
    </button>
    <!-- show user data Modal-->
    <div class="modal fade" id="showDataModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ข้อมูลผู้ใช้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="showDataModal-content" class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end show user data Modal-->

    <script>
                // Function to fetch user by ID
        // const routeUrl = 'http://127.0.0.1:8000/getUser';
        const routeUrl = "{{route('admin.editAccount')}}";
        function getUserById(userid) {

        // Using the fetch API
        fetch(`{{url('admin/getUser/${userid}')}}`)
            .then(response => {
            // Check if the response status is OK (200)
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            // Parse the JSON data in the response
            return response.json();
            })
            .then(user => {
            // Handle the user data
            // console.log(user[0]);
            const modalContent = document.getElementById('showDataModal-content');
            modalContent.innerHTML = `
            <form class="row" action="{{route('admin.editAccount')}}" method="POST">
                @csrf
                <input type="hidden" name="id" class="form-control" value="${user[0].id}" required>
                <div class="col-md-5">
                    <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                    <select id="prefix" name="prefix" class="form-select" aria-label="Default select example">
                        <option >เลือกคำนำหน้าชื่อ</option>
                        <option ${(user[0].prefix == 'นาย')? 'selected': ''} value="นาย">นาย</option>
                        <option ${(user[0].prefix == 'นาง')? 'selected': ''} value="นาง">นาง</option>
                        <option ${(user[0].prefix == 'นางสาว')? 'selected': ''} value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="firstname" class="col-form-label">ชื่อ</label>
                    <input type="text" name="firstname" class="form-control" value="${user[0].firstname}" required>
                </div>
                <div class="col-12">
                    <label for="lastname" class="col-form-label">นามสกุล</label>
                    <input type="text" name="lastname" class="form-control" value="${user[0].lastname}" required>
                </div>
                <div class="col-12">
                    <label for="username" class="col-form-label">ชื่อผู้ใช้</label>
                    <input type="text" name="username" class="form-control" value="${user[0].username}" required>
                </div>
                <div class="col-12">
                    <label for="email" class="col-form-label">email</label>
                    <input type="text" name="email" class="form-control" value="${user[0].email}" required>
                </div>
                <div class="col-10">
                    <label for="password" class="col-form-label">รหัสผ่าน</label>
                    <input id="input-password" type="password" name="password" class="form-control" value="">
                </div>
                <div class="col-2 pt-5">
                    <a onclick="showPassword('input-password')"><i id="icon-input-password" class="bi bi-eye-slash"></i></a>
                </div>
                <div class="col-12">
                    <label for="borrower-type" class="col-form-label text-secondary">ระดับผู้ใช้</label>
                    <select id="select-level-user" class="form-select" aria-label="Default select example" name="privilage" required>
                        <option ${(user[0].privilage == 'admin') ? 'selected':'' } value="admin">แอดมิน</option>
                        <option ${(user[0].privilage == 'employee') ? 'selected':'' } value="employee">พนักงานทุนฯ</option>
                        <option ${(user[0].privilage == 'major') ? 'selected':'' } value="major">คณะ</option>
                        <option ${(user[0].privilage == 'teacher') ? 'selected':'' } value="teacher">อาจารย์ที่ปรึกษา</option>
                        <option ${(user[0].privilage == 'borrower') ? 'selected':'' } value="borrower">ผู้กู้</option>
                    </select>
                </div>
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            `
            // console.log('User by ID:', user);
            })
            .catch(error => {
            // Handle errors
            console.error('Error fetching user:', error);
            });


        }

        function showUserModal(userid){
            console.log(userid)
            getUserById(userid);
            document.getElementById('button-showDataModal').click();

        }

        function showPassword(inputId) {
        var passwordInput = document.getElementById(inputId);
        var iconPassword = document.getElementById('icon-'+inputId);
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconPassword.className = "bi bi-eye"
        } else {
            passwordInput.type = 'password';
            iconPassword.className = "bi bi-eye-slash"
        }
        }

        function getUsersByPrivilage(select_privilage){
            // console.log(privilage);
            window.location.href = '{{ route('admin.manageaccount.privilage', ['select_privilage' => ':select_privilage']) }}'.replace(':select_privilage', select_privilage);
        }


        // Example: Fetch user with ID 123
    </script>
@endsection
