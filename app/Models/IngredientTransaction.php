<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'ingredient_request_id',
        'user_id',
        'transaction_type',
        'quantity',
        'old_quantity',
        'new_quantity',
        'transaction_date',
        'description',
    ];

    /**
     * Get the ingredient associated with the transaction.
     */
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    /**
     * Get the ingredient request associated with the ingredient transaction.
     */
    public function ingredientRequest()
    {
        return $this->belongsTo(IngredientRequest::class);
    }

    /**
     * Get the user who performed the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
