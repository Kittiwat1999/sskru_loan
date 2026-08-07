@extends('layouts.guest')
@section('title', 'กู้คืนรหัสผ่าน')
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
                            <img src="assets/img/logo.png" alt="">
                            <span class="d-none d-lg-block">SSKRU Loan</span>
                        </a>
                    </div><!-- End Logo -->

                    <div class="card mb-3 col-md-6">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">กู้คืนรหัสผ่าน</h5>
                                <p class="text-center small">กรุณากรอกอีเมล</p>
                            </div>

                            <form id="form-email" action="{{route('check_email.reset_password')}}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-lg-2 col-form-label">อีเมล</label>
                                    <div class="col-md-8 col-lg-10">
                                        <input name="email" type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="invalid-feedback">กรุณากรอกอีเมล!</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{url('/')}}" class="text-light btn btn-secondary me-2">ยกเลิก</a>
                                    <button id="submit-button" type="submit" class="btn btn-primary">ยืนยัน</button>
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
@endsection

@push('scripts')
<script>
    const formEmail = document.getElementById('form-email');
    const sumbitButton = document.getElementById('submit-button');
    formEmail.addEventListener('submit', () => {
        sumbitButton.disabled = true;
    });
</script>
@endpush