<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\Ingredient;
use App\Models\IngredientRequest;
use App\Models\IngredientTransaction;
use App\Models\TransactionLog;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class RequestIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $requestBahanBaku = IngredientRequest::orderBy('created_at', 'DESC')->paginate(10);

        $bahanBaku = Ingredient::all();

        // Filter low stock ingredients
        $lowStockIngredients = $bahanBaku->filter(function ($ingredient) {
            return ($ingredient->satuan == 'pcs' && $ingredient->qty < 50) ||
                ($ingredient->satuan == 'gram' && $ingredient->qty < 1000);
        });

        // Check if there are any low stock ingredients
        $hasLowStock = $lowStockIngredients->isNotEmpty();

        return view('pages.admin.requestIngredient.index', [
            'ingredients' => $bahanBaku,
            'ingredientRequest' => $requestBahanBaku,
            'hasLowStock' => $hasLowStock,
            'lowStockIngredients' => $lowStockIngredients,
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
            'kode_request_bahan_baku' => (new IngredientRequest)->generateKodeRequestBahanBaku(),
            'ingredient_id' => $request->pilih_bahan_baku,
            'qty_request' => $request->qty_request,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Log the ingredient request as an IngredientTransaction
        $ingredient = Ingredient::findOrFail($request->pilih_bahan_baku);

        $oldQuantity = $ingredient->qty;
        $newQuantity = $oldQuantity + $request->qty_request;

        IngredientTransaction::create([
            'ingredient_id' => $ingredient->id,
            'ingredient_request_id' => $getRequestIngredient->id,
            'user_id' => Auth::user()->id,
            'transaction_type' => 'request',
            'quantity' => $request->qty_request,
            'old_quantity' => $oldQuantity,
            'new_quantity' => $newQuantity,
            'transaction_date' => Carbon::now(),
            'description' => 'Requested ' . $request->qty_request . ' of ' . $ingredient->nama_bahan_baku . ' with #' . $getRequestIngredient->kode_request_bahan_baku,
        ]);

        // Log the request to the transaction logs
        TransactionLog::create([
            'loggable_id' => $getRequestIngredient->id,
            'loggable_type' => IngredientRequest::class,
            'user_id' => Auth::user()->id,
            'request_type' => 'request_ingredient',
            'quantity' => $request->qty_request,
            'request_date' => Carbon::now(),
            'description' => 'Requested ' . $request->qty_request . ' of ' . $ingredient->nama_bahan_baku,
        ]);

        // Update the ingredient quantity (if applicable)
        // $ingredient->update(['qty' => $newQuantity]);

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


    public function logs(Request $request)
    {
        $query = IngredientTransaction::with(['ingredient', 'user']);

        // Check if date range is selected
        if ($request->filled('date_range')) {
            $dateRange = explode(' to ', $request->input('date_range'));

            if (count($dateRange) === 2) {
                $startDate = Carbon::parse($dateRange[0])->startOfDay();
                $endDate = Carbon::parse($dateRange[1])->endOfDay();

                // Filter by date range
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            }
        }

        // Order and paginate the results
        $ingredientTransactions = $query->orderBy('created_at', 'DESC')->paginate(10);

        $dateRange = $request->has('date_range') ? $request->input('date_range') : null;

        // Pass the transactions to the view
        return view('pages.admin.requestIngredient.ingredientTransaction', compact('ingredientTransactions', 'dateRange'));
    }

    public function downloadPdf(Request $request)
    {
        $query = IngredientTransaction::with(['ingredient', 'user']);
        $dateRangeRaw = 'Semua Waktu';

        // Check if date range is selected
        if ($request->filled('date_range')) {
            $dateRangeRaw = $request->input('date_range');
            $dateRange = explode(' to ', $request->input('date_range'));

            if (count($dateRange) === 2) {
                $startDate = Carbon::parse($dateRange[0])->startOfDay();
                $endDate = Carbon::parse($dateRange[1])->endOfDay();

                // Filter by date range
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            }
        }

        // Get the filtered request ingredients
        $ingredientTransaction = $query->get();

        // Load the view for the PDF
        $pdf = PDF::loadView('pages.admin.requestIngredient.ingredientTransactionPdf', compact('ingredientTransaction', 'dateRangeRaw'));

        // Stream the PDF back to the user for download
        return $pdf->download('request-bahan-baku-logs.pdf');
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

        $statusName = '';

        if ($request->action == 'confirm') {
            $statusName = "Disetujui";

            $getRequestIngredient->ingredient->qty += $getRequestIngredient->qty_request;
            $getRequestIngredient->ingredient->save();

            $getRequestIngredient->status = 'success';
            $getRequestIngredient->approved_at = Carbon::now();

            // Log the approval action
            TransactionLog::create([
                'loggable_id' => $getRequestIngredient->id,
                'loggable_type' => IngredientRequest::class,
                'user_id' => Auth::user()->id,
                'request_type' => 'request_ingredient',
                'quantity' => $getRequestIngredient->qty_request,
                'request_date' => Carbon::now(),
                'description' => 'Approved request for ' . $getRequestIngredient->qty_request . ' of ' . $getRequestIngredient->ingredient->nama_bahan_baku,
            ]);
        } elseif ($request->action == 'processing') {
            $statusName = "Diproses";
            $getRequestIngredient->status = 'processing';
            $getRequestIngredient->processing_at = Carbon::now();
        } elseif ($request->action == 'owner_approval') {
            $statusName = "Disetujui Oleh Owner";
            $getRequestIngredient->approved_by_owner = Carbon::now();
        } elseif ($request->action == 'owner_approval_cancel') {
            $statusName = "Tidak Disetujui Oleh Owner";
            $getRequestIngredient->status = 'cancelled';
        } elseif ($request->action == 'cancel') {
            $statusName = "Tidak Disetujui";
            $getRequestIngredient->status = 'cancelled';

            // Log the cancellation action
            TransactionLog::create([
                'loggable_id' => $getRequestIngredient->id,
                'loggable_type' => IngredientRequest::class,
                'user_id' => Auth::user()->id,
                'request_type' => 'request_ingredient',
                'quantity' => $getRequestIngredient->qty_request,
                'request_date' => Carbon::now(),
                'description' => 'Cancelled request for ' . $getRequestIngredient->qty_request . ' of ' . $getRequestIngredient->ingredient->nama_bahan_baku,
            ]);
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
                $fonnteService->sendMessage($user->phone_number, $whatsappMessage);
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
    public function show($id)
    {
        $ingredientRequest = IngredientRequest::with(['ingredient'])->findOrFail($id);

        // Prepare the response with formatted dates
        return response()->json([
            'created_at' => $ingredientRequest->created_at ? $ingredientRequest->created_at->format('Y-m-d H:i:s') : null,
            'owner_approved_at' => $ingredientRequest->approved_by_owner ? $ingredientRequest->approved_by_owner->format('Y-m-d H:i:s') : 'Not Approved Yet',
            'processing_at' => $ingredientRequest->processing_at ? $ingredientRequest->processing_at->format('Y-m-d H:i:s') : 'Not Processed Yet',
            'completed_at' => $ingredientRequest->approved_at ? $ingredientRequest->approved_at->format('Y-m-d H:i:s') : 'Not Completed Yet',
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
