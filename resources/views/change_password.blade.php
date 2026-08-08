extends('layouts.guest')

@section('title')
    เปลี่ยนรหัสผ่าน
@endsection

@section('content')
<main>
    @if($errors->any())
    <div class="alert alert-danger" id="error-alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <script>
        // Wait for 3000 milliseconds (3 seconds) and then remove the element
        setTimeout(function() {
            const elementToRemove = document.getElementById('error-alert');
            if (elementToRemove) {
                elementToRemove.remove();
            }
        }, 3000);
    </script>
    @endif

    @if (!empty(session('success')))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
    <script>
        // Wait for 3000 milliseconds (3 seconds) and then remove the element
        setTimeout(function() {
            const elementToRemove = document.getElementById('success-alert');
            if (elementToRemove) {
                elementToRemove.remove();
            }
        }, 3000);
    </script>
    @endif
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                            <img src="{{asset('assets/img/logo.png')}}" alt="">
                            <span class="d-none d-lg-block">SSKRU Loan</span>
                        </a>
                    </div><!-- End Logo -->

                    <div class="card mb-3 col-md-6">

                        <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">เปลี่ยนรหัสผ่าน</h5>
                                <p class="text-center small">กรุณากรอกรหัสผ่าน</p>
                            </div>

                            <!-- Change Password Form -->
                            <form method="POST" action="{{ route('change.password') }}">
                                @csrf
                                @method('PUT')
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
                                    <label for="new_password_confirmation" class="col-md-4 col-lg-3 col-form-label">ยืนยันรหัสผ่าน</label>
                                    <div class="col-md-8 col-lg-9">
                                        <div class="input-group">
                                            <input name="new_password_confirmation" type="password" class="form-control" id="new_password_confirmation" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="toggleConfPassword">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                        <span id="passwordError" class="text-danger"></span>
                                    </div>
                                    <div class="invalid-feedback">กรุณายืนยันรหัสผ่าน</div>
                                </div>
                                <span id="passwordStatus"></span>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" onclick="return validatePassword()">บันทึก</button>
                                </div>
                            </form><!-- End Change Password Form -->
                        </div>
                    </div>

                    <div class="credits" align="center">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->
@endsection

@push('scripts')
<script>
    const newPassword = document.getElementById('new_password');
    const newConfPassword = document.getElementById('new_password_confirmation');
    const togglePasswordButton = document.getElementById('toggleNewPassword');
    const toggleConfPasswordButton = document.getElementById('toggleConfPassword');

    newPassword.addEventListener("input", validatePassword);
    newConfPassword.addEventListener("input", validatePassword);

    togglePasswordButton.addEventListener('click', function() {
        const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        newPassword.setAttribute('type', type);

        this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });

    toggleConfPasswordButton.addEventListener('click', function() {
        const type = newConfPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        newConfPassword.setAttribute('type', type);

        this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });


    function validatePassword() {
        var password = newPassword.value;
        var confirm_password = newConfPassword.value;
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

        if (password.length < 8) {
            passwordStatus.innerHTML = "รหัสผ่านต้องมีอย่างน้อย 8 ตัว";
            passwordStatus.classList.remove("text-success");
            passwordStatus.classList.add("text-danger");
        }
    }

    function checkPasswordFilled() {
        var password = newPassword.value;
        var confirmPassword = newConfPassword;

        if (password !== "") {
            confirmPassword.removeAttribute("disabled");
        } else {
            confirmPassword.setAttribute("disabled", true);
        }
    }
</script>
@endpush