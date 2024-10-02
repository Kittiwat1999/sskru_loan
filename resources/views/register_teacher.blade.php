<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

  <title>ลงทะเบียน</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

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
                            <img src="assets/img/logo.png" alt="">
                            <span class="d-none d-lg-block">SSKRU Loan</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3 col-md-8">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">สร้างบัญชีผู้ใช้</h5>
                                    <p class="text-center small">กรุณากรอกรายละเอียด เพื่อสร้างบัญชีผู้ใช้</p>
                                </div>

                                <form class="row g-3 needs-validation" action="{{route('register.teacher')}}" method="post" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-3">
                                        <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                                        <input type="text" name="prefix" class="form-control" id="prefix" required>
                                        <div class="invalid-feedback">
                                            กรุณากรอกคำนำหน้า!
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="firstname" class="col-form-label text-secondary">ชื่อ</label>
                                        <input type="text" name="firstname" class="form-control" id="firstname" required>
                                        <div class="invalid-feedback">
                                            กรุณากรอกชื่อ!
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <label for="lastname" class="col-form-label text-secondary">นามสกุล</label>
                                        <input type="text" name="lastname" class="form-control" id="lastname" required>
                                        <div class="invalid-feedback">
                                            กรุณากรอกนามสกุล!
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="email" class="col-form-label text-secondary">อีเมล</label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                        <div class="invalid-feedback">
                                            กรุณากรอกอีเมล!
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="faculty" class="col-form-label text-secondary">คณะ</label>
                                        <select id="faculty" class="form-select" aria-label="Default select example" name="faculty" onchange="getMajorByFacultyId(this.value)" required>
                                            <option selected></option>
                                            @foreach($faculties as $faculty)
                                            <option value="{{$faculty['id']}}">{{$faculty['faculty_name']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณาเลือกคณะ!
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6">
                                        <label for="major" class="col-form-label text-secondary">สาขา</label>
                                        <select id="major" class="form-select" aria-label="Default select example" name="major" required>
                                            <option selected></option>
                                            @foreach($majors as $major)
                                            <option value="{{$major['id']}}">{{$major['major_name']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณาเลือกสาขา!
                                        </div>
                                      </div>

                                    <div class="col-md-7">
                                        <label for="password" class="col-form-label text-secondary">รหัสผ่าน</label>
                                        <input type="password" name="password" class="form-control" id="password" required oninput="checkPasswordFilled()">
                                        <div class="invalid-feedback">
                                            กรุณากรอกรหัสผ่าน!
                                        </div>
                                    </div>

                                    <div class="col-md-7 pb-3">
                                        <label for="password_confirmation" class="col-form-label text-secondary">ยืนยันรหัสผ่าน</label>
                                        <div class="d-flex flex-column flex-md-row justify-content-between">
                                            <div class="col-12 text-start">
                                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required disabled>
                                            </div>
                                            <div class="col-md-6 col-12 mt-2 mt-md-1 mx-md-3">
                                                <span id="passwordStatus" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                            กรุณายืนยันรหัสผ่าน!
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="{{ url('/login_student') }}" class="btn btn-secondary w-25 me-2" style="color: white;">ล็อกอิน</a>
                                        <button class="btn btn-primary w-25" type="submit" value="Register" onclick="return validatePassword()">สร้างบัญชี</button>
                                    </div>

                                </form>
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <script>
        document.getElementById("password").addEventListener("input", validatePassword);
        document.getElementById("password_confirmation").addEventListener("input", validatePassword);
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("password_confirmation").value;
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
        }

        function checkPasswordFilled() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirmation");

            if (password !== "") {
                confirmPassword.removeAttribute("disabled");
            } else {
                confirmPassword.setAttribute("disabled", true);
            }
        }

        function getMajorByFacultyId(faculty_id){
            fetch(`{{url('/register_teacher/getMajorsByFacultyId/${faculty_id}')}}`)
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(majors => {
                var major_element = document.getElementById('major');
                major_element.innerHTML = `<option selected disabled value="admin"></option>`;
                majors.forEach((major) => {
                    var option = document.createElement('option');
                    option.value = major.id;
                    option.innerText = major.major_name;
                    major_element.appendChild(option);
                })
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        }
  </script>

</body>

</html>
