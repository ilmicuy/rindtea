@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            About
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('about.create') }}" class="mb-3 btn btn-primary">
                            Tambah Baru
                        </a>
                        <div class="table-responsive">
                            <table id="example2" class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Keypoint</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse  ($query as $key => $about)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ Storage::url($about->thumbnail) }}" class="img-fluid"
                                                    width="100px"></td>
                                            <td width="200px">{{ $about->name }}</td>
                                            <td>
                                                @foreach ($about->keypoints as $keypoint)
                                                    <p>{{ $keypoint->keypoint }}</p>
                                                @endforeach
                                            </td>
                                            <td align="center" width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('about.edit', $about) }}"
                                                        class="btn mb-2 btn-primary btn-sm">
                                                        <i class="ti-pencil"></i></button>
                                                    </a>
                                                    <form id="deleteForm" action="{{ route('about.destroy', $about) }}"
                                                        method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class=" btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus about ini?')">
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
                        {{ $query->links('pagination::bootstrap-4') ) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
