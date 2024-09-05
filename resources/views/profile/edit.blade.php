{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}


@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <section class="login" id="profile-edit">
        <div class="inner-page">
            <div class="login-container">
                <h1>Edit Profile</h1>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <x-text-input id="name" class="login-input" type="text" name="name"
                        :value="old('name', auth()->user()->name)" autofocus autocomplete="name" placeholder="Your Name" required/>
                    {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}

                    <x-text-input id="email" class="login-input" type="email" name="email"
                        :value="old('email', auth()->user()->email)" autocomplete="username" placeholder="Your Email" required/>
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}

                    <x-text-input id="phone_number" class="login-input" type="tel" name="phone_number"
                        :value="old('phone_number', auth()->user()->phone_number)" autocomplete="phone_number" placeholder="Contoh: 08123456789" required/>
                    {{-- <x-input-error :messages="$errors->get('phone_number')" class="mt-2" /> --}}

                    <div class="password-container" style="display: flex; align-items: center;">
                        <x-text-input id="password" class="login-input" type="password"
                            name="password" autocomplete="new-password" placeholder="New Password (optional)" style="flex: 1;"/>
                        <span id="togglePassword" class="toggle-password" style="cursor: pointer; margin-left: 10px;">Show</span>
                    </div>
                    {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}

                    <div class="password-container" style="display: flex; align-items: center;">
                        <x-text-input id="password_confirmation" class="login-input" type="password"
                            name="password_confirmation" autocomplete="new-password" placeholder="Confirm New Password" style="flex: 1;"/>
                        <span id="togglePasswordConfirmation" class="toggle-password" style="cursor: pointer; margin-left: 10px;">Show</span>
                    </div>
                    {{-- <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /> --}}

                    <button class="login-button" type="submit">Update</button>
                </form>

                <!-- Add Address Button -->
                <div style="margin-top: 20px;">
                    <a href="{{ url('/address') }}" class="login-button" style="display: inline-block; text-align: center; text-decoration: none;">
                        Tambah Alamat
                    </a>
                </div>
            </div>
        </div>
    </section>


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
            this.textContent = this.textContent === 'Show' ? 'Hide' : 'Show';
        });

        togglePasswordConfirmation.addEventListener('click', function () {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.textContent = this.textContent === 'Show' ? 'Hide' : 'Show';
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += `<li style="list-style-position: inside; padding-left: 0;">{{ ucwords($error) }}</li>`;
                @endforeach

                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    html: `
                        <ul>
                            ${errorMessages}
                        </ul>
                    `,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            // Show success message if there is a status in the session
            @if (session('status'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('status') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    @endpush
@endsection
