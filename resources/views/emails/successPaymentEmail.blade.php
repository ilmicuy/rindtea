@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Pembayaran Berhasil!</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0;">Status: Pembayaran Diterima</h2>
    @endcomponent

    <p>Hai {{ $user->name }},</p>

    <p>Terima kasih! Pembayaran Anda untuk pesanan #{{ $transaction->kode_transaksi }} telah berhasil kami terima.</p>

    <p>Tim kami akan segera memproses pesanan Anda. Anda akan menerima email pemberitahuan saat pesanan Anda dikirim.</p>

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
