<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Defining the fillable fields for mass assignment
    protected $fillable = [
        'products_id',
        'qty',
        'users_id',
    ];

    protected $hidden = [];

    /**
     * Relationship with the Product model
     * Each cart item is associated with a single product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    /**
     * Relationship with the User model
     * Each cart belongs to a specific user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    /**
     * Update the cart quantity
     *
     * @param int $qty The quantity to update
     * @return bool true if updated, false otherwise
     */
    public function updateQuantity(int $qty)
    {
        if ($qty <= 0) {
            return false; // Do not allow negative or zero quantities
        }
        $this->qty = $qty;
        return $this->save();
    }

    /**
     * Calculate the total price for the cart item
     *
     * @return float The total price for this cart item
     */
    public function getTotalPriceAttribute()
    {
        return $this->product->price * $this->qty;
    }

    /**
     * Check if the requested quantity is available in stock
     *
     * @param int $requestedQty
     * @return bool true if available, false otherwise
     */
    public function isStockAvailable(int $requestedQty)
    {
        return $this->product->quantity >= $requestedQty;
    }
}
