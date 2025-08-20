<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }


    public function check(Request $request)
    {
        // Lấy dữ liệu từ form
        $trackingId = $request->input('trackingId');
        $email = $request->input('email');


        $order = Order::where('tracking_number', $trackingId)
            ->where('guest_email', $email)
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng!');
        }

        

        return view('track-result', [
            
            'trackingId' => $trackingId,
            'order_status' => $order->order_status,
            'payment_status' => $order->payment_status,
            'total_price' => $order->total_price,
   
        ]);
    }
}
