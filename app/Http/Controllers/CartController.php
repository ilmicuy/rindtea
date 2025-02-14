<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function addQuantity(Request $request)
    {
        // Find the cart item based on the cart_id from the request
        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.'
            ]);
        }

        // Check if the product is available in the requested quantity
        if (!$cart->isStockAvailable($request->qty)) {
            return response()->json([
                'success' => false,
                'message' => 'Product quantity exceeds available stock.'
            ]);
        }

        // Update the quantity in the cart
        if (!$cart->updateQuantity($request->qty)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update the cart quantity.'
            ]);
        }

        // Recalculate totals for the cart item and the subtotal for the entire cart
        $total = $cart->total_price;
        $subtotal = Cart::where('users_id', auth()->id())
            ->get()
            ->sum(function ($cartItem) {
                return $cartItem->total_price;
            });

        return response()->json([
            'success' => true,
            'newTotal' => number_format($total, 0, ',', '.'),
            'subtotal' => number_format($subtotal, 0, ',', '.')
        ]);
    }



    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart');
    }
}
