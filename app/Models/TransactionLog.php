<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'loggable_id',
        'loggable_type',
        'user_id',
        'request_type',
        'quantity',
        'request_date',
        'description',
    ];

    /**
     * Get the owning loggable model (product request or ingredient request).
     */
    public function loggable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who created the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
