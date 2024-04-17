<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with(['product', 'user'])->where('users_id', Auth::user()->id)->get();

        return view('pages.cart', [
            'carts' => $carts
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart');
    }
}
