<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SummaryController extends Controller
{
    public function index(Request $request)
    {
    
        $activeCustomers = User::where('is_disabled', false)->where('is_admin', false)->count();
        $activeProducts  = Product::where('is_active', true)->count();
        $activeCategories = Category::where('is_active', true)->count();
        $pendingOrdersCount = Order::where('order_status', 'pending')->count();

      
        [$from, $to, $mode] = $this->resolveRange($request);

       
        $completedBase = Order::where('payment_status', 'completed')
            ->whereBetween('created_at', [$from, $to]);

       
        $ordersCount = (clone $completedBase)->count();
        $revenue = (clone $completedBase)->sum('total_price');

       
        $profit = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('products as p', 'p.id', '=', 'od.product_id')
            ->where('o.payment_status', 'completed')
            ->whereBetween('o.created_at', [$from, $to])
            ->selectRaw('SUM( (od.price_at_purchase - COALESCE(p.in_price,0)) * od.quantity ) as profit_sum')
            ->value('profit_sum') ?? 0;

        // Table data (completed orders only)
        $orders = Order::with(['user', 'orderDetails.product'])
            ->where('payment_status', 'completed')
            ->whereBetween('created_at', [$from, $to])
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dashboard', compact(
            'activeCustomers','activeProducts','activeCategories','pendingOrdersCount',
            'ordersCount','revenue','profit','orders','from','to','mode'
        ));
    }

    private function resolveRange(Request $request): array
    {
        $mode = $request->query('mode', 'day'); 
        $today = now();

        switch ($mode) {
            case 'week':
                $from = $today->copy()->startOfWeek();
                $to   = $today->copy()->endOfWeek();
                break;
            case 'month':
                $from = $today->copy()->startOfMonth();
                $to   = $today->copy()->endOfMonth();
                break;
            case 'year':
                $from = $today->copy()->startOfYear();
                $to   = $today->copy()->endOfYear();
                break;
            case 'custom':
                $from = $request->query('from') ? Carbon::parse($request->query('from'))->startOfDay() : $today->copy()->startOfDay();
                $to   = $request->query('to')   ? Carbon::parse($request->query('to'))->endOfDay()   : $today->copy()->endOfDay();
                break;
            case 'day':
            default:
                $from = $today->copy()->startOfDay();
                $to   = $today->copy()->endOfDay();
                $mode = 'day';
        }
        return [$from, $to, $mode];
    }
}