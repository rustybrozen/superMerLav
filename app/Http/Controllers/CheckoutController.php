<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CheckoutController extends Controller
{



    public function validateStock(Request $request)
    {
        try {
            $cart = $this->getCurrentCart();
            if (!$cart || $cart->cartDetails->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng trống!'
                ]);
            }
            $stockIssues = [];
            $cartUpdated = false;
            foreach ($cart->cartDetails as $item) {
                $product = Product::find($item->product_id);
                if (!$product) {
                    $item->delete();
                    $stockIssues[] = "Sản phẩm '{$item->product->name}' không còn tồn tại và đã được xóa khỏi giỏ hàng.";
                    $cartUpdated = true;
                    continue;
                }

                if (!$product->is_active) {
                    $item->delete();
                    $stockIssues[] = "Sản phẩm '{$product->name}' hiện không có sẵn và đã được xóa khỏi giỏ hàng.";
                    $cartUpdated = true;
                    continue;
                }


                if ($product->quantity < $item->quantity) {
                    if ($product->stock > 0) {
                        $item->update(['quantity' => $product->stock]);
                        $stockIssues[] = "Sản phẩm '{$product->name}' chỉ còn {$product->stock} sản phẩm. Số lượng đã được cập nhật.";
                        $cartUpdated = true;
                    } else {
                        $item->delete();
                        $stockIssues[] = "Sản phẩm '{$product->name}' đã hết hàng và được xóa khỏi giỏ hàng.";
                        $cartUpdated = true;
                    }
                }
            }

            if ($cartUpdated) {
                $this->updateCartTotals($cart);
            }


            if (!empty($stockIssues)) {
                return response()->json([
                    'success' => false,
                    'message' => implode(' ', $stockIssues),
                    'cart_updated' => $cartUpdated
                ]);
            }


            return response()->json([
                'success' => true,
                'message' => 'Tất cả sản phẩm đều có sẵn!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi kiểm tra tồn kho!'
            ]);
        }
    }


    public function processCheckout(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = $this->getCurrentCart();
            if (!$cart || $cart->cartDetails->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng trống!'
                ]);
            }
            $stockValidation = $this->validateStockInternal($cart);
            if (!$stockValidation['valid']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $stockValidation['message']
                ]);
            }
            $order = $this->createOrder($request, $cart);
            $this->createOrderDetails($order, $cart);
            $this->clearCart($cart);
            DB::commit();
            session(['order_placed' => $order->id]);
            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình đặt hàng!'
            ]);
        }
    }




    private function createOrder(Request $request, Cart $cart)
    {
        $customerInfo = $request->input('customer_info');
        $paymentMethod = $request->input('payment_method');
        $orderNumber = $this->generateOrderNumber();
        $orderData = [
            'order_date' => now(),
            'subtotal' => $cart->total,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'total_price' => $cart->total,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'processing',
            'order_status' => 'pending',
            'tracking_number' => $orderNumber,
        ];



        if (auth()->check()) {
            $user = auth()->user();
            $orderData = array_merge($orderData, [
                'user_id' => $user->id,
                'shipping_address' => $user->address,
                'shipping_city' => $user->city ?? 'TP. Hồ Chí Minh',
                'shipping_province' => $user->province ?? 'TP. Hồ Chí Minh',
            ]);
        } else {
            $orderData = array_merge($orderData, [
                'user_id' => null,
                'guest_name' => $customerInfo['name'],
                'guest_email' => $customerInfo['email'],
                'guest_phone' => $customerInfo['phone'],
                'shipping_address' => $customerInfo['address'],
                'shipping_city' => 'TP. Hồ Chí Minh',
                'shipping_province' => 'TP. Hồ Chí Minh',
            ]);
        }

        return Order::create($orderData);
    }


    private function createOrderDetails(Order $order, Cart $cart)
    {
        foreach ($cart->cartDetails as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price_at_purchase' => $item->price_at_add,
                'quantity' => $item->quantity,
            ]);
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('quantity', $item->quantity);
            }
        }
    }


    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('tracking_number', $orderNumber)->exists());

        return $orderNumber;
    }


    private function validateStockInternal(Cart $cart)
    {
        foreach ($cart->cartDetails as $item) {
            $product = Product::find($item->product_id);
            if (!$product || !$product->is_active) {
                return [
                    'valid' => false,
                    'message' => "Sản phẩm '{$item->product->name}' không còn có sẵn!"
                ];
            }
            if ($product->quantity < $item->quantity) {
                return [
                    'valid' => false,
                    'message' => "Sản phẩm '{$product->name}' không đủ số lượng trong kho!"
                ];
            }
        }
        return ['valid' => true];
    }






    private function getCurrentCart()
    {

        if (auth()->check()) {
            return Cart::with('cartDetails.product')->where('user_id', auth()->id())->first();

        
        } else {
            $sessionId = session()->getId();
            return Cart::with('cartDetails.product')->where('session_id', $sessionId)->first();
        }
    }


    private function updateCartTotals(Cart $cart)
    {
        $total = $cart->cartDetails->sum(function ($item) {
            return $item->quantity * $item->price_at_add;
        });

        $totalItems = $cart->cartDetails->sum('quantity');

        $cart->update([
            'total' => $total,
            'total_items' => $totalItems
        ]);
    }


    private function clearCart(Cart $cart)
    {
        $cart->cartDetails()->delete();
        $cart->delete();
    }
}