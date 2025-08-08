<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = trim((string) $request->query('q', ''));

        $ordersQuery = Order::with(['user'])
            ->withCount('orderDetails')
            ->when($status, fn($qb) => $qb->where('order_status', $status))
            ->when($q !== '', function ($qb) use ($q) {
                $needle = $q;

            
                $idCandidate = preg_replace('/[^0-9]/', '', $needle); 
                $qb->where(function ($inner) use ($needle, $idCandidate) {
              
                    if ($idCandidate !== '') {
                        $inner->orWhere('id', (int) $idCandidate);
                    }

                
                    $inner->orWhereRaw("CONCAT('ORD', LPAD(id, 6, '0')) LIKE ?", ['%' . $needle . '%']);

            
                    $inner->orWhereHas('user', function ($uq) use ($needle) {
                        $uq->where(function ($u) use ($needle) {
                            $u->where('fullname', 'LIKE', '%' . $needle . '%')
                                ->orWhere('username', 'LIKE', '%' . $needle . '%')
                                ->orWhere('email', 'LIKE', '%' . $needle . '%')
                                ->orWhere('phone', 'LIKE', '%' . $needle . '%');
                        });
                    });

             
                    $inner->orWhere('guest_name', 'LIKE', '%' . $needle . '%')
                        ->orWhere('guest_email', 'LIKE', '%' . $needle . '%')
                        ->orWhere('guest_phone', 'LIKE', '%' . $needle . '%');
                });
            })
            ->orderByRaw("CASE WHEN order_status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at');

        $orders = $ordersQuery->paginate(15)->withQueryString();

        $pendingCount = Order::where('order_status', 'pending')->count();
        $latestPending = Order::where('order_status', 'pending')->latest('created_at')->take(5)->get();

        return view('admin.orders.index', compact('orders', 'pendingCount', 'latestPending', 'status', 'q'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {

        if (in_array($order->order_status, ['cancelled', 'delivered'])) {
            return back()->with('ok', 'Không thay đổi trạng thái');
        }

        $data = $request->validate([
            'order_status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);


        $invalidBackwards = [
            'shipped' => ['pending', 'confirmed', 'processing'],
            'delivered' => ['pending', 'confirmed', 'processing', 'shipped'],
            'cancelled' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered'],
        ];
        if (isset($invalidBackwards[$order->order_status]) && in_array($data['order_status'], $invalidBackwards[$order->order_status])) {
            return back()->with('ok', 'Không thay đổi trạng thái.');
        }

        $order->order_status = $data['order_status'];

        if ($data['order_status'] === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }
        if ($data['order_status'] === 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
        }

        $order->save();

        return back()->with('ok', 'Order status updated');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded',
        ]);

        $order->payment_status = $data['payment_status'];
        $order->save();

        return back()->with('ok', 'Thay đổi trạng thái thanh toán thành công');
    }
}