<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TransactionStatusLog;

class Transaction extends Model
{
    // use HasFactory;

    use SoftDeletes, HasUuids;


    protected $fillable = [
        'kode_transaksi',
        'users_id',
        'transaction_status',
        'total_price',
        'snap_token',
        'paid_at',
        'paid_payload',
        'payment_method',
        'shipment_courier',
        'shipment_cost',
        'shipment_address_id',
        'refund_status',
        'refund_no_rek',
    ];

    protected $hidden = [];

    public static function boot()
    {
        parent::boot();

        // Log creation of a new transaction
        static::created(function ($transaction) {
            self::logChanges($transaction, 'created', []);
        });

        // Log update of a transaction
        static::updating(function ($transaction) {
            $original = $transaction->getOriginal();  // Get the original values before the update
            $changes = $transaction->getDirty();  // Get the changes that are about to be made
            self::logChanges($transaction, 'updated', $original, $changes);
        });

        // Log deletion of a transaction
        static::deleted(function ($transaction) {
            self::logChanges($transaction, 'deleted', $transaction->getOriginal());
        });
    }

    /**
     * Log changes to the transaction.
     *
     * @param  Transaction  $transaction
     * @param  string  $action (created, updated, deleted)
     * @param  array  $original (the original values before changes)
     * @param  array  $changes (the new values, only required for updates)
     */
    protected static function logChanges($transaction, $action, $original, $changes = [])
    {
        if ($action === 'created' || $action === 'deleted') {
            // Log all fields for creation or deletion
            foreach ($original as $column => $value) {
                TransactionStatusLog::create([
                    'transaction_id' => $transaction->id,
                    'column_name'    => $column,
                    'old_value'      => $value,
                    'new_value'      => $action === 'deleted' ? null : $value,
                    'description'    => ucfirst($action) . " transaction",
                ]);
            }
        }

        if ($action === 'updated') {
            // Only log the fields that were changed
            foreach ($changes as $column => $newValue) {
                TransactionStatusLog::create([
                    'transaction_id' => $transaction->id,
                    'column_name'    => $column,
                    'old_value'      => $original[$column] ?? null,
                    'new_value'      => $newValue,
                    'description'    => "$column berubah dari {$original[$column]} ke $newValue",
                ]);
            }
        }
    }

    public function generateKodeTransaksi()
    {
        // Get the last Ingredient code from the database
        $lastTransaksi = self::latest('kode_transaksi')->first();

        // Extract the numeric part from the last kode_produk (e.g., TRX-20240822-0001 -> 1)
        if ($lastTransaksi) {
            $lastNumber = intval(substr($lastTransaksi->kode_transaksi, 13));
        } else {
            $lastNumber = 0;
        }

        // Increment the number by 1
        $newNumber = $lastNumber + 1;

        // Format the new number with leading zeros (e.g., 1 -> 0001)
        $newKodeTransaksi = 'TRX-' . Carbon::now()->format('Ymd') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newKodeTransaksi;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }

    public function addressChoosen()
    {
        return $this->belongsTo(Address::class, 'shipment_address_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'users_id', 'users_id');
    }

    public function transactionShipment()
    {
        return $this->hasMany(TransactionShipment::class);
    }

    public function transactionStatusLogs()
    {
        return $this->hasMany(TransactionStatusLog::class);
    }
}
