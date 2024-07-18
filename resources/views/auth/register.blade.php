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

                    <x-text-input id="password" class="login-input" type="password"
                        name="password" autocomplete="current-password" placeholder="Your Password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <x-text-input id="password_confirmation" class="login-input" type="password"
                        name="password_confirmation" autocomplete="new-password" placeholder="Your Confirm Password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <button class="login-button"
                        type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
@endsection

{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
