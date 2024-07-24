<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestProductController extends Controller
{
    public function index(Request $request)
    {
        $requestProduct = ProductRequest::paginate(10);

        $products = Product::all();

        return view('pages.admin.requestProduct.index', [
            'products' => $products,
            'productRequest' => $requestProduct,
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
        ProductRequest::create([
            'product_id' => $request->pilih_product,
            'qty_requested' => $request->qty_requested,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect(route('requestProduct.index'));
    }

    public function statusEdit(Request $request)
    {
        $getRequestProduct = ProductRequest::findOrFail($request->id);

        if($getRequestProduct->status != 'pending'){
            return response()->json([
                'status' => 'error',
                'message' => 'request product already done!'
            ], 422);
        }

        if($request->action == 'confirm'){

            $qty_requested = $getRequestProduct->qty_requested;

            foreach($getRequestProduct->product->ingredients as $bahan) {
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
                'transaction_id' => $getRequestProduct->id,
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

        }else if($request->action == 'cancel'){
            $getRequestProduct->status = 'cancelled';
        }

        $getRequestProduct->save();

        return response()->json([
            'status' => 'success',
            'message' => 'successfully '. $request->action . ' product request!'
        ]);
    }
}
