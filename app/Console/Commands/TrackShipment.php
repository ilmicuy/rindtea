<?php

namespace App\Console\Commands;

use Str;
use App\Models\TransactionShipment;
use App\Models\TransactionShipmentHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TrackShipment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track:shipment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track shipment and update the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiUrl = env('BINDERBYTE_API_URL');

        $getShipments = TransactionShipment::where('is_crawlable', 1)->get();

        $doneStatus = [
            'DELIVERED',
            'HILANG',
        ];

        foreach ($getShipments as $shipment) {
            $response = Http::get($apiUrl, [
                'api_key' => env('BINDERBYTE_API_KEY'),
                'courier' => 'jne',
                'awb' => $shipment->awb,
            ]);

            $data = $response->json();

            if ($response->successful() && $data['status'] == 200) {
                $summary = $data['data']['summary'];
                $detail = $data['data']['detail'];
                $history = $data['data']['history'];

                $shipment->update([
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
                    'last_crawl_at' => Carbon::now(),
                    'is_crawlable' => ( Str::contains($summary['status'], $doneStatus) ? false : true )
                ]);

                foreach ($history as $event) {
                    TransactionShipmentHistory::updateOrCreate(
                        ['transaction_shipment_id' => $shipment->id, 'history_date' => $event['date']],
                        ['description' => $event['desc'], 'location' => $event['location']]
                    );
                }
            } else {
                // Log or handle the failed API response
                $this->error("Failed to fetch data for AWB: {$shipment->awb}");
            }
        }

        $this->info('Shipment tracking update completed.');
    }
}
