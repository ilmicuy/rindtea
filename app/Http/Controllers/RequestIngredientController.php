<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Ingredient;
use App\Models\IngredientRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RequestIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $requestBahanBaku = IngredientRequest::paginate(10);

        $bahanBaku = Ingredient::all();

        return view('pages.admin.requestIngredient.index', [
            'ingredients' => $bahanBaku,
            'ingredientRequest' => $requestBahanBaku,
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
        IngredientRequest::create([
            'ingredient_id' => $request->pilih_bahan_baku,
            'qty_request' => $request->qty_request,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect(route('requestIngredient.index'));
    }

    public function statusEdit(Request $request)
    {
        $getRequestIngredient = IngredientRequest::findOrFail($request->id);

        if($getRequestIngredient->status != 'pending' && $getRequestIngredient->status != 'processing') {
            return response()->json([
                'status' => 'error',
                'message' => 'request ingredient already done!'
            ], 422);
        }

        if ($request->action == 'confirm') {
            $statusName = "Disetujui";

            $getRequestIngredient->ingredient->qty += $getRequestIngredient->qty_request;
            $getRequestIngredient->ingredient->save();

            $getRequestIngredient->status = 'success';
            $getRequestIngredient->approved_at = Carbon::now();
        } else if ($request->action == 'processing') {
            $statusName = "Diproses";
            $getRequestIngredient->status = 'processing';
        } else if ($request->action == 'cancel') {
            $statusName = "Tidak Disetujui";
            $getRequestIngredient->status = 'cancelled';
        }

        // TODO: Kirim email notifikasi
        $getProduksiUser = User::role('produksi')->get();

        foreach ($getProduksiUser as $user) {
            Inbox::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $user->id,
                'message' => 'Request Bahan Baku ' . $getRequestIngredient->ingredient->nama_bahan_baku . ' sejumlah ' . $getRequestIngredient->qty_request . ' ' . $statusName,
                'is_read' => false,
            ]);

            // Send email
            Mail::to($user->email)->send(new \App\Mail\StatusEditNotificationEmail('request_bahan_baku', $getRequestIngredient, $statusName, $user));
        }

        $getRequestIngredient->save();

        return response()->json([
            'status' => 'success',
            'message' => 'successfully ' . $request->action . ' product request!'
        ]);

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
