<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'transaction_id',
        'user_id',
        'transaction_type',
        'quantity',
        'old_quantity',
        'new_quantity',
        'transaction_date',
        'description',
    ];

    /**
     * Get the product associated with the transaction.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the transaction associated with the product transaction.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the user who performed the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include transactions for a specific year.
     */
    public function scopeOfYear($query, $year)
    {
        return $query->whereYear('transaction_date', $year);
    }

    /**
     * Scope a query to only include transactions for a specific month.
     */
    public function scopeOfMonth($query, $year, $month)
    {
        return $query->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month);
    }

    /**
     * Scope a query to only include transactions for a specific week.
     */
    public function scopeOfWeek($query, $year, $week)
    {
        return $query->whereYear('transaction_date', $year)
            ->whereRaw('WEEKOFYEAR(transaction_date) = ?', [$week]);
    }
}
