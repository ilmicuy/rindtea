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

                    <x-text-input id="password" class="login-input" type="password" name="password"
                        autocomplete="current-password" placeholder="Your Password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <button class="login-button" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
@endsection
