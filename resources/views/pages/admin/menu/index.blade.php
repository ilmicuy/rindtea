@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Menu
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('menu.create') }}" class="mb-3 btn btn-primary">
                            Tambah Baru
                        </a>
                        <div class="table-responsive">
                            <table id="example2" class="table table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Tagline</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse  ($query as $key => $menu)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ Storage::url($menu->thumbnail) }}" class="img-fluid"
                                                    style="max-width: 50px;"></td>
                                            <td>{{ $menu->name }}</td>
                                            <td>{{ $menu->tagline }}</td>
                                            <td align="center" width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('menu.edit', $menu) }}"
                                                        class="btn mb-2 btn-primary btn-sm">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <form id="deleteForm" action="{{ route('menu.destroy', $menu) }}"
                                                        method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>
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

                        {{ $query->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
