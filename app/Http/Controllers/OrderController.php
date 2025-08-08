<?php

namespace App\Http\Controllers;

use Auth;
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

    public function details(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }


        $order->load('orderDetails.product.category');
        return view('orders.details', compact('order'));
    }


    public function track($orderId)
    {
        $order = Order::with(['orderDetails.product.category'])->findOrFail($orderId);
        return view('orders.track', compact('order'));
    }

    public function orders()
    {

        $userId = Auth::id();
        $orders = Order::with(['orderDetails.product.category'])->where('user_id', $userId)->
            orderByDesc('created_at')->
            get();
        return view('orders.all', compact('orders'));
    }
}