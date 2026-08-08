@extends('layouts.guest')

@section('title')
ยอมรับนโยบาย
@endsection

@section('content')

<div class="container-fluid py-4 acceptance-page">

    <div class="row justify-content-center">

        <div class="col-12 col-lg-8">

            <div class="text-center mb-4">

                <h2 class="fw-bold mb-2">
                    ยอมรับนโยบาย
                </h2>

                <p class="text-muted mb-0">
                    กรุณาอ่านและยอมรับนโยบายทั้งหมดก่อนเข้าใช้งานระบบ
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('policies.acceptance.accept') }}">

                @csrf

                <div
                    data-bs-spy="scroll"
                    data-bs-target="#policy-toc"
                    data-bs-offset="120"
                    tabindex="0">

                    @foreach($policies as $policy)

                    <section
                        id="policy-{{ $policy->type }}"
                        class="card shadow-sm border-0 mb-4"
                        style="scroll-margin-top:120px;">
                        
                        <div class="card-header bg-white">

                            <h4 class="mb-1">
                                {{ $policy->type_enum->label() }}
                            </h4>

                            <small class="text-muted">

                                Version {{ $policy->version }}

                                <span class="mx-2">
                                    •
                                </span>

                                Effective

                                {{ optional($policy->effective_at)->format('d/m/Y') }}

                            </small>

                        </div>

                        <div class="card-body">

                            {!! $policy->content_html !!}

                        </div>

                    </section>

                    @endforeach

                </div>

                <div class="card shadow-sm border-0 mt-4">

                    <div class="card-body p-3">

                        <div class="form-check">

                            <input
                                id="accepted"
                                class="form-check-input"
                                type="checkbox"
                                name="accepted"
                                value="1">

                            <label
                                class="form-check-label"
                                for="accepted">

                                ข้าพเจ้าได้อ่านและยอมรับข้อกำหนดการใช้งาน
                                นโยบายความเป็นส่วนตัว
                                และนโยบายคุ้มครองข้อมูลส่วนบุคคลทั้งหมด

                            </label>

                        </div>

                    </div>

                </div>

                <div class="d-grid mt-4 mb-5">

                    <button
                        id="acceptButton"
                        type="submit"
                        class="btn btn-primary btn-lg"
                        disabled>

                        ยอมรับนโยบาย

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('styles')

<style>
    .acceptance-page {

        background: #f6f9ff;
        min-height: 100vh;

    }

    .card {

        border-radius: .75rem;

    }

    .card-body {

        line-height: 1.8;

    }

    .card-body h1,
    .card-body h2,
    .card-body h3,
    .card-body h4 {

        margin-top: 1.5rem;

    }

    .card-body img {

        max-width: 100%;
        height: auto;

    }

    .nav-pills .nav-link {

        color: #6c757d;

    }

    .nav-pills .nav-link.active {

        font-weight: 600;

    }
</style>

@endpush

@push('scripts')

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const checkbox =
                document.getElementById(
                    'accepted'
                );

            const button =
                document.getElementById(
                    'acceptButton'
                );

            checkbox.addEventListener(
                'change',
                function() {

                    button.disabled = !this.checked;

                }
            );
        }
    );

</script>

@endpush