@extends('layouts.home')
@section('content')
    <section class="login" id="login">
        <div class="inner-page">
            <div class="login-container">
                <h1>Register</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <x-text-input id="name" class="login-input" type="text" name="name"
                        :value="old('name')" autofocus autocomplete="name" placeholder="Your Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <x-text-input id="email" class="login-input" type="email" name="email"
                        :value="old('email')" autocomplete="username" placeholder="Your Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <x-text-input id="phone_number" class="login-input" type="tel" name="phone_number"
                        :value="old('phone_number')" autocomplete="phone_number" placeholder="Contoh: 08123456789" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />

                    <div class="password-container" style="display: flex; align-items: center;">
                        <x-text-input id="password" class="login-input" type="password"
                            name="password" autocomplete="new-password" placeholder="Your Password" style="flex: 1;" />
                        <span id="togglePassword" class="toggle-password" style="cursor: pointer; margin-left: 10px;">Show</span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <div class="password-container" style="display: flex; align-items: center;">
                        <x-text-input id="password_confirmation" class="login-input" type="password"
                            name="password_confirmation" autocomplete="new-password" placeholder="Your Confirm Password" style="flex: 1;" />
                        <span id="togglePasswordConfirmation" class="toggle-password" style="cursor: pointer; margin-left: 10px;">Show</span>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <button class="login-button" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>

    @push('myscript')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = this.textContent === 'Show' ? 'Hide' : 'Show';
        });

        togglePasswordConfirmation.addEventListener('click', function () {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.textContent = this.textContent === 'Show' ? 'Hide' : 'Show';
        });
    </script>
    @endpush
@endsection
