@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Edit Product
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
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="name" required value="{{ $item->name }}">
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
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" required value="{{ $item->price }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="number" class="form-control" id="weight" name="weight" required value="{{ $item->weight }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="photos" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="photos" name="photos">
                                    </div>
                                    <img src="{{ Storage::url($item->photos) }}" alt="" class="img-fluid" width="200px">
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
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <button type="button" class="btn btn-danger" data-repeater-delete>Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary" data-repeater-create>Add Bahan Baku</button>
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
