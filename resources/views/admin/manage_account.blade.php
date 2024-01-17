@extends('layout')
@section('title','manage account')
@section('content')
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage account</h5>
                <div class="row mb-4">
                    <!-- <div class="col-md-2">
                        <label for="privilage" class="col-form-label text-secondary">ประเภทผู้ใช้</label>
                    </div> -->
                    <div class="col-md-4">
                    <select name="privilage" id="privilage" class="form-select" aria-label="Default select example">
                        <option selected value="admin">admin</option>
                        <option value="employee">employee</option>
                        <option value="major">major</option>
                        <option value="teacher">teacher</option>
                        <option value="borrower">borrower</option>
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
                                <form class="row" action="/createUser" method="post">
                                    @csrf
                                    <div class="col-md-5">
                                        <label for="prefix" class="col-form-label">คำนำหน้า</label>
                                        <select id="prefix" name="prefix" class="form-select" aria-label="Default select example">
                                            <option selected>เลือกคำนำหน้าชื่อ</option>
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
                                        <label for="fname" class="col-form-label">ชื่อ</label>
                                        <input type="text" name="fname" class="form-control" required>
                                    </div>
                                    @error('fname')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="lname" class="col-form-label">นามสกุล</label>
                                        <input type="text" name="lname" class="form-control" required>
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
                                            <option selected value="admin">admin</option>
                                            <option value="employee">employee</option>
                                            <option value="major">major</option>
                                            <option value="teacher">teacher</option>
                                            <option value="borrower">borrower</option>
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
                                <th scope="col">privilage</th>
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
                                <td class="text-dark fw-light">{{$user->prefix}} {{$user->fname}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->privilage}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>{{$user->updated_at}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary"  onclick="showUserDataModal({{$user->id}})"><i class="bi bi-search"></i></button>
                                    <div class="mt-2"></div>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="showDeleteUserModal({{$user->id}}, '{{$user->fname}}')"> <i class="bi bi-trash"></i> </button>
                                    <button style="display:none;" id="button-delete-modal" type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                        <i class="bi bi-trash"></i>
                                    </button> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

   

    <!-- delete user Modal-->
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบบัญชีผู้ใช้</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="delete-modal-content" class="modal-body">
                
            </div>
            <div id="delete-button-area" class="modal-footer">
                <!-- here's render by js -->
                
            </div>
            </div>
        </div>
    </div>
    <!-- End delete user Modal-->


    <button id="button-showDataModal" style="display:none;" type="button" data-bs-toggle="modal" data-bs-target="#showDataModal">
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
        const routeUrl = '{{url('/getUser')}}';
        function getUserById(userId) {
        // Using the fetch API
        fetch(`${routeUrl}/${userId}`)
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
            const modalContent = document.getElementById('showDataModal-content');
            modalContent.innerHTML = `
            <form class="row" action="/editAccount" method="post">
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
                    <label for="fname" class="col-form-label">ชื่อ</label>
                    <input type="text" name="fname" class="form-control" value="${user[0].fname}" required>
                </div>
                <div class="col-12">
                    <label for="lname" class="col-form-label">นามสกุล</label>
                    <input type="text" name="lname" class="form-control" value="${user[0].lname}" required>
                </div>
                <div class="col-12">
                    <label for="username" class="col-form-label">ชื่อผู้ใช้</label>
                    <input type="text" name="username" class="form-control" value="${user[0].username}" required>
                </div>
                <div class="col-12">
                    <label for="username" class="col-form-label">email</label>
                    <input type="text" name="username" class="form-control" value="${user[0].email}" required>
                </div>
                <div class="col-10">
                    <label for="password" class="col-form-label">รหัสผ่าน</label>
                    <input id="input-password" type="password" name="password" class="form-control" value="${user[0].password}" required>
                </div>
                <div class="col-2 pt-5">
                    <a onclick="showPassword('input-password')"><i id="icon-input-password" class="bi bi-eye-slash"></i></a>
                </div>
                <div class="col-12">
                    <label for="borrower-type" class="col-form-label text-secondary">ระดับผู้ใช้</label>
                    <select id="major" class="form-select" aria-label="Default select example" name="privilage" required>
                        <option ${(user[0].privilage == 'admin') ? 'selected':'' } value="admin">admin</option>
                        <option ${(user[0].privilage == 'employee') ? 'selected':'' } value="employee">employee</option>
                        <option ${(user[0].privilage == 'major') ? 'selected':'' } value="major">major</option>
                        <option ${(user[0].privilage == 'teacher') ? 'selected':'' } value="teacher">teacher</option>
                        <option ${(user[0].privilage == 'borrower') ? 'selected':'' } value="borrower">borrower</option>
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
         function showUserDataModal(userid){
            // console.log(userid);

            
            getUserById(userid);
            document.getElementById('button-showDataModal').click();

        }

        function showDeleteUserModal(userid,fname){
            // console.log(userid,fname)
            document.getElementById('delete-modal-content').innerHTML = `ต้องการลบข้อมูลของผู้ใช้ ${fname}`;

            const buttonArea = document.getElementById('delete-button-area');
            buttonArea.innerHTML=`
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ยกเลิก</button>
            <a class="btn btn-secondary" href="${hostName}/deleteUser/${userid}">ลบบัญชีผู้ใช้</a>
            `
            document.getElementById('button-delete-modal').click();

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


        // Example: Fetch user with ID 123
    </script>
@endsection
