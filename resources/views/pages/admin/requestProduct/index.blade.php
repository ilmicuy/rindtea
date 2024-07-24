@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Request Product
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('ingredient.create') }}" class="mb-3 btn btn-primary">
                            Buat Request Product
                        </a>
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Stok Tersedia</th>
                                        <th>Quantity Permintaan</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($productRequest as $key => $req)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $req->product->name }}</td>
                                            <td>{{ $req->product->quantity }}</td>
                                            <td>{{ $req->qty_requested }}</td>
                                            <td>{{ $req->notes }}</td>
                                            <td>{{ $req->status }}</td>
                                            <td width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('ingredient.edit', $req->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="{{ route('ingredient.edit', $req->id) }}"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    {{-- <form id="deleteForm{{ $ingredient->id }}"
                                                        action="{{ route('ingredient.destroy', $ingredient->id) }}"
                                                        method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form> --}}

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <p>Tidak ada data terbaru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $productRequest->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
