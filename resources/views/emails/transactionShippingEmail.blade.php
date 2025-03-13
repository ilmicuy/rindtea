@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Pesanan Anda Telah Dikirim!</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0;">Status: Dalam Pengiriman</h2>
        <p style="margin-bottom: 0;">Nomor Resi: {{ $trackingNumber }}</p>
    @endcomponent

    <p>Hai {{ $user->name }},</p>

    <p>Pesanan Anda dengan kode transaksi #{{ $transaction->kode_transaksi }} telah dikirim dan sedang dalam perjalanan.</p>

    <p>Anda dapat melacak status pengiriman pesanan Anda menggunakan nomor resi yang tertera di atas melalui website kami.</p>

    @component('mail::button', ['url' => route('transaction.show', $transaction->id)])
        Lacak Pesanan
    @endcomponent

    <p>Hormat Kami,<br>Tim Rind Tea</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
