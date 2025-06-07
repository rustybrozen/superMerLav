<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\UserVoucherUsage;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create order for registered user
     */
    public function createUserOrder($user, $orderData, $cartItems, $voucherCode = null)
    {
        return DB::transaction(function () use ($user, $orderData, $cartItems, $voucherCode) {
            $subtotal = $this->calculateSubtotal($cartItems);
            $discount = 0;
            $voucher = null;

            // Apply voucher if provided
            if ($voucherCode) {
                $voucher = $this->validateAndApplyVoucher($voucherCode, $subtotal, $user->id);
                $discount = $voucher ? $voucher->calculateDiscount($subtotal) : 0;
            }

            $total = $subtotal - $discount + ($orderData['shipping_fee'] ?? 0);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_address' => $orderData['shipping_address'],
                'shipping_city' => $orderData['shipping_city'],
                'shipping_province' => $orderData['shipping_province'],
                'shipping_postal_code' => $orderData['shipping_postal_code'] ?? null,
                'shipping_notes' => $orderData['shipping_notes'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_fee' => $orderData['shipping_fee'] ?? 0,
                'total_price' => $total,
                'payment_method' => $orderData['payment_method'],
                'voucher_code' => $voucherCode,
            ]);

            // Create order details
            $this->createOrderDetails($order, $cartItems);

            // Update voucher usage
            if ($voucher) {
                $this->updateVoucherUsage($voucher, $user->id);
            }

            // Clear user's cart
            Cart::where('user_id', $user->id)->delete();

            return $order;
        });
    }

    /**
     * Create order for guest
     */
    public function createGuestOrder($guestData, $cartItems, $voucherCode = null)
    {
        return DB::transaction(function () use ($guestData, $cartItems, $voucherCode) {
            $subtotal = $this->calculateSubtotal($cartItems);
            $discount = 0;
            $voucher = null;

            // Apply voucher if provided (guest vouchers might have different rules)
            if ($voucherCode) {
                $voucher = Voucher::where('voucher_code', $voucherCode)
                    ->where('valid_from', '<=', now())
                    ->where('valid_to', '>=', now())
                    ->first();
                
                if ($voucher && $subtotal >= $voucher->condition_total_price) {
                    $discount = $voucher->calculateDiscount($subtotal);
                }
            }

            $total = $subtotal - $discount + ($guestData['shipping_fee'] ?? 0);

            // Create order
            $order = Order::create([
                'user_id' => null, // Guest order
                'guest_name' => $guestData['guest_name'],
                'guest_email' => $guestData['guest_email'],
                'guest_phone' => $guestData['guest_phone'],
                'shipping_address' => $guestData['shipping_address'],
                'shipping_city' => $guestData['shipping_city'],
                'shipping_province' => $guestData['shipping_province'],
                'shipping_postal_code' => $guestData['shipping_postal_code'] ?? null,
                'shipping_notes' => $guestData['shipping_notes'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_fee' => $guestData['shipping_fee'] ?? 0,
                'total_price' => $total,
                'payment_method' => $guestData['payment_method'],
                'voucher_code' => $voucherCode,
            ]);

            // Create order details
            $this->createOrderDetails($order, $cartItems);

            return $order;
        });
    }

    /**
     * Calculate subtotal from cart items
     */
    private function calculateSubtotal($cartItems)
    {
        return collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    /**
     * Create order detail records
     */
    private function createOrderDetails($order, $cartItems)
    {
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'price_at_purchase' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }
    }

    /**
     * Validate and apply voucher for registered users
     */
    private function validateAndApplyVoucher($voucherCode, $subtotal, $userId)
    {
        $voucher = Voucher::where('voucher_code', $voucherCode)
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->first();

        if (!$voucher) {
            throw new \Exception('Invalid or expired voucher code');
        }

        if ($subtotal < $voucher->condition_total_price) {
            throw new \Exception("Minimum order amount is " . number_format($voucher->condition_total_price) . " VND");
        }

        // Check user usage limit
        $userUsage = UserVoucherUsage::where('user_id', $userId)
            ->where('voucher_id', $voucher->id)
            ->first();

        if ($userUsage && $userUsage->usage_count >= $voucher->user_usage_limit) {
            throw new \Exception('You have reached the usage limit for this voucher');
        }

        // Check global usage limit
        if ($voucher->hasReachedLimit()) {
            throw new \Exception('This voucher has reached its usage limit');
        }

        return $voucher;
    }

    /**
     * Update voucher usage count
     */
    private function updateVoucherUsage($voucher, $userId)
    {
        $userUsage = UserVoucherUsage::firstOrCreate([
            'user_id' => $userId,
            'voucher_id' => $voucher->id,
        ], [
            'usage_count' => 0
        ]);

        $userUsage->increment('usage_count');
    }

    /**
     * Update order status
     */
    public function updateOrderStatus($orderId, $status, $additionalData = [])
    {
        $order = Order::findOrFail($orderId);
        
        $updateData = ['order_status' => $status];
        
        // Add timestamp based on status
        switch ($status) {
            case 'shipped':
                $updateData['shipped_at'] = now();
                if (isset($additionalData['tracking_number'])) {
                    $updateData['tracking_number'] = $additionalData['tracking_number'];
                }
                break;
            case 'delivered':
                $updateData['delivered_at'] = now();
                break;
        }

        $order->update($updateData);
        
        return $order;
    }
}