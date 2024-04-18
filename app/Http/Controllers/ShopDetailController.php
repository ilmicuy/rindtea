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
        $product = Product::with(['category'])->where('id', $id)->firstOrFail();

        $review = CustomerReview::with(['product', 'user'])->where('products_id', $id)->get();
        
        return view('pages.shop-detail', [
            'product' => $product,
            'review' => $review,
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = [
            'products_id' => $id,
            'qty' => $request->qty,
            'users_id' => Auth::user()->id,
        ];
        
        Cart::create($data);

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
