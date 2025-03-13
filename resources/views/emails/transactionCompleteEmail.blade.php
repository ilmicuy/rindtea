@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Pesanan Anda Telah Sampai!</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0;">Status: Pesanan Selesai</h2>
    @endcomponent

    <p>Hai {{ $user->name }},</p>

    <p>Pesanan Anda dengan kode transaksi #{{ $transaction->kode_transaksi }} telah sampai di tujuan.</p>

    <p>Terima kasih telah berbelanja di Rind Tea. Kami harap Anda puas dengan produk dan layanan kami.</p>

    @component('mail::button', ['url' => route('transaction.show', $transaction->id)])
        Lihat Detail Pesanan
    @endcomponent

    <p>Hormat Kami,<br>Tim Rind Tea</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
