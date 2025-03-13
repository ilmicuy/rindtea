@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Pesan Baru dari Form Kontak</h1>

    @component('mail::panel')
        <div class="info-item">
            <strong>Nama:</strong>
            <p>{{ $name }}</p>
        </div>
        <div class="info-item">
            <strong>Email:</strong>
            <p>{{ $email }}</p>
        </div>
        <div class="info-item">
            <strong>No. Telepon:</strong>
            <p>{{ $phone }}</p>
        </div>
    @endcomponent

    <h2>Pesan:</h2>
    <p>{{ $message }}</p>

    @component('mail::button', ['url' => config('app.url')])
        Kunjungi Website
    @endcomponent

    <p>Email ini dikirim secara otomatis dari website Rind Tea</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
