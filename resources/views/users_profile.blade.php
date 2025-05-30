@extends('layout')
@section('title','users profile')
@section('content')
    <section class="section profile">
        <div class="row">
                <div class="col-xl-4">
                        @php
                         $privilege_map = [
                            'admin' => 'แอดมิน',
                            'employee' => 'พนักงานทุนฯ',
                            'teacher' => 'อาจารย์ที่ปรึกษา',
                            'borrower' => 'ผู้กู้ยืม',
                        ];
                         $role = Session::get('privilege')   
                        @endphp

                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                <img src="{{asset('assets/img/profile-'.$role.'.png')}}" alt="Profile" class="rounded-circle">
                                <h2>{{$user->prefix}}{{$user->firstname}} {{$user->lastname}}</h2>
                                <h3>{{$privilege_map[$role]}}</h3>
                            </div>
                        </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">บัญชี</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">แก้ไขบัญชี</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">เปลี่ยนรหัสผ่าน</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-3">

                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">ชื่อ</div>
                                            <div class="col-lg-9 col-md-8">{{$user->prefix}}{{$user->firstname}} {{$user->lastname}}</div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">อีเมล</div>
                                            <div class="col-lg-9 col-md-8">{{$user->email}}</div>
                                        </div>

                                    </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                        <form action="{{ route('users.profile.edit') }}" method="post">
                                            @csrf

                                            <div class="row mb-3">
                                                <label for="prefix" class="col-md-4 col-lg-3 col-form-label">คำนำหน้า</label>
                                                <div class="col-md-2">
                                                    <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
                                                        <option class="text-center" selected></option>
                                                        <option class="text-center" @selected($user->prefix == 'นาย') value="นาย">นาย</option>
                                                        <option class="text-center" @selected($user->prefix == 'นาง') value="นาง">นาง</option>
                                                        <option class="text-center" @selected($user->prefix == 'นางสาว') value="นางสาว">นางสาว</option>
                                                    </select>
                                                    <div class="invalid-feedback">กรุณาเลือกคำนำหน้า</div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="firstname" class="col-md-4 col-lg-3 col-form-label">ชื่อ</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="firstname" type="text" class="form-control" id="firstname" value={{$user->firstname}} required>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกชื่อ</div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="lastname" class="col-md-4 col-lg-3 col-form-label">นามสกุล</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="lastname" type="text" class="form-control" id="lastname" value={{$user->lastname}} required>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกนามสกุล</div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Email" class="col-md-4 col-lg-3 col-form-label">อีเมล</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="email" type="email" class="form-control" id="Email" value={{$user->email}} required>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกอีเมล</div>
                                            </div>
                                            @method('PUT')
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                            </div>
                                        </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form method="POST" action="{{ route('users.password.change') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="current_password" class="col-md-4 col-lg-3 col-form-label">รหัสผ่านปัจจุบัน</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <input name="current_password" type="password" class="form-control" id="current_password" required>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="toggleCurrentPassword">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">กรุณากรอกรหัสผ่านปัจจุบัน</div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="new_password" class="col-md-4 col-lg-3 col-form-label">รหัสผ่านใหม่</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <input name="new_password" type="password" class="form-control" id="new_password" required>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="toggleNewPassword">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">กรุณากรอกรหัสผ่านใหม่</div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="new_password_confirmation" class="col-md-4 col-lg-3 col-form-label">ยืนยันรหัสผ่านใหม่</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="input-group">
                                                    <input name="new_password_confirmation" type="password" class="form-control" id="new_password_confirmation" required>
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="toggleConfPassword">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <span id="passwordStatus"></span>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">กรุณายืนยันรหัสผ่านใหม่</div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary" onclick="return validatePassword()">บันทึก</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const newConfPassword = document.getElementById('new_password_confirmation');
        const toggleCurrentPasswordButton = document.getElementById('toggleCurrentPassword');
        const togglePasswordButton = document.getElementById('toggleNewPassword');
        const toggleConfPasswordButton = document.getElementById('toggleConfPassword');
        
        newPassword.addEventListener("input", validatePassword);
        newConfPassword.addEventListener("input", validatePassword);

        toggleCurrentPasswordButton.addEventListener('click', function() {
            const type = currentPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            currentPassword.setAttribute('type', type);

            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>' ;
        });

        togglePasswordButton.addEventListener('click', function() {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);

            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>' ;
        });

        toggleConfPasswordButton.addEventListener('click', function() {
            const type = newConfPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newConfPassword.setAttribute('type', type);

            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>' ;
        });

        function validatePassword() {
            var password = document.getElementById("new_password").value;
            var confirm_password = document.getElementById("new_password_confirmation").value;
            var passwordStatus = document.getElementById("passwordStatus");

            if (password === "") {
                passwordStatus.innerHTML = "กรุณากรอกข้อมูลรหัสผ่านก่อน";
                passwordStatus.classList.remove("text-success");
                passwordStatus.classList.add("text-danger");
            } else if (confirm_password === "") {
                passwordStatus.innerHTML = "กรุณายืนยันรหัสผ่าน";
                passwordStatus.classList.remove("text-success");
                passwordStatus.classList.add("text-danger");
            } else if (password !== confirm_password) {
                passwordStatus.innerHTML = "รหัสผ่านไม่ตรงกัน";
                passwordStatus.classList.remove("text-success");
                passwordStatus.classList.add("text-danger");
            } else {
                passwordStatus.innerHTML = "รหัสผ่านตรงกัน";
                passwordStatus.classList.remove("text-danger");
                passwordStatus.classList.add("text-success");
            }

            if (password.length < 8){
                passwordStatus.innerHTML = "รหัสผ่านต้องมีอย่างน้อย 8 ตัว";
                passwordStatus.classList.remove("text-success");
                passwordStatus.classList.add("text-danger");
            }
        }
    </script>
@endsection
