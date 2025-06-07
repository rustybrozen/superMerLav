<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_id', 'quantity', 'price_at_add'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Get subtotal for this cart detail
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price_at_add;
    }

    // Check if product price has changed since added to cart
    public function getPriceChangedAttribute()
    {
        return $this->price_at_add !== $this->product->price;
    }
}