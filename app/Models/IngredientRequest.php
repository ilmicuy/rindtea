<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'kode_request_bahan_baku',
        'ingredient_id',
        'qty_request',
        'notes',
        'approved_at',
        'approved_by_owner',
        'processing_at',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'approved_by_owner' => 'datetime:Y-m-d H:i:s',
        'processing_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function generateKodeRequestBahanBaku()
    {
        // Get the last Ingredient code from the database
        $lastRequestIngredient = self::latest('kode_request_bahan_baku')->first();

        // Extract the numeric part from the last kode_produk (e.g., REQ-ING-0001 -> 1)
        if ($lastRequestIngredient) {
            $lastNumber = intval(substr($lastRequestIngredient->kode_request_bahan_baku, 8));
        } else {
            $lastNumber = 0;
        }

        // Increment the number by 1
        $newNumber = $lastNumber + 1;

        // Format the new number with leading zeros (e.g., 1 -> 0001)
        $newKodeRequestBahanBaku = 'REQ-ING-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newKodeRequestBahanBaku;
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function logs()
    {
        return $this->morphMany(TransactionLog::class, 'loggable');
    }
}
