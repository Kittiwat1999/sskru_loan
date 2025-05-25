<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>เข้าสู่ระบบ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="เข้าสู่ระบบเพื่อใช้งานระบบกู้ยืมเงินเพื่อการศึกษา (กยศ.) ของมหาวิทยาลัยราชภัฏศรีสะเกษ นักศึกษาสามารถลงทะเบียน ยื่นคำขอ ตรวจสอบสถานะ และติดตามผลได้ง่าย ๆ ผ่านระบบออนไลน์ ปลอดภัย ใช้งานได้ตลอด 24 ชั่วโมง">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Updated: May 30 2023 with Bootstrap v5.3.0
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

    <main>
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger" id="error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    // Wait for 3000 milliseconds (3 seconds) and then remove the element
                    // setTimeout(function() {
                    //     const elementToRemove = document.getElementById('error-alert');
                    //     if (elementToRemove) {
                    //         elementToRemove.remove();
                    //     }
                    // }, 3000);
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
                    }, 5000);
                </script>
            @endif
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            
                            <div class="card mb-3">
                                
                                <div class="card-body">
                                    
                                    <div class="pt-4">
                                        <div class="d-flex justify-content-center mb-3">
                                            <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                                                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                                                <span class="d-none d-lg-block">SSKRU LOAN</span>
                                            </a>
                                        </div><!-- End Logo -->
                                        <h5 class="text-center text-secondary py-0">เข้าสู่ระบบ</h5>
                                        <!-- <p class="text-center small">Enter your username & password to login</p> -->
                                        
                                    </div>

                                    <form id="login-form" action="{{ route('post.login') }}" class="row g-3" novalidate
                                        method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <label for="email" class="col-form-label text-secondary">อีเมลล์</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email" class="form-control" id="email"
                                                    required>
                                                <div id="invalid-email" class="invalid-feedback">กรุณากรอกอีเมลล์!</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="col-form-label text-secondary">รหัสผ่าน</label>
                                            <div class="input-group">
                                                <input type="password" id="password" class="form-control"
                                                    name="password">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            </div>
                                            <div id="invalid-password" class="invalid-feedback">กรุณากรอกรหัสผ่าน!</div>
                                            <div class="text-start mt-2">
                                                <a href="{{ url('/reset_password/email') }}"
                                                    class="text-secondary text-decoration-underline"><small>ลืมรหัสผ่าน....</small></a>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" id="submit-button" class="btn btn-primary w-100"
                                                type="button">ล็อกอิน</button>
                                        </div>

                                        <div class="col-12">
                                            <p class="mb-0" align="center">นักศึกษา
                                                <a href="{{ url('/register_student') }}" class="text-decoration-underline">ลงทะเบียนเข้าใช้งานระบบ</a>
                                            </p>
                                            
                                        </div>
                                        <div class="col-12 text-center">
                                            <small>ระบบกู้ยืมเพื่อการศึกษา</small><br>
                                            <small>มหาวิทยาลัยราชภัฏศรีสะเกษ</small>
                                            <small>เข้าสู่ระบบเพื่อยื่นคำขอกู้ยืม กยศ. ตรวจสอบสถานะ และติดตามผลการอนุมัติ</small>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                                
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
<script>
    const login_button = document.getElementById('submit-button');
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');
    const login_form = document.getElementById('login-form');

    togglePasswordButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>' ;
    });

    login_form.addEventListener('submit', function(event) {
        login_button.disabled = true;
        login_button.innerText = 'กำลังล็อกอิน...';
        event.preventDefault();
        
        if(validationSubmitForm(this)){
            this.submit();
        }
    });

    function validationSubmitForm (login_form) {
        var email = login_form.querySelector('#email');
        var password = login_form.querySelector('#password');
        var invalid_email = document.getElementById('invalid-email');
        var invalid_password = document.getElementById('invalid-password');
        var validator = true;
    
        if (email.value == '') {
            validator = false;
            email.classList.add('is-invalid');
            if (invalid_email) invalid_email.classList.add('d-inline');
        } else {
            email.classList.remove('is-invalid');
            email.classList.add('is-valid'); // Optional, for valid feedback
            if (invalid_email) invalid_email.classList.remove('d-inline');
        }
    
        if (password.value == '') {
            validator = false;
            password.classList.add('is-invalid');
            if (invalid_password) invalid_password.classList.add('d-inline');
        } else {
            password.classList.remove('is-invalid');
            password.classList.add('is-valid'); // Optional, for valid feedback
            if (invalid_password) invalid_password.classList.remove('d-inline');
        }

        if (validator) {
            return true;
        }

        return false;
    }
</script>

</html>
