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
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
        } else if($courier == 'ambil_ditempat'){
            return response()->json([
                'status' => 'success',
                'total' => 0
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

        $shippingCourier = null;
        $shippingCost = 0;

        foreach ($carts as $cart) {
            $items[] = [
                'id'       => 'item' . $cart->id,
                'price'    => $cart->product->price, // Assuming the product model has a 'price' attribute
                'quantity' => $cart->qty,
                'name'     => $cart->product->name, // Assuming the product model has a 'name' attribute
            ];

            $itemTotalPrice += $cart->qty * $cart->product->price;
        }

        $shippingCourier = strtoupper(str_replace('_', ' ', $request->courier)) . '_' . $request->delivery_package;
        $shippingCost = $request->total_price - $itemTotalPrice;

        $items[] = [
            'id'       => 'ongkir_' . $request->courier,
            'price'    => $shippingCost,
            'quantity' => 1,
            'name'     => 'Ongkos Kirim (' . $shippingCourier . ')',
        ];

        $transaction = Transaction::create([
            'checkout_date' => date('Y-m-d H:i:s'),
            'users_id' => Auth::user()->id,
            'total_price' => (int) $request->total_price,
            'transaction_status' => 'pending',
            'shipment_courier' => $shippingCourier,
            'shipment_cost' => $shippingCost,
            'shipment_address_id' => $request->address_id,
        ]);

        foreach ($carts as $cart) {
            $getProduct = Product::find($cart->product->id);
            $oldQuantity = $getProduct->quantity;
            $newQuantity = $oldQuantity - $cart->qty;

            // Update product quantity
            $getProduct->quantity = $newQuantity;
            $getProduct->save();

            // Create transaction detail
            TransactionDetail::create([
                'checkout_date' => date('Y-m-d H:i:s'),
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'qty' => $cart->qty,
            ]);

            // Log product transaction
            ProductTransaction::create([
                'product_id' => $cart->product->id,
                'transaction_id' => $transaction->id,
                'user_id' => Auth::user()->id,
                'transaction_type' => 'sale',
                'quantity' => $cart->qty,
                'old_quantity' => $oldQuantity,
                'new_quantity' => $newQuantity,
                'transaction_date' => date('Y-m-d H:i:s'),
                'description' => 'Product sold during transaction #' . $transaction->id,
            ]);
        }

        // Clear the cart
        Cart::where('users_id', Auth::user()->id)->delete();

        // Send the checkout email
        Mail::to(Auth::user()->email)->send(new \App\Mail\CheckoutEmail(Auth::user(), $transaction, $items));

        if(Auth::user()->phone_number != null){
            //Whatsapp Message
            $whatsappMessage = "*Terima Kasih atas Pesanan Anda di Rind Tea!*" . "\n\n" .
            "Hai, " . Auth::user()->name . "!" . "\n" .
            "Terimakasih telah melakukan pemesanan dengan nomor #" . $transaction->id . " di website Rind Tea. Berikut adalah rincian pesanan Anda:" . "\n\n";

            foreach ($items as $item) {
                $whatsappMessage .= "- *" . $item['name'] . "* - " . $item['quantity'] . " x Rp " . number_format($item['price'], 0, ',', '.') . "\n";
            }

            $whatsappMessage .= "\n*Total Harga:* Rp " . number_format($transaction->total_price, 0, ',', '.') . "\n" .
            "*Ongkos Kirim:* Rp " . number_format($shippingCost, 0, ',', '.') . " (" . $shippingCourier . ")" . "\n\n" .
            "Silahkan untuk melakukan pelunasan dengan mengunjungi tautan berikut:" . "\n" .
            "https://rindtea.biz.id/order-list-detail/" . $transaction->id . "\n\n" .
            "_Hormat Kami,_\n" .
            "*Tim Rind Tea*";
            $fonnteService = new FonnteService();
            // $fonnteService->sendMessage(Auth::user()->phone_number, $whatsappMessage);
            $fonnteService->sendMessage("081282133865", $whatsappMessage);
        }

        // Midtrans configuration
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

        $payment_status = 'PENDING';

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
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

        if ($payment_status == 'SUCCESS') {
            $transaction->paid_at = Carbon::now();
            $transaction->paid_payload = json_encode($notification);

            // Send success payment email
            $user = $transaction->user;
            $items = TransactionDetail::where('transactions_id', $transaction->id)->get()->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => $item->qty,
                    'price' => $item->product->price,
                ];
            });

            // Send WhatsApp message if phone number exists
            if ($user->phone_number) {
                // Prepare the WhatsApp message
                $whatsappMessage = "*Pembayaran Anda Berhasil di Rind Tea!*" . "\n\n" .
                "_Lunas_" . "\n\n" .
                "Hai, " . $user->name . "!" . "\n" .
                    "Terima kasih telah melakukan pembayaran pemesanan nomor #" . $transaction->id . ". Berikut adalah rincian pesanan Anda:" . "\n\n";

                foreach ($items as $item) {
                    $whatsappMessage .= "- *" . $item['name'] . "* - " . $item['quantity'] . " x Rp " . number_format($item['price'], 0, ',', '.') . "\n";
                }

                $whatsappMessage .= "\n*Total Harga:* Rp " . number_format($transaction->total_price, 0, ',', '.') . "\n\n" .
                "Pesanan Anda sedang diproses dan akan segera kami kirim." . "\n\n" .
                "_Hormat Kami,_\n" .
                "*Tim Rind Tea*" . "\n\n" .
                "&copy; " . date('Y') . " Rind Tea. All rights reserved.";

                // Send the WhatsApp message using FonnteService
                $fonnteService = new FonnteService();
                // $fonnteService->sendMessage($user->phone_number, $whatsappMessage);
                $fonnteService->sendMessage('081282133865', $whatsappMessage);
            }

            Mail::to($user->email)->send(new \App\Mail\SuccessPaymentEmail($user, $transaction, $items));

            // Sementara
            Mail::to('rindteasemarang@gmail.com')->send(new \App\Mail\SuccessPaymentEmail($user, $transaction, $items));
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
