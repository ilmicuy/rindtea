<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = CustomerReview::with(['product', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('pages.admin.reviews.index', [
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
        CustomerReview::create([
            'products_id' => $request->products_id,
            'transactions_id' => $request->transactions_id,
            'users_id' => Auth::user()->id,
            'description_review'   => $request->description_review,
            'rating'    => 5
        ]);

        return redirect()->back();
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
        $item = CustomerReview::findOrFail($id);

        return view('pages.admin.reviews.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $item = CustomerReview::findOrFail($id);

        $item->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
