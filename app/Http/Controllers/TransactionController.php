<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionShipment;
use App\Models\TransactionShipmentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

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

        $totalTransaction = Transaction::sum('total_price');

        return view('pages.admin.transaction.index', [
            'query' => $query,
            'totalTransaction' => $totalTransaction,
        ]);
    }

    public function cekResi(Request $request)
    {
        return view('pages.admin.transaction.cekResi');
    }

    public function cekResiProcess(Request $request)
    {
        $response = Http::get('https://api.binderbyte.com/v1/track', [
            'api_key' => env('BINDERBYTE_API_KEY'),
            'courier' => $request->courier,
            'awb' => $request->awb,
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            // Handle the response data as needed
            // For example, return it as a response in a controller
            return response()->json($data);
        } else {
            // Handle the error
            return response()->json(['error' => 'Unable to fetch data'], $response->status());
        }

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

        $items = TransactionDetail::with(['transaction', 'product', 'transaction.user'])
            ->where('transactions_id', $transactions_id)
            ->firstOrFail();

        $itemDetails = TransactionDetail::with(['transaction', 'product'])
            ->where('transactions_id', $transactions_id)
            ->get();

        $transaction = Transaction::find($transactions_id);

        return view('pages.admin.transaction.edit', [
            'transaction' => $transaction,
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
        $oldStatus = $item->transaction_status;
        $item->update($data);
        $newStatus = $item->transaction_status;

        if ($newStatus !== $oldStatus) {
            $user = $item->user;
            if ($newStatus === 'shipping') {
                Mail::to($user->email)->send(new \App\Mail\TransactionShippingEmail($user, $item, $data['no_resi']));
            } elseif ($newStatus === 'completed') {
                Mail::to($user->email)->send(new \App\Mail\TransactionCompleteEmail($user, $item));
            } elseif ($newStatus === 'failed') {
                Mail::to($user->email)->send(new \App\Mail\TransactionFailedEmail($user, $item));
            }
        }

        if (!empty($data['no_resi'])) {
            // Always create or update a shipment record for this transaction
            $response = Http::get(env('BINDERBYTE_API_URL'), [
                'api_key' => env('BINDERBYTE_API_KEY'),
                'courier' => 'jne',
                'awb' => $data['no_resi'],
            ]);

            $resiData = $response->json();

            if ($response->successful() && isset($resiData['data'])) {
                $summary = $resiData['data']['summary'];
                $detail = $resiData['data']['detail'];
                $history = $resiData['data']['history'];

                $shipment = TransactionShipment::updateOrCreate(
                    [
                        'transaction_id' => $id,
                        'awb' => $summary['awb']
                    ],
                    [
                        'courier' => $summary['courier'],
                        'service' => $summary['service'],
                        'status' => $summary['status'],
                        'date' => $summary['date'],
                        'description' => $summary['desc'],
                        'amount' => $summary['amount'],
                        'weight' => $summary['weight'],
                        'origin' => $detail['origin'],
                        'destination' => $detail['destination'],
                        'shipper' => $detail['shipper'],
                        'receiver' => $detail['receiver'],
                        'is_crawlable' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );

                foreach ($history as $event) {
                    TransactionShipmentHistory::updateOrCreate(
                        [
                            'transaction_shipment_id' => $shipment->id,
                            'history_date' => $event['date']
                        ],
                        [
                            'description' => $event['desc'],
                            'location' => $event['location']
                        ]
                    );
                }
            } else {
                TransactionShipment::updateOrCreate(
                    [
                        'transaction_id' => $id,
                        'awb' => $data['no_resi']
                    ],
                    [
                        'status' => 'PENDING_CRAWL',
                        'is_crawlable' => false,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }

        return redirect()->route('transaction.edit', $id);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
