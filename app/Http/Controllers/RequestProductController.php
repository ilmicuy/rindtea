<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductTransaction;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RequestProductController extends Controller
{
    public function index(Request $request)
    {
        $requestProduct = ProductRequest::paginate(10);

        $products = Product::all();

        $lowStockProducts = Product::all()->filter(function ($product) {
            return $product->quantity < 10;
        });

        $hasLowStock = $lowStockProducts->isNotEmpty();

        return view('pages.admin.requestProduct.index', [
            'products' => $products,
            'productRequest' => $requestProduct,
            'hasLowStock' => $hasLowStock,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    public function show(ProductRequest $id, Request $request)
    {
        $qty_requested = $id->qty_requested;

        $bahanBaku = $id->product->ingredients;
        $bahanBakuKurangHolder = [];

        foreach($bahanBaku as $bahan) {
            $qty_tersedia = $bahan->qty;
            $qty_per_product = $bahan->pivot->qty_needed;

            $qty_sisa = $qty_tersedia - ($qty_requested * $qty_per_product);

            if($qty_sisa < 0){
                $bahanBakuKurangHolder[] = [
                    'bahan_baku' => $bahan->nama_bahan_baku,
                    'kekurangan_bahan_baku' => abs($qty_sisa),
                    'satuan' => $bahan->satuan
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'request_product' => $id,
                'kekurangan_bahan' => $bahanBakuKurangHolder
            ]
        ]);
    }

    public function store(Request $request)
    {
        // Create a new ProductRequest
        $getRequestProduct = ProductRequest::create([
            'product_id' => $request->pilih_product,
            'qty_requested' => $request->qty_requested,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Get users with 'produksi' role
        $getProduksiUser = User::role('produksi')->get();

        foreach ($getProduksiUser as $user) {
            // Send email
            Mail::to($user->email)->send(new \App\Mail\RequestCreateNotificationEmail('request_product', $getRequestProduct, $user));

            // Send WhatsApp notification
            if ($user->phone_number) {
                // Prepare the WhatsApp message
                $whatsappMessage = "*Request Produk Baru*" . "\n\n" .
                "Halo " . $user->name . "," . "\n\n" .
                "Terdapat *Request Produk* untuk *" . $getRequestProduct->product->name . "* dengan jumlah *" . $getRequestProduct->qty_requested . "*. Mohon untuk segera menanggapi request ini." . "\n\n" .
                "Terima Kasih.";

                // Send the WhatsApp message using FonnteService (or your preferred service)
                $fonnteService = new FonnteService(); // Replace with your service
                // $fonnteService->sendMessage($user->phone_number, $whatsappMessage);
                $fonnteService->sendMessage('081282133865', $whatsappMessage);
            }
        }

        // Redirect to the request product index page
        return redirect(route('requestProduct.index'));
    }


    public function statusEdit(Request $request)
    {
        $getRequestProduct = ProductRequest::findOrFail($request->id);

        if ($getRequestProduct->status != 'pending' && $getRequestProduct->status != 'processing') {
            return response()->json([
                'status' => 'error',
                'message' => 'Request product already done!'
            ], 422);
        }

        $qty_requested = $getRequestProduct->qty_requested;

        if ($request->action == 'confirm') {
            $statusName = 'Disetujui';

            foreach ($getRequestProduct->product->ingredients as $bahan) {
                $bahanCost = $bahan->pivot->qty_needed * $qty_requested;

                $bahan->qty -= $bahanCost;
                $bahan->save();
            }

            $oldProductQuantity = $getRequestProduct->product->quantity;
            $newProductQuantity = $oldProductQuantity + $qty_requested;

            // Update the main product quantity
            $getRequestProduct->product->quantity = $newProductQuantity;
            $getRequestProduct->product->save();

            // Log product transaction for the main product
            ProductTransaction::create([
                'product_id' => $getRequestProduct->product->id,
                'transaction_id' => null,
                'user_id' => Auth::user()->id,
                'transaction_type' => 'restock',
                'quantity' => $qty_requested,
                'old_quantity' => $oldProductQuantity,
                'new_quantity' => $newProductQuantity,
                'transaction_date' => Carbon::now(),
                'description' => 'Product quantity increased for product request #' . $getRequestProduct->id,
            ]);

            $getRequestProduct->status = 'success';
            $getRequestProduct->success_at = Carbon::now();
        } elseif ($request->action == 'processing') {
            $statusName = 'Diproses';
            $getRequestProduct->status = 'processing';
        } elseif ($request->action == 'cancel') {
            $statusName = 'Tidak Disetujui';
            $getRequestProduct->status = 'cancelled';
        }

        // Get users with 'marketing' role
        $getMarketingUser = User::role('marketing')->get();

        foreach ($getMarketingUser as $user) {
            Inbox::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $user->id,
                'message' => 'Request Produk ' . $getRequestProduct->product->name . ' sejumlah ' . $qty_requested . ' ' . $statusName,
                'is_read' => false,
            ]);

            // Send email
            Mail::to($user->email)->send(new \App\Mail\StatusEditNotificationEmail('request_product', $getRequestProduct, $statusName, $user));

            // Send WhatsApp notification
            if ($user->phone_number) {
                // Prepare the WhatsApp message
                $whatsappMessage = "*Status Update untuk Request Produk*" . "\n\n" .
                    "Halo " . $user->name . "," . "\n\n" .
                    "Request Produk untuk *" . $getRequestProduct->product->name . "* dengan jumlah *" . $qty_requested . "* telah *" . $statusName . "*." . "\n\n" .
                    "Terima Kasih.";

                // Send the WhatsApp message using FonnteService (or your preferred service)
                $fonnteService = new FonnteService(); // Replace with your service
                // $fonnteService->sendMessage($user->phone_number, $whatsappMessage);
                $fonnteService->sendMessage('081282133865', $whatsappMessage);
            }
        }

        // Save the updated request product status
        $getRequestProduct->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully ' . $request->action . ' product request!'
        ]);
    }
}
