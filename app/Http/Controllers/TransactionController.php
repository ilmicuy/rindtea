<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Transaction::with(['transactionDetail'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('pages.admin.transaction.index', [
            'query' => $query
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
    public function edit(string $transactions_id)
    {
        
        $items = TransactionDetail::with(['transaction', 'product'])
        ->where('transactions_id', $transactions_id)
        ->firstOrFail();

        $itemDetails = TransactionDetail::with(['transaction', 'product'])
        ->where('transactions_id', $transactions_id)
        ->get();
    
        return view('pages.admin.transaction.edit', [
            'items' => $items,
            'itemDetails' => $itemDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $item = Transaction::findOrFail($id);

        $item->update($data);

        return redirect()->route('transaction');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
