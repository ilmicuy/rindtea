@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Edit Produk
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('product.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Produk Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="name" required value="{{ $item->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="variant_grouping" class="form-label">Grup Varian Produk</label>
                                        <select class="form-control select2-tags" id="variant_grouping" name="variant_grouping">
                                            <option value="">Pilih atau buat grup varian baru</option>
                                            @foreach($existingGroups ?? [] as $group)
                                                <option value="{{ $group }}" {{ $item->variant_grouping === $group ? 'selected' : '' }}>
                                                    {{ $group }}
                                                </option>
                                            @endforeach
                                            @if($item->variant_grouping && !in_array($item->variant_grouping, $existingGroups ?? []))
                                                <option value="{{ $item->variant_grouping }}" selected>
                                                    {{ $item->variant_grouping }}
                                                </option>
                                            @endif
                                        </select>
                                        <small class="text-muted">Kosongkan jika produk tidak memiliki varian</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" disabled value="{{ $item->quantity }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="quality" class="form-label">Quality</label>
                                        <input type="text" class="form-control" id="quality" name="quality" value="{{ $item->quality }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="check" class="form-label">Check</label>
                                        <input type="text" class="form-control" id="check" name="check" required value="{{ $item->check }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country_of_origin" class="form-label">Country of Origin</label>
                                        <input type="text" class="form-control" id="country_of_origin"
                                            name="country_of_origin" required value="{{ $item->country_of_origin }}">
                                    </div>
                                </div>

                                <!-- Shipping Options -->
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="opsi_pengiriman" class="form-label">Opsi Pengiriman</label><br>
                                        @php
                                            $opsiPengiriman = json_decode($item->opsi_pengiriman, true) ?? [];
                                        @endphp
                                        <label>
                                            <input type="checkbox" name="opsi_pengiriman[]" value="Regular"
                                                {{ in_array('Regular', $opsiPengiriman) ? 'checked' : '' }}>
                                            Regular
                                        </label>
                                        <label>
                                            <input type="checkbox" name="opsi_pengiriman[]" value="Instant"
                                                {{ in_array('Instant', $opsiPengiriman) ? 'checked' : '' }}>
                                            Instant
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" required value="{{ $item->price }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Raw Price</label>
                                        <input type="number" class="form-control" id="raw_price" name="raw_price" required value="{{ $item->raw_price }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="photos" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="photos" name="photos">
                                    </div>
                                    <img src="{{ Storage::url($item->photos) }}" alt="" class="img-fluid" width="200px">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="number" class="form-control" id="weight" name="weight" required value="{{ $item->weight }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="thumb_description" class="form-label">Description</label>
                                        <textarea name="thumb_description" id="thumb_description" cols="30" rows="5" class="form-control">{{ $item->thumb_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Bahan Baku</label>
                                    <div id="repeater">
                                        <div data-repeater-list="list_bahan_baku">
                                            @if ($item->ingredients->isEmpty())
                                                <div data-repeater-item>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group mb-3">
                                                                <label for="bahan_baku" class="form-label">Bahan Baku</label>
                                                                <select class="form-control" name="bahan_baku">
                                                                    <option value="">== Pilih Bahan Baku ==</option>
                                                                    @foreach ($ingredients as $ingredient)
                                                                        <option value="{{ $ingredient->id }}">{{ $ingredient->nama_bahan_baku }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group mb-3">
                                                                <label for="qty_needed" class="form-label">Quantity Needed</label>
                                                                <input type="number" class="form-control" name="qty_needed" value="1" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <button type="button" class="btn btn-danger" data-repeater-delete>Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @foreach ($item->ingredients as $bahanBaku)
                                                <div data-repeater-item>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group mb-3">
                                                                <label for="bahan_baku" class="form-label">Bahan Baku</label>
                                                                <select class="form-control" name="bahan_baku">
                                                                    <option value="">== Pilih Bahan Baku ==</option>
                                                                    @foreach ($ingredients as $ingredient)
                                                                        <option value="{{ $ingredient->id }}" {{ $ingredient->id == $bahanBaku->pivot->ingredient_id ? 'selected' : '' }}>
                                                                            {{ $ingredient->nama_bahan_baku }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group mb-3">
                                                                <label for="qty_needed" class="form-label">Quantity Needed</label>
                                                                <input type="number" class="form-control" name="qty_needed" value="{{ $bahanBaku->pivot->qty_needed }}" required>
                                                            </div>
                                                        </div>
                                                        @hasanyrole('produksi')
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <button type="button" class="btn btn-danger" data-repeater-delete>Delete</button>
                                                            </div>
                                                        </div>
                                                        @endhasanyrole
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @hasanyrole('produksi')
                                            <button type="button" class="btn btn-primary" data-repeater-create>Add Bahan Baku</button>
                                        @endhasanyrole
                                    </div>
                                </div>
                                @hasanyrole('produksi')
                                    <div class="col-md-12 mt-5">
                                        <a class="btn btn-secondary" href="{{ route('product.index') }}">
                                            {{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary"> Save</button>
                                    </div>
                                @endhasanyrole
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--single {
    height: 38px;
    line-height: 38px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 38px;
    padding-left: 12px;
    color: #495057;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #6c757d;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #435ebe;
    color: #fff;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #e9ecef;
    color: #495057;
}

.select2-results__option {
    color: #495057;
}

.select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 4px;
}
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize Select2 with tags
        $('.select2-tags').select2({
            tags: true,
            placeholder: 'Pilih atau buat grup varian baru',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Tidak ada hasil yang ditemukan";
                }
            }
        }).on('select2:opening', function() {
            $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Ketik untuk mencari atau membuat baru');
        });

        $('#repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'key': '',
                'value': '',
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
    });
</script>
@endpush
