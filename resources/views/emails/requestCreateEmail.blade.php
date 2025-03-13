@extends('mail::layout')

@section('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endsection

@section('content')
    <h1>{{ $type }} Baru</h1>

    @component('mail::panel')
        <h2 style="margin-top: 0;">Status: Request Baru</h2>
        @if ($type == "Request Bahan Baku")
            <p style="margin-bottom: 0;">Bahan Baku: {{ $modelRequest->ingredient->nama_bahan_baku }}<br>
            Jumlah: {{ $modelRequest->qty_request }}</p>
        @else
            <p style="margin-bottom: 0;">Produk: {{ $modelRequest->product->name }}<br>
            Jumlah: {{ $modelRequest->qty_requested }}</p>
        @endif
    @endcomponent

    <p>Halo {{ $user->name }},</p>

    @if ($type == "Request Bahan Baku")
        <p>Terdapat {{ $type }} untuk <strong>{{ $modelRequest->ingredient->nama_bahan_baku }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_request }}</strong>. Mohon untuk segera menanggapi request ini.</p>
    @else
        <p>Terdapat {{ $type }} untuk <strong>{{ $modelRequest->product->name }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_requested }}</strong>. Mohon untuk segera menanggapi request ini.</p>
    @endif

    @component('mail::button', ['url' => config('app.url')])
        Lihat Request
    @endcomponent

    <p>Terima Kasih.</p>
@endsection

@section('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endsection
