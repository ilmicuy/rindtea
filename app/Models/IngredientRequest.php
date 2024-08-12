<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'ingredient_id',
        'qty_request',
        'approved_at',
        'approved_by_owner',
        'status',
        'created_at',
        'updated_at',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function logs()
    {
        return $this->morphMany(TransactionLog::class, 'loggable');
    }
}
