@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Tambah produk
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="quality" class="form-label">Jumlah</label>
                                        <input type="text" class="form-control" id="quality" name="quality">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="check" class="form-label">Cek</label>
                                        <input type="text" class="form-control" id="check" name="check">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country_of_origin" class="form-label">Negara Asal</label>
                                        <input type="text" class="form-control" id="country_of_origin" name="country_of_origin">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="price" name="price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="weight" class="form-label">Berat</label>
                                        <input type="number" class="form-control" id="weight" name="weight">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="photos" class="form-label">Gambar</label>
                                        <input type="file" class="form-control" id="photos" name="photos" required accept=".png, .jpg, .jpeg">
                                        <small class="text-danger">(png & jpg, max 5 mb)</small>
                                        <div id="file-error" class="text-danger mt-1"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="opsi_pengiriman" class="form-label">Opsi Pengiriman</label><br>
                                        <label>
                                            <input type="checkbox" name="opsi_pengiriman[]" value="Regular" required> Regular
                                        </label>
                                        <label>
                                            <input type="checkbox" name="opsi_pengiriman[]" value="Instant" required> Instant
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="thumb_description" class="form-label">Deskripsi</label>
                                        <textarea name="thumb_description" id="thumb_description" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Bahan Baku</label>
                                    <div id="repeater">
                                        <div data-repeater-list="list_bahan_baku">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group mb-3">
                                                            <label for="bahan_baku" class="form-label">Bahan Baku</label>
                                                            <select name="bahan_baku" class="form-control">
                                                                <option value="">== Pilih Bahan Baku ==</option>
                                                                @foreach ($ingredients as $ingredient)
                                                                    <option value="{{ $ingredient->id }}">{{ $ingredient->nama_bahan_baku }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group mb-3">
                                                            <label for="qty_needed" class="form-label">Jumlah yang Dibutuhkan</label>
                                                            <input type="number" class="form-control" name="qty_needed" min="1" value="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3">
                                                            <button type="button" class="btn btn-danger" data-repeater-delete>Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" data-repeater-create><i class="fa fa-plus"></i> Tambah Bahan Baku</button>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-5">
                                    <a class="btn btn-secondary" href="{{ route('product.index') }}">
                                        {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary"> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>

<script>
    $(document).ready(function () {
        $('#repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'key': '',
                'value': ''
            },
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

        document.getElementById('photos').addEventListener('change', function() {
            const allowedTypes = ['image/png', 'image/jpeg'];
            const maxSize = 5 * 1024 * 1024; // 5 MB in bytes
            const file = this.files[0];
            const errorDiv = document.getElementById('file-error');

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    errorDiv.textContent = 'Please upload an image file (png or jpg).';
                    this.value = ''; // Clear the input
                } else if (file.size > maxSize) {
                    errorDiv.textContent = 'File size must be less than 5 MB.';
                    this.value = ''; // Clear the input
                } else {
                    errorDiv.textContent = ''; // Clear any error messages
                }
            }
        });
    });
</script>
@endpush
