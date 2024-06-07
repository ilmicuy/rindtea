@extends('layouts.home')

@section('title')
    Cart | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Register</h1>

    </div>
    <!-- Single Page Header End -->


    <div class="py-5 container-fluid contact">
        <div class="container py-5">
            <div class="p-5 rounded bg-light">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <x-text-input id="name" class="py-3 mb-4 border-0 w-100 form-control" type="text"
                            name="name" :value="old('name')" autofocus autocomplete="name"
                            placeholder="Your Name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                        <x-text-input id="email" class="py-3 mb-4 border-0 w-100 form-control" type="email"
                            name="email" :value="old('email')" autocomplete="username" placeholder="Your Email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />

                        <x-text-input id="password" class="py-3 mb-4 border-0 w-100 form-control" type="password"
                            name="password" autocomplete="current-password" placeholder="Your Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                        <x-text-input id="password_confirmation" class="py-3 mb-4 border-0 w-100 form-control" type="password"
                            name="password_confirmation" autocomplete="new-password" placeholder="Your Confirm Password"/>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                        <button class="py-3 bg-white w-100 btn form-control border-secondary text-primary"
                            type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
