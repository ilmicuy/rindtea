<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CustomerReview;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $product = Product::where('id', $id)->firstOrFail();

        $review = CustomerReview::with(['product', 'user'])->where('products_id', $id)->get();

        return view('pages.shop-detail', [
            'product' => $product,
            'review' => $review,
        ]);
    }

    public function add(Request $request, $id)
    {
        $product = Product::find($id);

        if($product->quantity < $request->qty){
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $getExistingCart = Cart::where([
            'users_id' => Auth::user()->id,
            'products_id' => $id,
        ])->first();

        if($getExistingCart){
            if($product->quantity < $getExistingCart->qty + $request->qty){
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            $getExistingCart->qty += $request->qty;
            $getExistingCart->save();
        }else{
            $data = [
                'products_id' => $id,
                'qty' => $request->qty,
                'users_id' => Auth::user()->id,
            ];

            Cart::create($data);
        }

        return redirect()->back();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
