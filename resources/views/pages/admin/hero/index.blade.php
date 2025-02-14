@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Hero Section
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('herosection.create') }}" class="mb-3 btn btn-primary">
                            Tambah Baru
                        </a>
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Span</th>
                                    <th>Heading</th>
                                    <th>Subheading</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse  ($query as $key => $hero)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ Storage::url($hero->banner) }}" class="img-fluid" width="100px">
                                        </td>
                                        <td>{{ $hero->span }}</td>
                                        <td>{{ $hero->heading }}</td>
                                        <td>{{ $hero->subheading }}</td>
                                        <td align="center" width="100px">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('herosection.edit', $hero) }}"
                                                    class=" btn btn-primary btn-sm">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <form id="deleteForm" action="{{ route('herosection.destroy', $hero) }}"
                                                    method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus hero section ini?')">
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

                        {{ $query->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
