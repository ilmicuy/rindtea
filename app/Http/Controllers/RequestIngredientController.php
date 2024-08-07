<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Ingredient;
use App\Models\IngredientRequest;
use App\Models\User;
use App\Services\FonnteService;
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
        // Create a new IngredientRequest
        $getRequestIngredient = IngredientRequest::create([
            'ingredient_id' => $request->pilih_bahan_baku,
            'qty_request' => $request->qty_request,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Get users with 'keuangan' role
        $getKeuanganUser = User::role('keuangan')->get();

        foreach ($getKeuanganUser as $user) {
            // Send email
            Mail::to($user->email)->send(new \App\Mail\RequestCreateNotificationEmail('request_bahan_baku', $getRequestIngredient, $user));

            // Send WhatsApp notification
            if ($user->phone_number) {
                // Prepare the WhatsApp message
                $whatsappMessage = "*Request Bahan Baku Baru*" . "\n\n" .
                "Halo " . $user->name . "," . "\n\n" .
                "Terdapat *Request Bahan Baku* untuk *" . $getRequestIngredient->ingredient->nama_bahan_baku . "* dengan jumlah *" . $getRequestIngredient->qty_request . "*. Mohon untuk segera menanggapi request ini." . "\n\n" .
                "Terima Kasih.";

                // Send the WhatsApp message using FonnteService (or your preferred service)
                $fonnteService = new FonnteService(); // Replace with your service
                // $fonnteService->sendMessage($user->phone_number, $whatsappMessage);
                $fonnteService->sendMessage('081282133865', $whatsappMessage);
            }
        }

        // Redirect to the request ingredient index page
        return redirect(route('requestIngredient.index'));
    }


    public function statusEdit(Request $request)
    {
        $getRequestIngredient = IngredientRequest::findOrFail($request->id);

        if ($getRequestIngredient->status != 'pending' && $getRequestIngredient->status != 'processing') {
            return response()->json([
                'status' => 'error',
                'message' => 'Request ingredient already done!'
            ], 422);
        }

        if ($request->action == 'confirm') {
            $statusName = "Disetujui";

            $getRequestIngredient->ingredient->qty += $getRequestIngredient->qty_request;
            $getRequestIngredient->ingredient->save();

            $getRequestIngredient->status = 'success';
            $getRequestIngredient->approved_at = Carbon::now();
        } elseif ($request->action == 'processing') {
            $statusName = "Diproses";
            $getRequestIngredient->status = 'processing';
        } elseif ($request->action == 'cancel') {
            $statusName = "Tidak Disetujui";
            $getRequestIngredient->status = 'cancelled';
        }

        // Get users with 'produksi' role
        $getProduksiUser = User::role('produksi')->get();

        foreach ($getProduksiUser as $user) {
            // Create an inbox message
            Inbox::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $user->id,
                'message' => 'Request Bahan Baku ' . $getRequestIngredient->ingredient->nama_bahan_baku . ' sejumlah ' . $getRequestIngredient->qty_request . ' ' . $statusName,
                'is_read' => false,
            ]);

            // Send email
            Mail::to($user->email)->send(new \App\Mail\StatusEditNotificationEmail('request_bahan_baku', $getRequestIngredient, $statusName, $user));

            // Send WhatsApp message
            if ($user->phone_number) {
                // Prepare the WhatsApp message
                $whatsappMessage = "*Status Update untuk Request Bahan Baku*" . "\n\n" .
                "Halo " . $user->name . "," . "\n\n" .
                "Request Bahan Baku untuk *" . $getRequestIngredient->ingredient->nama_bahan_baku . "* dengan jumlah *" . $getRequestIngredient->qty_request . "* telah *" . $statusName . "*." . "\n\n" .
                "Terima Kasih.";

                // Send the WhatsApp message using FonnteService (or your preferred service)
                $fonnteService = new FonnteService(); // Replace with your service
                // $fonnteService->sendMessage($user->phone_number, $whatsappMessage);
                $fonnteService->sendMessage('081282133865', $whatsappMessage);
            }
        }

        // Save the updated request ingredient status
        $getRequestIngredient->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully ' . $request->action . ' product request!'
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
