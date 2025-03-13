@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>Order Baru</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0;">Status: Pesanan Baru Masuk</h2>
    @endcomponent

    <p>Halo Tim Marketing,</p>

    <p>Terdapat order baru dengan rincian sebagai berikut:</p>

    @component('mail::table')
    | Produk | Jumlah | Harga |
    |:-------|:-------|:------|
    @foreach($items as $item)
    | {{ $item['name'] }} | {{ $item['quantity'] }} | Rp {{ number_format($item['price'], 0, ',', '.') }} |
    @endforeach
    @endcomponent

    <p>Total Harga: <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>

    @component('mail::button', ['url' => route('admin.transactions.show', $transaction->id)])
        Lihat Detail Order
    @endcomponent

    <p>Terima Kasih.</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
