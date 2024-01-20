<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ลงทะเบียน</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">SSKRU Loan</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">สร้างบัญชีผู้ใช้</h5>
                    <p class="text-center small">กรุณากรอกรายละเอียด เพื่อสร้างบัญชีผู้ใช้</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate>

                    <div class="col-md-2">
                      <label for="prefix" class="col-form-label text-secondary">คำนำหน้า</label>
                      <select id="prefix" name="prefix" class="form-select" aria-label="Default select example" required>
                          <option class="text-center" selected>-</option>
                          <option class="text-center" value="นาย">นาย</option>
                          <option class="text-center" value="นาง">นาง</option>
                          <option class="text-center" value="นางสาว">นางสาว</option>
                      </select>
                  </div>

                    <div class="col-md-4">
                        <label for="fname" class="col-form-label text-secondary">ชื่อ</label>
                        <input type="text" name="fname" class="form-control" id="fname" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อ!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="lname" class="col-form-label text-secondary">นามสกุล</label>
                        <input type="text" name="lname" class="form-control" id="lname" required>
                        <div class="invalid-feedback">กรุณากรอกนามสกุล!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="birthdate" class="col-form-label text-secondary">วันเกิด</label>
                        <input type="date" name="birthdate" class="form-control" id="birthdate" required>
                        <div class="invalid-feedback">กรุณาเลือกวันเกิด!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="faculty" class="col-form-label text-secondary">คณะ</label>
                        <select id="faculty" name="faculty" class="form-select" aria-label="Default select example" required>
                            <option selected>เลือกคณะ</option>
                            <option value="คณะมนุษยศาสตร์และสังคมศาสตร์">คณะมนุษยศาสตร์และสังคมศาสตร์</option>
                            <option value="คณะพยาบาลศาสตร์">คณะพยาบาลศาสตร์</option>
                            <option value="วิทยาลัยกฎหมายและการปกครอง">วิทยาลัยกฎหมายและการปกครอง</option>
                            <option value="คณะบริหารธุรกิจและการบัญชี">คณะบริหารธุรกิจและการบัญชี</option>
                            <option value="คณะครุศาสตร์">คณะครุศาสตร์</option>
                            <option value="คณะศิลปศาสตร์และวิทยาศาสตร์">คณะศิลปศาสตร์และวิทยาศาสตร์</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="major" class="col-form-label text-secondary">สาขา</label>
                        <select id="major" name="major" class="form-select" aria-label="Default select example" required>
                            <option selected>เลือกสาขา</option>
                            <option>- คณะมนุษยศาสตร์และสังคมศาสตร์ -</option>
                            <option value="สาขาวิชาการพัฒนาชุมชน">สาขาวิชาการพัฒนาชุมชน</option>
                            <option value="สาขาวิชาภาษาอังกฤษธุรกิจ">สาขาวิชาภาษาอังกฤษธุรกิจ</option>
                            <option value="สาขาวิชาภาษาญี่ปุ่น">สาขาวิชาภาษาญี่ปุ่น</option>
                            <option value="สาขาวิชาภาษาจีน">สาขาวิชาภาษาจีน</option>
                            <option value="สาขาวิชาการจัดการสารสนเทศดิจิทัล">สาขาวิชาการจัดการสารสนเทศดิจิทัล</option>
                            <option value="สาขาวิชาศิลปะและการออกแบบ">สาขาวิชาศิลปะและการออกแบบ</option>
                            <option value="สาขาวิชาประวัติศาสตร์">สาขาวิชาประวัติศาสตร์</option>
                            <option value="สาขาวิชาภาษาไทยเพื่อการสื่อสาร">สาขาวิชาภาษาไทยเพื่อการสื่อสาร</option>
                            <option value="สาขาวิชานิเทศศาสตร์">สาขาวิชานิเทศศาสตร์</option>
                            <option>- คณะพยาบาลศาสตร์ -</option>
                            <option value="สาขาวิชาพยาบาล">สาขาวิชาพยาบาล</option>
                            <option>- วิทยาลัยกฎหมายและการปกครอง -</option>
                            <option value="สาขาวิชาพนิติศาสตร์">สาขาวิชาพนิติศาสตร์</option>
                            <option value="สาขาวิชารัฐศาสตร์">สาขาวิชารัฐศาสตร์</option>
                            <option value="สาขาวิชารัฐประศาสนศาสตร์">สาขาวิชารัฐประศาสนศาสตร์</option>
                            <option>- คณะบริหารธุรกิจและการบัญชี -</option>
                            <option value="สาขาวิชาการจัดการ">สาขาวิชาการจัดการ</option>
                            <option value="สาขาวิชาการตลาด">สาขาวิชาการตลาด</option>
                            <option value="สาขาวิชาคอมพิวเตอร์ธุรกิจดิจิทัล">สาขาวิชาคอมพิวเตอร์ธุรกิจดิจิทัล</option>
                            <option value="สาขาวิชาการบริหารธุรกิจระหว่างประเทศ">สาขาวิชาการบริหารธุรกิจระหว่างประเทศ</option>
                            <option value="สาขาวิชาการจัดการธุรกิจการค้าสมัยใหม่">สาขาวิชาการจัดการธุรกิจการค้าสมัยใหม่</option>
                            <option value="สาขาวิชาบัญชี">สาขาวิชาบัญชี</option>
                            <option value="สาขาวิชาการท่องเที่ยวและการโรงแรม">สาขาวิชาการท่องเที่ยวและการโรงแรม</option>
                            <option>- คณะครุศาสตร์ -</option>
                            <option value="สาขาวิชาภาษาอังกฤษ">สาขาวิชาภาษาอังกฤษ</option>
                            <option value="สาขาวิชาการศึกษาปฐมวัย">สาขาวิชาการศึกษาปฐมวัย</option>
                            <option value="สาขาวิชาคอมพิวเตอร์ศึกษา">สาขาวิชาคอมพิวเตอร์ศึกษา</option>
                            <option value="สาขาวิชาคณิตศาสตร์">สาขาวิชาคณิตศาสตร์</option>
                            <option value="สาขาวิชาประถมศึกษา">สาขาวิชาประถมศึกษา</option>
                            <option value="สาขาวิชาภาษาไทย">สาขาวิชาภาษาไทย</option>
                            <option value="สาขาวิชาสังคมศึกษา">สาขาวิชาสังคมศึกษา</option>
                            <option value="สาขาวิชาวิทยาศาสตร์ทั่วไป">สาขาวิชาวิทยาศาสตร์ทั่วไป</option>
                            <option value="สาขาวิชาพลศึกษา">สาขาวิชาพลศึกษา</option>
                            <option value="สาขาวิชาดนตรีศึกษา">สาขาวิชาดนตรีศึกษา</option>
                            <option value="สาขาวิชาการสอนภาษาจีน">สาขาวิชาการสอนภาษาจีน</option>
                            <option value="สาขาวิชนาฏศิลป์ศึกษา">สาขาวิชนาฏศิลป์ศึกษา</option>
                            <option value="สาขาการบริหารการศึกษา">สาขาการบริหารการศึกษา</option>
                            <option value="สาขาวิชาการบริหารการศึกษา">สาขาวิชาการบริหารการศึกษา</option>
                            <option>- คณะศิลปศาสตร์และวิทยาศาสตร์ -</option>
                            <option value="สาขาวิชาวิทยาการคอมพิวเตอร์">สาขาวิชาวิทยาการคอมพิวเตอร์</option>
                            <option value="สาขาวิชาเทคโนโลยีคอมพิวเตอร์และดิจิทัล">สาขาวิชาเทคโนโลยีคอมพิวเตอร์และดิจิทัล</option>
                            <option value="สาขาวิชาสาธารณสุขชุมชน">สาขาวิชาสาธารณสุขชุมชน</option>
                            <option value="สาขาวิชาวิทยาศาสตร์การกีฬา">สาขาวิชาวิทยาศาสตร์การกีฬา</option>
                            <option value="สาขาวิชาเทคโนโลยีการเกษตร">สาขาวิชาเทคโนโลยีการเกษตร</option>
                            <option value="สาขาวิชาเทคโนโลยีและนวัตกรรมอาหาร">สาขาวิชาเทคโนโลยีและนวัตกรรมอาหาร</option>
                            <option value="สาขาวิชาอาชีวอนามัยและความปลอดภัย">สาขาวิชาอาชีวอนามัยและความปลอดภัย</option>
                            <option value="สาขาวิชาวิศวกรรมซอฟต์แวร์">สาขาวิชาวิศวกรรมซอฟต์แวร์</option>
                            <option value="สาขาวิชาวิศวกรรมโลจิสติกส์">สาขาวิชาวิศวกรรมโลจิสติกส์</option>
                            <option value="สาขาวิชาวิศวกรรมการจัดการอุตสาหกรรมและสิ่งแวดล้อม">สาขาวิชาวิศวกรรมการจัดการอุตสาหกรรมและสิ่งแวดล้อม</option>
                            <option value="สาขาวิชาการออกแบบผลิตภัณฑ์และนวัตกรรมวัสดุ">สาขาวิชาการออกแบบผลิตภัณฑ์และนวัตกรรมวัสดุ</option>
                            <option value="สาขาวิชาเทคโนโลยีโยธาและสถาปัตยกรรม">สาขาวิชาเทคโนโลยีโยธาและสถาปัตยกรรม</option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="grade" class="col-form-label text-secondary">ชั้นปี</label>
                        <select id="grade" name="grade" class="form-select" aria-label="Default select example" required>
                            <option selected>เลือกชั้นปี</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                      <label for="username" class="col-form-label text-secondary">ชื่อผู้ใช้</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อผู้ใช้!</div>
                      </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="col-form-label text-secondary">อึเมล</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">กรุณากรอกอีเมล!</div>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="col-form-label text-secondary">รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">กรุณากรอกรหัสผ่าน!</div>
                    </div>

                    <div class="col-md-6 pb-3">
                        <label for="confirm_password" class="col-form-label text-secondary">ยืนยันรหัสผ่าน</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                        <span id="passwordError" class="text-danger"></span>
                        <div class="invalid-feedback">กรุณายืนยันรหัสผ่าน!</div>
                    </div>

                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <button class="btn btn-primary w-100" type="submit" value="Register" onclick="return validatePassword()">สร้างบัญชี</button>
                    </div>
                    <div class="col-md-4"></div>

                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                      <p class="small mb-0">มีบัญชีแล้ว? <a href="{{url('/login_student')}}">ล็อกอิน</a></p>
                    </div>
                    <div class="col-md-4"></div>
                    
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
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  {{--  --}}
  <script>
    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        var passwordError = document.getElementById("passwordError");

        if (password !== confirm_password) {
            passwordError.innerHTML = "รหัสผ่านไม่ตรงกัน";
            return false;
        } else {
            passwordError.innerHTML = "";
            return true;
        }
    }
</script>

</body>

</html>