<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_code', 'usage_limit', 'user_usage_limit',
        'condition_total_price', 'discount_type', 'discount_value',
        'description', 'valid_from', 'valid_to'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
        'discount_type' => 'string',
    ];

    public function userUsage()
    {
        return $this->hasMany(UserVoucherUsage::class);
    }

 
    public function isValid()
    {
        $now = now();
        return $this->valid_from <= $now && $this->valid_to >= $now;
    }

    
    public function hasReachedLimit()
    {
        return $this->userUsage()->sum('usage_count') >= $this->usage_limit;
    }

  
    public function calculateDiscount($totalPrice)
    {
        if ($totalPrice < $this->condition_total_price) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return ($totalPrice * $this->discount_value) / 100;
        }

        return $this->discount_value;
    }
}
