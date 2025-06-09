<?php
// Simplified Cart Model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }


    public function getTotalAttribute()
    {
        return $this->cartDetails->sum(function ($detail) {
            return $detail->quantity * $detail->price_at_add;
        });
    }


    public function getTotalItemsAttribute()
    {
        return $this->cartDetails->sum('quantity');
    }


    public static function getCart($userId = null, $sessionId = null)
    {
        if ($userId) {
            return static::firstOrCreate(['user_id' => $userId]);
        }

        return static::firstOrCreate(['session_id' => $sessionId]);
    }


    public function addItem($productId, $quantity = 1)
    {
        $product = Product::find($productId);

        $cartDetail = $this->cartDetails()->where('product_id', $productId)->first();

        if ($cartDetail) {
            $cartDetail->increment('quantity', $quantity);
        } else {
            $this->cartDetails()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price_at_add' => $product->price
            ]);
        }

        return $this;
    }


    public function removeItem($productId)
    {
        $this->cartDetails()->where('product_id', $productId)->delete();
        return $this;
    }


    public function updateItemQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $productStock = Product::find($productId)->quantity;

        if ($quantity > $productStock) {
            return $this->cartDetails()->where('product_id', $productId)->update([
                'quantity' => $productStock
            ]);

        }

        $this->cartDetails()->where('product_id', $productId)->update([
            'quantity' => $quantity
        ]);

        return $this;
    }


    public function clear()
    {

        $this->cartDetails()->delete();
        return $this;
    }



    public function transferToUser($userId)
    {

        $userCart = static::where('user_id', $userId)->first();

        if ($userCart) {

            foreach ($this->cartDetails as $detail) {
                $userCart->addItem($detail->product_id, $detail->quantity);
            }


            $this->delete();

            return $userCart;
        } else {

            $this->update([
                'user_id' => $userId,
                'session_id' => null
            ]);

            return $this;
        }
    }
}