@extends('layouts.app-old')
@section('content')

    @hasanyrole('marketing')
    <!-- Modal Buat Request Produk -->
    <div class="modal fade" id="buatRequestProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Request Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('requestProduct.store') }}" id="buatRequestProductForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                          <label>Pilih Produk</label>
                          <select class="form-control" name="pilih_product" required>
                                <option value="">== Pilih Produk ==</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                          </select>
                        </div>

                        <div class="form-group mb-4">
                          <label>Jumlah Permintaan</label>
                          <input type="number" name="qty_requested" class="form-control" min="1" value="1" required>
                        </div>

                        <div class="form-group">
                          <label>Catatan</label>
                          <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#buatRequestProductForm').submit()">Buat Reqeust</button>
                </div>
            </div>
        </div>
    </div>
    @endhasanyrole

    <!-- Modal for showing Product Request details -->
    <div class="modal fade" id="detailModalProduct" tabindex="-1" role="dialog" aria-labelledby="detailModalProductLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalProductLabel">Detail Permintaan Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Product request details will be dynamically loaded here -->
                    <p id="transactionDetailsProduct">Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="main-content">
        <div class="title">
            Request Produk
        </div>
        <div class="content-wrapper">
            @if ($hasLowStock)
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Produk Hampir Habis! (stok dibawah 10)</h4>
                    Mohon untuk melakukan request produk berikut:
                    <ul style="margin-left: 1.2em;">
                        @foreach ($lowStockProducts as $product)
                            <li>{{ $product->name }} - Stok: {{ $product->quantity }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @hasanyrole('marketing')
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buatRequestProductModal">
                            Buat Request Produk
                        </button>
                        @endhasanyrole

                        {{-- <a href="{{ route('ingredient.create') }}" class="mb-3 btn btn-primary">
                            Buat Request Produk
                        </a> --}}
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Request</th>
                                        <th>Nama Produk</th>
                                        {{-- <th>Stok Tersedia</th> --}}
                                        <th>Jumlah Permintaan</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($productRequest as $key => $req)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $req->kode_request_produk }}</td>
                                            <td>{{ $req->product->name }}</td>
                                            {{-- <td>{{ $req->product->quantity }}</td> --}}
                                            <td>{{ $req->qty_requested }} pax</td>
                                            <td>{{ $req->notes }}</td>
                                            <td>
                                                @if ($req->status == "pending")
                                                    @if ($req->approved_by_owner == null)
                                                        Pending Approval Owner
                                                    @else
                                                        {{ ucwords($req->status) }}
                                                    @endif
                                                @else
                                                    {{ ucwords($req->status) }}
                                                @endif
                                            </td>

                                            <td width="100px">
                                                @hasanyrole('marketing')
                                                @if ($req->status == 'processing')
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'confirm')">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'cancel')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
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
                                                @endif
                                                @endhasanyrole

                                                @hasanyrole('produksi')
                                                @if ($req->status == 'pending')
                                                    @if ($req->approved_by_owner != null)
                                                        <div class="d-flex justify-content-between">
                                                            <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'processing')">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'cancel')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
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
                                                    @endif
                                                @endif
                                                @endhasanyrole

                                                @hasanyrole('owner')
                                                    @if ($req->approved_by_owner == null && $req->status == 'pending')
                                                        <div class="d-flex justify-content-between">
                                                            <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'owner_approval')">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'owner_approval_cancel')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endhasanyrole

                                                <!-- Detail Button (always visible) -->
                                                <div class="d-flex justify-content-start mt-2">
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModalProduct" onclick="showProductDetail({{ $req->id }})">
                                                        <i class="fa fa-info"></i> Detail
                                                    </button>
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
                        {{ $productRequest->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
<script>

function statusEdit(id, status)
{
    if(status == 'processing'){
        $.ajax({
            type: 'GET',
            url: "/request-product/" + id,
            cache: false,
            success: function (response) {
                let data = response.data;
                console.log(data);

                if(data.kekurangan_bahan.length > 0){
                    let kekurangan_bahan_html = ``;

                    $.each(data.kekurangan_bahan, function(index, val) {
                        kekurangan_bahan_html += `
                        <tr>
                            <td>${val.bahan_baku}</td>
                            <td>${val.kekurangan_bahan_baku} ${val.satuan}</td>
                        </tr>
                        `;
                    });

                    let kekurangan_bahan_table = `
                        <p>Produk tidak dapat ditambah karena stop bahan baku tidak cukup.</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Bahan Baku</th>
                                    <th>Kekurangannya</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${kekurangan_bahan_html}
                            </tbody>
                        </table>
                    `;


                    Swal.fire({
                        title: "Stok Bahan Baku Tidak Mencukupi!",
                        html: kekurangan_bahan_table,
                        icon: "error",
                        showCancelButton: false,
                    });

                }else{
                    Swal.fire({
                        title: `Proses penambahan Stok Produk?`,
                        html: `Apakah anda yakin ingin memproses menambahkan stok produk <b>"${data.request_product.product.name}"</b> sebanyak <b>${data.request_product.qty_requested} pax</b>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya"
                    }).then((result) => {

                        if (result.isConfirmed) {
                            confirmAction(id, 'processing');
                        }
                    });
                }
                // displayTrackingResult(response);
            },
            error: function (data) {
                console.log('error:', data);
            }
        });

    }else if(status == 'confirm'){
        Swal.fire({
            title: `Konfirmasi Penambahan Stok Produk?`,
            html: `Apakah anda yakin ingin menambahkan stok produk?"`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {

            if (result.isConfirmed) {
                confirmAction(id, 'confirm');
            }
        });
        } else if(status == 'owner_approval'){

        Swal.fire({
            title: `Setujui Penambahan Stok Produk?`,
            html: `Apakah anda yakin ingin menyetujui request produk`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {
            if (result.isConfirmed) {
                confirmAction(id, 'owner_approval');
            }
        });

    } else if(status == 'owner_approval_cancel'){

        Swal.fire({
            title: `Batalkan Penambahan Stok Produk?`,
            html: `Apakah anda yakin ingin membatalkan request produk`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {
            if (result.isConfirmed) {
                confirmAction(id, 'owner_approval_cancel');
            }
        });

    } else{
        Swal.fire({
            title: `Batal Request Penambahan Stok Produk?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {
            if (result.isConfirmed) {
                confirmAction(id, 'cancel');
            }
        });
    }

}

function confirmAction(id, action)
{
    $.ajax({
        type: 'POST',
        url: "{{ route('requestProduct.statusEdit') }}",
        data: {
            id: id,
            action: action
        },
        cache: false,
        success: function (response) {
            let actionName = '';
            switch(action){
                case 'confirm':
                    actionName = 'Konfirmasi';
                    break;
                case 'processing':
                    actionName = 'Memproses';
                    break;
                case 'owner_approval':
                    actionName = 'Menyetujui';
                    break;
                case 'owner_approval_cancel':
                    actionName = 'Membatalkan';
                    break;
                default:
                    actionName = 'Membatalkan';
                    break;
            }

            Swal.fire({
                title: `Berhasil ${actionName} Penambahan Stok Produk!`,
                icon: "success"
            }).then((result) => {
                window.location.reload();
            });

            console.log(response);
        },
        error: function (data) {
            console.log('error:', data);
        }
    });
}

function showProductDetail(requestProductId) {
    // Replace the URL with the appropriate route to fetch the product request details
    var url = '/request-product/' + requestProductId;

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            // Populate the modal body with the returned request details
            $('#transactionDetailsProduct').html(`
                <strong>Created At:</strong> ${response.created_at} <br>
                <strong>Owner Approved At:</strong> ${response.owner_approved_at ? response.owner_approved_at : 'Not Approved Yet'} <br>
                <strong>Processing At:</strong> ${response.processing_at ? response.processing_at : 'Not Processed Yet'} <br>
                <strong>Completed At:</strong> ${response.completed_at ? response.completed_at : 'Not Completed Yet'}
            `);
        },
        error: function() {
            $('#transactionDetailsProduct').html('Error loading product request details');
        }
    });
}

</script>
@endpush
