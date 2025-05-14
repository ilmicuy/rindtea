@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5 mb-4" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title">Login</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <div class="modern-checkout py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="variant-filter">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username">
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input id="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="current-password">
                                    <button class="btn btn-outline-light" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Sign In
                                </button>
                                <p class="text-center text-white mt-3">
                                    Belum memiliki akun? <a href="{{ route('register') }}" class="text-primary">Register</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // toggle the icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('errors'))
            Swal.fire({
                title: 'Email atau Password Salah!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
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
</style>
