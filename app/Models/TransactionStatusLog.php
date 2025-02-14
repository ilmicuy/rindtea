<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'column_name',
        'old_value',
        'new_value',
        'description',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
