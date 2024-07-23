<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Address;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CheckoutRequest;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::all();
        $checkouts = Cart::with(['product', 'user'])->where('users_id', Auth::user()->id)->get();
        $addresses = Address::where('users_id', Auth::user()->id)->get();
        return view('pages.checkout', [
            'checkouts' => $checkouts,
            'provincies' => $provinces,
            'addresses' => $addresses,

        ]);
    }

    public function shippingfee(Request $request)
    {
        $address_id = $request->input('address_id');
        $courier = $request->input('courier');
        $weight = $request->input('weight');
        $address = Address::find($address_id);
        if (!$address) {
            return response()->json(['error' => 'Invalid address ID'], 400);
        }
        $destination = $address->regency_id;
        $origin = env('API_ONGKIR_ORIGIN');

        $tarif_lokal_kurir = 5000;

        if($courier == 'lokal_kurir'){
            $total = $address->distance_in_km * $tarif_lokal_kurir;

            return response()->json([
                'status' => 'success',
                'distance_in_km' => $address->distance_in_km,
                'tarif_lokal_kurir_per_km' => $tarif_lokal_kurir,
                'total' => $total
            ]);
        }else{
            $response = Http::withHeaders([
                'key' => env('API_ONGKIR_KEY')
            ])->post(env('API_ONGKIR_BASE_URL') . 'cost', [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ]);

            $shipping_options = $response->json();

            if ($response->failed() || !isset($shipping_options['rajaongkir']['results'][0]['costs'])) {
                return response()->json(['error' => 'Unable to get shipping cost'], 500);
            }

            $costs = $shipping_options['rajaongkir']['results'][0]['costs'];

            $html = view('pages.available_service', ['costs' => $costs])->render();

            return response()->json($html);
        }

    }

    public function cost(Request $request)
    {
        $service = $request->input('service');
        $cost = $request->input('cost');


        $cost = (float) $cost;

        $availableServicesHtml = '<li>' . htmlspecialchars($service) . ' - Cost: Rp ' . number_format($cost) . '</li>';

        return response()->json([
            'message' => 'Delivery option selected successfully',
            'availableServicesHtml' => $availableServicesHtml,
            'cost' => $cost
        ]);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        $items = [];
        $itemTotalPrice = 0;
        $shippingFee = 0;

        foreach ($carts as $cart) {
            $items[] = [
                'id'       => 'item' . $cart->id,
                'price'    => $cart->product->price, // Assuming the product model has a 'price' attribute
                'quantity' => $cart->qty,
                'name'     => $cart->product->name, // Assuming the product model has a 'name' attribute
            ];

            $itemTotalPrice += $cart->qty * $cart->product->price;
        }

        $items[] = [
            'id'       => 'ongkir_' . $request->courier,
            'price'    => $request->total_price - $itemTotalPrice,
            'quantity' => 1,
            'name'     => 'Ongkos Kirim (' . ucwords(str_replace('_', ' ', $request->courier)) . ')',
        ];

        $transaction =  Transaction::create([
            'checkout_date' => date('Y-m-d H:i:s'),
            'users_id' => Auth::user()->id,
            'total_price' => (int) $request->total_price,
            'transaction_status' => 'pending',
        ]);

        foreach ($carts as $cart) {
            TransactionDetail::create([
                'checkout_date' => date('Y-m-d H:i:s'),
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'qty'       => $request->qty,
            ]);
        }

        Cart::where('users_id', Auth::user()->id)->delete();

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $midtrans = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enable_payments' => [
                'gopay', 'permata_va', 'shoppepay', 'bank_transfer'
            ],
            'item_details' => $items,
            'vtweb' => []
        ];

        try {
            $snapToken = Snap::getSnapToken($midtrans);
            $transaction->snap_token = $snapToken;
            $transaction->save();

            return redirect(route('order.detail', $transaction->id));
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $notification = new Notification();

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        $transaction = Transaction::findOrFail($order_id);

        // $payment_method =
        $payment_status = 'PENDING';

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challange') {
                    $payment_status = 'PENDING';
                } else {
                    $payment_status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $payment_status = 'SUCCESS';
        } else if ($status == 'pending') {
            $payment_status = 'PENDING';
        } else if ($status == 'deny') {
            $payment_status = 'CANCELED';
        } else if ($status == 'expire') {
            $payment_status = 'CANCELED';
        } else if ($status == 'cancel') {
            $payment_status = 'CANCELED';
        }

        if($payment_status == 'SUCCESS'){
            $transaction->paid_at = Carbon::now();
            $transaction->paid_payload = json_encode($notification);
        }

        $transaction->save();

        if ($transaction) {
            if ($status == 'capture' && $fraud == 'accept') {
            } else if ($status == 'settlement') {
                //
            } else if ($status == 'success') {
                //
            } else if ($status == 'capture' && $fraud == 'challenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not challenge'
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'
                    ]
                ]);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Notification Success'
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function success()
    {
        return view('pages.success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getkota(Request $request)
    {
        $id_provinsi = $request->id_provinsi;
        $kotas = Regency::where('province_id', $id_provinsi)->get();
        $option = "<option>Pilih Kota/Kabupaten</option>";
        foreach ($kotas as $kota) {
            $option .= "<option value='$kota->id'>$kota->name</option>";
        }
        return $option;
    }

    public function getkecamatan(Request $request)
    {
        $id_kota = $request->id_kota;
        $kecamatans = District::where('regency_id', $id_kota)->get();
        $option = "<option>Pilih Kecamatan</option>";
        foreach ($kecamatans as $kecamatan) {
            $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
        }
        return $option;
    }

    public function getdesa(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;
        $desas = Village::where('district_id', $id_kecamatan)->get();
        $option = "<option>Pilih Desa</option>";
        foreach ($desas as $desa) {
            $option .= "<option value='$desa->id'>$desa->name</option>";
        }
        return $option;
    }
}
