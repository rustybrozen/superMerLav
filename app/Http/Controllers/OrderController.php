<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Hiển thị trang đặt hàng thành công.
     */
  public function success($orderId)
{
    $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);

    // Ensure the user came through the checkout flow
    if (!session('order_placed') || session('order_placed') != $order->id) {
        return redirect()->route('home');
    }

    // Clear session so it cannot be reused
    session()->forget('order_placed');

    return view('orders.success', compact('order'));
}
    /**
     * Hiển thị chi tiết đơn hàng.
     */
    public function details($orderId)
    {
        $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);

        return view('orders.details', compact('order'));
    }

    /**
     * Theo dõi trạng thái đơn hàng.
     */
    public function track($orderId)
    {
        $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);

        return view('orders.track', compact('order'));
    }
}