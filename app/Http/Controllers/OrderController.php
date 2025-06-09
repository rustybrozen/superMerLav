<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

    public function success($orderId)
    {
        $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);
        if (!session('order_placed') || session('order_placed') != $order->id) {
            return redirect()->route('home');
        }
        session()->forget('order_placed');
        return view('orders.success', compact('order'));
    }

    public function details($orderId)
    {
        $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);
        return view('orders.details', compact('order'));
    }

   
    public function track($orderId)
    {
        $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);
        return view('orders.track', compact('order'));
    }
}