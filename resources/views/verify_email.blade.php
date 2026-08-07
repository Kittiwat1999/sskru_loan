@extends('layouts.guest')
@section('title', 'ยืนยันตัวตน')
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
        <div class="row justify-content-center">
            <section class="container-fluid bg-body-tertiary d-block min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="{{asset('assets/img/logo.png')}}" alt="">
                        <span class="d-none d-lg-block">SSKRU Loan</span>
                    </a>
                </div><!-- End Logo -->

                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                        <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                            <div class="card-body p-5 text-center">
                                <h4>ยืนยันตัวตน</h4>
                                <p>รหัสยืนยัน (OTP) ที่ได้รับทางอีเมล {{session('email')}}</p>

                                <form id="otp-form" action="{{route('verify.email.post')}}" method="POST">
                                    @csrf
                                    <div class="otp-field mb-4">
                                        <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 0;" name="code[]" maxlength="1" required />
                                        <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 0;" name="code[]" maxlength="1" disabled />
                                        <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 0;" name="code[]" maxlength="1" disabled />
                                        <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 0;" name="code[]" maxlength="1" disabled />
                                        <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 0;" name="code[]" maxlength="1" disabled />
                                        <input type="number" class="form-control" style="display: inline-block; width: 15%; margin: 0;" name="code[]" maxlength="1" disabled />
                                    </div>

                                    <button id="submit-button" type="submit" class="btn btn-primary mb-3">
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
@endsection
@push('scripts')
<script>
    const inputs = document.querySelectorAll(".otp-field > input");
    const button = document.querySelector(".btn");
    const resendLink = document.getElementById("resend-otp-link");
    const countdownTimer = document.getElementById("countdown-timer");
    let countdown;

    const otpForm = document.getElementById('otp-form');
    const submitButton = document.getElementById('submit-button');

    window.addEventListener("load", () => inputs[0].focus());
    button.setAttribute("disabled", "disabled");

    inputs[0].addEventListener("paste", function(event) {
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

    resendLink.addEventListener("click", (event) => {
        const xhttpr = new XMLHttpRequest();
        xhttpr.open('GET', "{{url('/send_email')}}", true);
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

    otpForm.addEventListener('submit', () => {
        submitButton.disabled = true;
    })
</script>
@endpush