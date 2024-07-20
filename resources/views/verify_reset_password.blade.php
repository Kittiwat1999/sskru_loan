<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ยืนยันตัวตน</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
            <div class="row justify-content-center">
                <section class="container-fluid bg-body-tertiary d-block min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="assets/img/logo.png" alt="">
                        <span class="d-none d-lg-block">SSKRU Loan</span>
                        </a>
                    </div><!-- End Logo -->

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                            <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                                <div class="card-body p-5 text-center">
                                    <h4>ยืนยันตัวตน</h4>
                                    <p>รหัสยืนยัน (OTP) ที่ได้รับทางอีเมล</p>

                                    <form action="{{route('verify.reset_password')}}" method="POST">
                                        @csrf
                                        <div class="otp-field mb-4">
                                            <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 1 2px;" name="code[]" maxlength="1" required />
                                            <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 1 2px;" name="code[]" maxlength="1" disabled />
                                            <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 1 2px;" name="code[]" maxlength="1" disabled />
                                            <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 1 2px;" name="code[]" maxlength="1" disabled />
                                            <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 1 2px;" name="code[]" maxlength="1" disabled />
                                            <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 1 2px;" name="code[]" maxlength="1" disabled />
                                        </div>

                                        <button type="submit" class="btn btn-primary mb-3">
                                            ยืนยัน
                                        </button>
                                    </form>

                                    <p class="resend text-muted mb-0">
                                        หากยังไม่ได้รับรหัส (OTP ?) <a href="#" id="resend-otp-link">กดเพื่อขอรหัส (OTP) ใหม่อีกครั้ง</a> <span id="countdown-timer"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
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
        const inputs = document.querySelectorAll(".otp-field > input");
        const button = document.querySelector(".btn");
        const resendLink = document.getElementById("resend-otp-link");
        const countdownTimer = document.getElementById("countdown-timer");
        let countdown;

        window.addEventListener("load", () => inputs[0].focus());
        button.setAttribute("disabled", "disabled");

        inputs[0].addEventListener("paste", function (event) {
            event.preventDefault();

            const pastedValue = (event.clipboardData || window.clipboardData).getData(
                "text"
            );
            const otpLength = inputs.length;

            for (let i = 0; i < otpLength; i++) {
                if (i < pastedValue.length) {
                    inputs[i].value = pastedValue[i];
                    inputs[i].removeAttribute("disabled");
                    inputs[i].focus();
                } else {
                    inputs[i].value = ""; // Clear any remaining inputs
                    inputs[i].focus();
                }
            }
        });

        inputs.forEach((input, index1) => {
            input.addEventListener("keyup", (e) => {
                const currentInput = input;
                const nextInput = input.nextElementSibling;
                const prevInput = input.previousElementSibling;

                if (currentInput.value.length > 1) {
                    currentInput.value = "";
                    return;
                }

                if (
                    nextInput &&
                    nextInput.hasAttribute("disabled") &&
                    currentInput.value !== ""
                ) {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                if (e.key === "Backspace") {
                    inputs.forEach((input, index2) => {
                        if (index1 <= index2 && prevInput) {
                            input.setAttribute("disabled", true);
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                }

                button.classList.remove("active");
                button.setAttribute("disabled", "disabled");

                const inputsNo = inputs.length;
                if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
                    button.classList.add("active");
                    button.removeAttribute("disabled");

                    return;
                }
            });
        });

        resendLink.addEventListener("click", async (event) => {
            const xhttpr = new XMLHttpRequest();
            xhttpr.open('GET', "{{url('/send_email/reset_password')}}", true);
            xhttpr.send();
            // xhttpr.abort();
            event.preventDefault();
            startCountdown(60); // Start countdown from 60 seconds
        });

        function startCountdown(seconds) {
            resendLink.style.display = "none";
            countdownTimer.textContent = ` ${seconds} วินาที`;
            countdown = setInterval(() => {
                seconds--;
                countdownTimer.textContent = ` ${seconds} วินาที`;
                if (seconds <= 0) {
                    clearInterval(countdown);
                    countdownTimer.textContent = "";
                    resendLink.style.display = "inline";
                }
            }, 1000);
        }

  </script>

</body>

</html>
