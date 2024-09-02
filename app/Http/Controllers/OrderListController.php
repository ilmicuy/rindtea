<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Transaction::with(['transactionDetail'])
            ->orderBy('created_at', 'desc')
            ->where('users_id', Auth::user()->id)
            ->get();

        return view('pages.order-list', [
            'query' => $query,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transactions_id)
    {
        $query = TransactionDetail::with(['transaction', 'product'])
            ->where('transactions_id', $transactions_id->id)
            ->get();

        return view('pages.order-list-detail', [
            'query' => $query,
            'transaction' => $transactions_id
        ]);
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
    public function update(Request $request, string $transactions_id)
    {
        // Validate the input
        $request->validate([
            'refund_no_rek' => 'required|string|max:255',
        ]);

        // Find the transaction by ID
        $transaction = Transaction::findOrFail($transactions_id);

        // Update the transaction
        $transaction->update([
            'refund_status' => 'pending',
            'refund_no_rek' => $request->input('refund_no_rek'),
        ]);

        // Redirect back with success message
        return redirect()->route('order.detail', $transactions_id)->with('success', 'Refund details updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
