<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'guest_name', 'guest_email', 'guest_phone',
        'shipping_address', 'shipping_city', 'shipping_province', 
        'shipping_postal_code', 'shipping_notes',
        'order_date', 'subtotal', 'discount_amount', 'shipping_fee', 'total_price',
        'payment_method', 'payment_status', 'order_status',
        'tracking_number', 'shipped_at', 'delivered_at',
        'voucher_code'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function review()
    {
        return $this->hasOne(ProductReview::class);
    }

  
    public function isGuestOrder()
    {
        return is_null($this->user_id);
    }

    public function getCustomerName()
    {
        return $this->isGuestOrder() ? $this->guest_name : $this->user->fullname;
    }

    public function getCustomerEmail()
    {
        return $this->isGuestOrder() ? $this->guest_email : $this->user->email;
    }

    public function getCustomerPhone()
    {
        return $this->isGuestOrder() ? $this->guest_phone : $this->user->phone;
    }

    public function getFullShippingAddress()
    {
        return "{$this->shipping_address}, {$this->shipping_city}, {$this->shipping_province}" . 
               ($this->shipping_postal_code ? " {$this->shipping_postal_code}" : "");
    }

    
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeGuest($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

   
    public function isPending()
    {
        return $this->order_status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->order_status === 'confirmed';
    }

    public function isShipped()
    {
        return in_array($this->order_status, ['shipped', 'delivered']);
    }

    public function isDelivered()
    {
        return $this->order_status === 'delivered';
    }

    public function isCancelled()
    {
        return $this->order_status === 'cancelled';
    }

    public function canBeCancelled()
    {
        return in_array($this->order_status, ['pending', 'confirmed']);
    }

    
    public function isPaid()
    {
        return $this->payment_status === 'completed';
    }

    public function isPaymentPending()
    {
        return $this->payment_status === 'pending';
    }

    
    public function getTotalItemsAttribute()
    {
        return $this->orderDetails->sum('quantity');
    }

    
    public function getOrderNumberAttribute()
    {
        return 'ORD' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}