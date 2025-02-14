@extends('layouts.app-old')
@section('content')

@hasanyrole('produksi')
<!-- Modal Buat Request Produk -->
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
@endhasanyrole

    <div class="main-content">
        <div class="title">
            Bahan Baku
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                @if ($hasLowStock)
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Bahan Baku Hampir Habis!</h4>
                        Mohon untuk melakukan pengadaan bahan baku berikut:
                        <ul style="margin-left: 1.2em;">
                            @foreach ($lowStockIngredients as $ingredient)
                                <li>{{ $ingredient->nama_bahan_baku }} - Stok: {{ $ingredient->qty }} {{ $ingredient->satuan }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">

                        @hasanyrole('produksi')
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buatIngredientModal">
                            Tambah Bahan Baku Baru
                        </button>
                        @endhasanyrole

                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Bahan Baku</th>
                                        <th>Nama Bahan Baku</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($ingredients as $key => $ingredient)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $ingredient->kode_bahan_baku }}</td>
                                            <td>{{ $ingredient->nama_bahan_baku }}</td>
                                            <td>{{ $ingredient->qty }}</td>
                                            <td>{{ $ingredient->satuan }}</td>

                                            <td width="100px">
                                                <div class="d-flex justify-content-between">
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editIngredientModal{{ $ingredient->id }}">
                                                        <i class="ti-pencil"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteIngredientModal{{ $ingredient->id }}">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Ingredient Modal -->
                                        <div class="modal fade" id="editIngredientModal{{ $ingredient->id }}" tabindex="-1" aria-labelledby="editIngredientModalLabel{{ $ingredient->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Bahan Baku</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('ingredient.update', $ingredient->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group mb-4">
                                                                <label>Nama Bahan Baku</label>
                                                                <input type="text" name="nama_bahan_baku" class="form-control" value="{{ $ingredient->nama_bahan_baku }}" required>
                                                            </div>
                                                            <div class="form-group mb-4">
                                                                <label>Satuan</label>
                                                                <select name="satuan" class="form-control" required>
                                                                    <option value="pcs" {{ $ingredient->satuan == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                                                    <option value="gram" {{ $ingredient->satuan == 'gram' ? 'selected' : '' }}>Gram</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-4">
                                                                <label>Quantity (Tidak dapat diubah)</label>
                                                                <input type="number" class="form-control" value="{{ $ingredient->qty }}" disabled>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Ingredient Modal -->
                                        <div class="modal fade" id="deleteIngredientModal{{ $ingredient->id }}" tabindex="-1" aria-labelledby="deleteIngredientModalLabel{{ $ingredient->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Bahan Baku</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus bahan baku ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('ingredient.destroy', $ingredient->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <p>Tidak ada data terbaru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $ingredients->links('pagination::bootstrap-4')  }}
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
