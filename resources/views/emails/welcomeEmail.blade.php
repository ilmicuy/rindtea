@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Selamat Datang di Rind Tea!</h1>

    <p>Hai {{ $user->name }},</p>

    <p>Terimakasih sudah melakukan registrasi di website Rind Tea. Kini anda dapat melakukan pemesanan produk Rind Tea melalui website kami.</p>

    @component('mail::button', ['url' => config('app.url')])
        Kunjungi Website
    @endcomponent

    <p>Hormat Kami,<br>Tim Rind Tea</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
