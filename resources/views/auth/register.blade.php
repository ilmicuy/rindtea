@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5 mb-4" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title">Register</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
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
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name</label>
                                <input id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    autocomplete="name">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="username">
                            </div>

                            <div class="mb-4">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input id="phone_number"
                                    type="tel"
                                    class="form-control"
                                    name="phone_number"
                                    value="{{ old('phone_number') }}"
                                    required
                                    autocomplete="phone_number"
                                    placeholder="Example: 08123456789">
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input id="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="new-password">
                                    <button class="btn btn-outline-light" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input id="password_confirmation"
                                        type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password">
                                    <button class="btn btn-outline-light" type="button" id="togglePasswordConfirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Create Account
                                </button>
                                <p class="text-center text-white mt-3">
                                    Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary">Login</a>
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
    const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
    const passwordConfirmation = document.querySelector('#password_confirmation');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // toggle the icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    togglePasswordConfirmation.addEventListener('click', function () {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);

        // toggle the icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += `<li class="text-start">{{ ucwords($error) }}</li>`;
            @endforeach

            Swal.fire({
                title: 'Registration Error!',
                html: `<ul class="list-unstyled mb-0">${errorMessages}</ul>`,
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

.swal2-html-container ul {
    text-align: left;
    margin: 1em 0 0;
}
</style>
