@extends('layouts.app-old')
@section('content')
<div class="main-content">
    <div class="title">Manajemen Grup Varian Produk</div>
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Grup Varian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $group)
                        <tr>
                            <td>{{ $group }}</td>
                            <td>
                                <form method="POST" action="{{ route('product.variantGroupDelete') }}" class="delete-form">
                                    @csrf
                                    <input type="hidden" name="group" value="{{ $group }}">
                                    <button type="button" class="btn btn-danger btn-sm delete-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">Belum ada grup varian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Yakin hapus grup varian ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection