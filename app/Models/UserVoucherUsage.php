<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucherUsage extends Model
{
    use HasFactory;

    protected $table = 'user_voucher_usage';

    protected $fillable = [
        'user_id', 'voucher_id', 'usage_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    
  
    public function canUse()
    {
        return $this->usage_count < $this->voucher->user_usage_limit;
    }
}