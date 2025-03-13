@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Terima Kasih atas Pesanan Anda!</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0;">Status: Menunggu Pembayaran</h2>
    @endcomponent

    <p>Hai {{ $user->name }},</p>

    <p>Terima kasih telah melakukan pemesanan di Rind Tea. Berikut adalah detail pesanan Anda:</p>

    @component('mail::table')
    | Produk | Jumlah | Harga |
    |:-------|:-------|:------|
    @foreach($transaction->transaction_details as $detail)
    | {{ $detail->product->name }} | {{ $detail->quantity }} | Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} |
    @endforeach
    @endcomponent

    <p>Total Pembayaran: <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>

    <p>Silakan lakukan pembayaran sesuai dengan metode pembayaran yang Anda pilih. Pesanan Anda akan diproses setelah pembayaran berhasil dikonfirmasi.</p>

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
