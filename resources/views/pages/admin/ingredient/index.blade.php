@extends('layouts.app-old')
@section('content')

<!-- Modal Buat Request Product -->
<div class="modal fade" id="buatIngredientModal" tabindex="-1" aria-labelledby="buatIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Bahan Baku Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ingredient.store') }}" id="buatIngredientForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Nama Bahan Baku</label>
                        <input type="text" name="nama_bahan_baku" class="form-control" placeholder="Contoh: Tea Bag" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Quantity Awal</label>
                        <input type="number" name="qty" class="form-control" min="0" value="0" required>
                    </div>
                    <div class="form-group mb-4">
                        <label>Satuan</label>
                        <select name="satuan" class="form-control" required>
                            <option value="pcs">Pcs</option>
                            <option value="gram">Gram</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validateAndSubmitForm()">Buat Request</button>
            </div>
        </div>
    </div>
</div>

    <div class="main-content">
        <div class="title">
            Ingredient
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buatIngredientModal">
                            Tambah Bahan Baku Baru
                        </button>

                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan Baku</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($ingredients as $key => $ingredient)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $ingredient->nama_bahan_baku }}</td>
                                            <td>{{ $ingredient->qty }}</td>
                                            <td>{{ $ingredient->satuan }}</td>
                                            {{-- <td width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('ingredient.edit', $ingredient->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <form id="deleteForm{{ $ingredient->id }}"
                                                        action="{{ route('ingredient.destroy', $ingredient->id) }}"
                                                        method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td> --}}
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

@push('js')
<script>
    function validateAndSubmitForm() {
        // Get form fields
        const namaBahanBaku = document.querySelector('[name="nama_bahan_baku"]').value;
        const qtyRequested = document.querySelector('[name="qty"]').value;
        const satuan = document.querySelector('[name="satuan"]').value;

        // Validate form fields
        if (namaBahanBaku.trim() === '') {
            alert('Nama Bahan Baku is required.');
            return;
        }

        if (qtyRequested === '' || isNaN(qtyRequested) || parseInt(qtyRequested) < 0) {
            alert('Quantity Awal must be a non-negative number.');
            return;
        }

        if (satuan.trim() === '') {
            alert('Satuan is required.');
            return;
        }

        // Submit the form if all validations pass
        document.getElementById('buatIngredientForm').submit();
    }
</script>
@endpush
