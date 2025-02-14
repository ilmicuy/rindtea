@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <section class="login" id="login">
        <div class="inner-page">
            <div class="login-container">
                <h1>Verifikasi Email</h1>

                {{-- Add this section to handle email verification reminder --}}
                @if (auth()->user() && !auth()->user()->hasVerifiedEmail())
                    <div class="email-verification-notice">
                        <p>{{ __('Silahkan untuk verifikasi email dengan cara menekan link yang telah dikirimkan ke email anda.') }}</p>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button class="login-button" type="submit">{{ __('Resend Verification Email') }}</button>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="login-button" type="submit">{{ __('Log Out') }}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
@endsection
