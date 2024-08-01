@extends('layouts.home')



@section('content')
<!-- Single Page Header start -->
<div class="single-page-header">
    <h1 class="page-title">Order List Detail </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active">Order List Detail </li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Order List Page Start -->
<div class="py-5 container-fluid">
    <div class="container py-5">

        <div class="order-list-page">
            <div style="float: right">
                <p>Status Transaksi</p>
                @if($transaction->paid_at)
                <p style="background: green; text-align: center;">LUNAS</p>
                @else
                <p style="background: red; text-align: center;">BELUM LUNAS</p>
                <br>
                <button type="button" id="pay-button" style="padding: 10px 10px; font-size: 14px; margin-bottom: 10px;">Klik Untuk Bayar Sekarang</button>
                @endif
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price / Item</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($query as $item)
                    <tr>
                        <td>
                            <p class="mt-4 mb-0">
                                #
                            </p>
                        </td>
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('shop-detail', $item->product->id) }}">
                                    <img src="{{ Storage::url($item->product->photos) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                </a>
                            </div>
                        </th>
                        <td>
                            <p class="mt-4 mb-0">{{ $item->product->name }}</p>
                        </td>
                        <td>
                            <p class="mt-4 mb-0">{{ $item->qty }}</p>
                        </td>
                        <td>
                            <p class="mt-4 mb-0">Rp.{{ number_format($item->product->price) }}</p>
                        </td>
                        <td>
                            @php
                            $review = \App\Models\CustomerReview::with(['transaction', 'product'])
                            ->where('products_id', $item->product->id)
                            ->where('users_id', Auth::user()->id)
                            ->first();
                            @endphp
                            @if ($item->transaction->transaction_status == 'completed')
                            @if ($review == null)
                            <a class="mt-3 border btn btn-md bg-warning" style="color:white" data-bs-toggle="modal" data-bs-target="#buyAgainModal{{ $item->product->id }}">
                                Review
                            </a>
                            <div class="modal fade" id="buyAgainModal{{ $item->product->id }}" tabindex="-1" aria-labelledby="buyAgainModal{{ $item->product->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" action="{{ route('review.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="transactions_id" value={{ $item->transaction->id }}>
                                            <input type="hidden" name="products_id" value={{ $item->product->id }}>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="buyAgainModal{{ $item->product->id }}Label">Berikan
                                                    Review
                                                    Kamu</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-item">
                                                    <textarea class="form-control" name="description_review" id="description_review" cols="30" rows="10">
                                                             </textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="color:white">Batal</button>
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <a class="mt-3 border btn border-secondary text-primary" style="color:white" data-bs-toggle="modal" data-bs-target="#updateReviewModal{{ $item->product->id }}">
                                Update
                            </a>
                            <div class="modal fade" id="updateReviewModal{{ $item->product->id }}" tabindex="-1" aria-labelledby="updateReviewModal{{ $item->product->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" action="{{ route('review.update', $review->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="transactions_id" value={{ $review->transactions_id }}>
                                            <input type="hidden" name="products_id" value={{ $review->products_id }}>
                                            <input type="hidden" name="name_reviewer" value={{ $review->name_reviewer }}>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateReviewModal{{ $item->product->id }}Label">
                                                    Update Review
                                                    Kamu</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-item">
                                                    <textarea class="form-control" name="description_review" id="description_review" cols="30" rows="10">
                                                    {{ $review->description_review }}
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="color:white">Batal</button>
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else

                            @php
                                $badgeClass = '';
                                switch ($item->transaction->transaction_status) {
                                    case 'completed':
                                        $badgeClass = 'badge bg-success';
                                        break;
                                    case 'pending':
                                        $badgeClass = 'badge bg-warning';
                                        break;
                                    case 'failed':
                                        $badgeClass = 'badge bg-danger';
                                        break;
                                    default:
                                        $badgeClass = 'badge bg-secondary';
                                        break;
                                }
                            @endphp
                            <p class="">
                                <span class="mt-4 {{ $badgeClass }}">{{ $item->transaction->transaction_status }}</span>
                            </p>

                            {{-- <p class=" badge bg-success" style="color:white mt-4 mb-0">
                                Menunggu Konfirmasi Penjual
                            </p> --}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Cart Page End -->
@endsection


@push('myscript')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    @if($transaction -> paid_at == null && $transaction -> snap_token != null)

    function snapPay() {
        snap.pay('{{ $transaction->snap_token }}', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                window.location.reload();
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onPending: function(result) {
                // window.reload();
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result) {
                // window.reload();
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    }

    snapPay();

    document.getElementById('pay-button').onclick = function() {
        snapPay();
    };
    @endif
</script>
@endpush
