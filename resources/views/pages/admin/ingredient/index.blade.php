@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Ingredient
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('ingredient.create') }}" class="mb-3 btn btn-primary">
                            Tambah Ingredient Baru
                        </a>
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan Baku</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($ingredients as $key => $ingredient)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $ingredient->nama_bahan_baku }}</td>
                                            <td>{{ $ingredient->qty }}</td>
                                            <td>{{ $ingredient->satuan }}</td>
                                            <td width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('ingredient.edit', $ingredient->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ti-pencil"></i>
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
                        {{ $ingredients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
