@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5 mb-4" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title">Verifikasi Email</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Verifikasi Email</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <div class="modern-checkout py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="variant-filter">
                        <h2 class="text-center mb-4">Verifikasi Email Anda</h2>

                        @if (auth()->user() && !auth()->user()->hasVerifiedEmail())
                            <div class="text-center mb-4">
                                <p class="text-white mb-4">
                                    {{ __('Silahkan untuk verifikasi email dengan cara menekan link yang telah dikirimkan ke email anda.') }}
                                </p>

                                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                                    @csrf
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            {{ __('Kirim Ulang Email Verifikasi') }}
                                        </button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-outline-light btn-lg">
                                            {{ __('Logout') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<style>
.form-control {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 0.8rem 1rem;
}

.form-control:focus {
    background-color: rgba(255, 255, 255, 0.08);
    border-color: var(--primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.25);
    color: #fff;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-label {
    color: #fff;
    margin-bottom: 0.5rem;
}

.btn-outline-light {
    border-color: rgba(255, 255, 255, 0.1);
}

.btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
}

.btn-primary {
    padding: 0.8rem 2rem;
    font-weight: 500;
    border-radius: 5px;
}

.btn-lg {
    width: 100%;
}
</style>
