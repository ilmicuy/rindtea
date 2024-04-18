<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name_reviewer' => $request->name_reviewer,
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
        //
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
