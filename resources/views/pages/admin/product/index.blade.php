@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Product
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @hasanyrole('owner|produksi')
                        <a href="{{ route('product.create') }}" class="mb-3 btn btn-primary">
                            Tambah Baru
                        </a>
                        @endhasanyrole
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Quality</th>
                                        <th>Country Of Origin</th>
                                        <th>Weight</th>
                                        <th>Photo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($query as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>Rp.{{ number_format($product->price) }}</td>
                                            <td>{{ $product->quantity }} Pcs</td>
                                            <td>{{ $product->quality }}</td>
                                            <td>{{ $product->country_of_origin }}</td>
                                            <td>{{ $product->weight }}</td>
                                            <td><img src="{{ Storage::url($product->photos) }}" style="max-width: 50px;"
                                                    class="img-fluid">
                                            </td>
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <p>Tidak ada data terbaru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $query->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
