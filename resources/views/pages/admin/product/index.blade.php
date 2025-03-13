@extends('layouts.app-old')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <div class="main-content">
        <div class="title">
            Produk
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                @if ($hasLowStock)
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Produk Hampir Habis! (stok dibawah 10)</h4>
                        Mohon untuk melakukan request produk berikut:
                        <ul style="margin-left: 1.2em;">
                            @foreach ($lowStockProducts as $product)
                                <li>{{ $product->name }} - Stok: {{ $product->quantity }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        @hasanyrole('produksi')
                        <a href="{{ route('product.create') }}" class="mb-3 btn btn-primary">
                            Tambah Baru
                        </a>
                        @endhasanyrole
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Grup Varian</th>
                                        <th>Harga Modal</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Kualitas</th>
                                        <th>Asal</th>
                                        <th>Berat</th>
                                        <th>Gambar</th>
                                        @unlessrole('owner')
                                        <th>Aksi</th>
                                        @endunlessrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($query as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->kode_produk }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->variant_grouping ?: '-' }}</td>
                                            <td>Rp.{{ number_format($product->raw_price) }}</td>
                                            <td>Rp.{{ number_format($product->price) }}</td>
                                            <td>{{ $product->quantity }} Pcs</td>
                                            <td>{{ $product->quality }}</td>
                                            <td>{{ $product->country_of_origin }}</td>
                                            <td>{{ $product->weight }}</td>
                                            <td><img src="{{ Storage::url($product->photos) }}" style="max-width: 50px;"
                                                    class="img-fluid">
                                            </td>
                                            @unlessrole('owner')
                                            <td width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    @hasanyrole('produksi')
                                                    <form id="deleteForm{{ $product->id }}"
                                                        action="{{ route('product.destroy', $product->id) }}"
                                                        method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endhasallroles
                                                </div>
                                            </td>
                                            @endunlessrole
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">
                                                <p>Tidak ada data terbaru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $query->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<!-- Include SweetAlert CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endpush
