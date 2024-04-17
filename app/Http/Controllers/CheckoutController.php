<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkouts = Cart::with(['product', 'user'])->where('users_id', Auth::user()->id)->get();

        return view('pages.checkout', [
            'checkouts' => $checkouts
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
    public function store(CheckoutRequest $request)
    {
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        $transaction =  Transaction::create([
            'users_id' => Auth::user()->id,
            'total_price' => (int) $request->total_price,
            'transaction_status' => 'pending',
        ]);
        
        foreach ($carts as $cart) {            
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address'   => $request->address,
                'city'      => $request->city,
                'country'   => $request->country,
                'zip_code'  => $request->zip_code,
                'phone'     => $request->phone,
                'qty'       => $request->qty,
            ]);
        }

        Cart::where('users_id', Auth::user()->id)->delete();

        return redirect()->route('success');
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
}
