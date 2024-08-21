<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'kode_request_produk',
        'product_id',
        'qty_requested',
        'notes',
        'status',
        'approved_by_owner',
        'success_at'
    ];

    public function generateKodeRequestProduk()
    {
        // Get the last product code from the database
        $lastRequestProduct = self::latest('kode_request_produk')->first();

        // Extract the numeric part from the last kode_produk (e.g., PRD-0001 -> 1)
        if ($lastRequestProduct) {
            $lastNumber = intval(substr($lastRequestProduct->kode_request_produk, 8));
        } else {
            $lastNumber = 0;
        }

        // Increment the number by 1
        $newNumber = $lastNumber + 1;

        // Format the new number with leading zeros (e.g., 1 -> 0001)
        $newKodeRequestProduk = 'REQ-PRD-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newKodeRequestProduk;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function logs()
    {
        return $this->morphMany(TransactionLog::class, 'loggable');
    }
}
