@extends('layouts.home')
@section('content')
    <section class="login" id="login">
        <div class="inner-page">
            <div class="login-container">
                <h1>Login</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <x-text-input id="email" class="login-input" type="email" name="email" :value="old('email')" autofocus
                        autocomplete="username" placeholder="Your Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <div class="password-container" style="display: flex; align-items: center;">
                        <x-text-input id="password" class="login-input" type="password" name="password"
                            autocomplete="current-password" placeholder="Your Password" style="flex: 1;" />
                        <span id="togglePassword" class="toggle-password" style="cursor: pointer; margin-left: 10px;">Show</span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <button class="login-button" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>

    @push('myscript')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // toggle the text
            this.textContent = this.textContent === 'Show' ? 'Hide' : 'Show';
        });
    </script>
    @endpush
@endsection
