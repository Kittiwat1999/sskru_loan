@extends('layouts.guest')
@section('title', 'ลงทะเบียนเสร็จสิ้น')
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
                    <div class="card mb-3 col-md-6">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <lottie-player src="https://lottie.host/6c0153c3-7f1e-4ba7-9a17-c4da425371cd/SyqM5lEOZ9.json" background="##ffffff" speed="1" style="width: 200px; height: 200px" autoplay direction="1" mode="normal"></lottie-player>
                            </div>

                            <span class="d-flex justify-content-center pb-4 display-6">ลงทะเบียนเสร็จสิ้น</span>

                            <div class="d-flex justify-content-center pt-2">
                                <a href="{{url('/login')}}" class="text-light btn btn-primary">เข้าสู่ระบบตอนนี้</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->
@endsection