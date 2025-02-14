@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Detil Pesan
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Dari:</strong> {{ $message->sender->name }}</p>
                        <p><strong>Diterima Pada:</strong> {{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i:s') }}</p>
                        <p><strong>Pesan:</strong></p>
                        <p>{{ $message->message }}</p>
                        <a href="{{ route('inbox.index') }}" class="btn btn-primary">Kembali ke Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
