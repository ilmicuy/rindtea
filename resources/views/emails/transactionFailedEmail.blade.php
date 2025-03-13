@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Pemesanan Produk Gagal</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0; color: #dc3545;">Status: Gagal</h2>
    @endcomponent

    <p>Hai {{ $user->name }},</p>

    <p>Mohon maaf, pemesanan produk Anda dengan kode transaksi #{{ $transaction->kode_transaksi }} tidak dapat diproses.</p>

    <p>Silakan coba melakukan pemesanan kembali atau hubungi tim support kami jika Anda membutuhkan bantuan.</p>

    @component('mail::button', ['url' => config('app.url'), 'color' => 'error'])
        Kembali ke Website
    @endcomponent

    <p>Hormat Kami,<br>Tim Rind Tea</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
