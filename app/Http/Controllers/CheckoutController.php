<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
  


public function validateStock(Request $request)
{
    try {
        // Log start of validation
        Log::info('Starting stock validation');

        // Get current cart
        $cart = $this->getCurrentCart();
        Log::info('Current Cart Retrieved', ['cart' => $cart]);

        // Check if cart is empty
        if (!$cart || $cart->cartDetails->isEmpty()) {
            Log::info('Cart is empty or does not exist');
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống!'
            ]);
        }

        // Log cart ID and number of items
        Log::info("Cart ID: {$cart->id}, Items Count: " . $cart->cartDetails->count());

        $stockIssues = [];
        $cartUpdated = false;

        // Loop through each item in cart
        foreach ($cart->cartDetails as $item) {
            Log::info("Processing item ID: {$item->id}, Product ID: {$item->product_id}");

            $product = Product::find($item->product_id);

            // If product doesn't exist
            if (!$product) {
                Log::warning("Product ID {$item->product_id} not found. Deleting cart item.");
                $item->delete();
                $stockIssues[] = "Sản phẩm '{$item->product->name}' không còn tồn tại và đã được xóa khỏi giỏ hàng.";
                $cartUpdated = true;
                continue;
            }

            // If product is inactive
            if (!$product->is_active) {
                Log::warning("Product ID {$item->product_id} is inactive. Deleting cart item.", [
                    'product_name' => $product->name
                ]);
                $item->delete();
                $stockIssues[] = "Sản phẩm '{$product->name}' hiện không có sẵn và đã được xóa khỏi giỏ hàng.";
                $cartUpdated = true;
                continue;
            }

            
            if ($product->quantity < $item->quantity) {
                if ($product->stock > 0) {
                    Log::info("Updating quantity for product ID {$item->product_id}", [
                        'old_quantity' => $item->quantity,
                        'new_quantity' => $product->stock,
                        'product_stock' => $product->stock
                    ]);

                    $item->update(['quantity' => $product->stock]);
                    $stockIssues[] = "Sản phẩm '{$product->name}' chỉ còn {$product->stock} sản phẩm. Số lượng đã được cập nhật.";
                    $cartUpdated = true;
                } else {
                    Log::info("Product ID {$item->product_id} is out of stock. Deleting cart item.", [
                        'product_name' => $product->name
                    ]);

                    $item->delete();
                    $stockIssues[] = "Sản phẩm '{$product->name}' đã hết hàng và được xóa khỏi giỏ hàng.";
                    $cartUpdated = true;
                }
            }
        }

        // Update cart totals if needed
        if ($cartUpdated) {
            Log::info("Cart was updated. Recalculating totals...");
            $this->updateCartTotals($cart);
        }

        // Return response based on stock issues
        if (!empty($stockIssues)) {
            Log::info("Stock issues found", ['issues' => $stockIssues]);
            return response()->json([
                'success' => false,
                'message' => implode(' ', $stockIssues),
                'cart_updated' => $cartUpdated
            ]);
        }

        Log::info("All items have sufficient stock");
        return response()->json([
            'success' => true,
            'message' => 'Tất cả sản phẩm đều có sẵn!'
        ]);

    } catch (\Exception $e) {
        // Log exception details
        Log::error('Stock validation error: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTrace()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi kiểm tra tồn kho!'
        ]);
    }
}
    
    /**
     * Xử lý thanh toán và tạo đơn hàng
     */
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
            
            // 2. Validate một lần nữa trước khi tạo đơn hàng
            $stockValidation = $this->validateStockInternal($cart);
            if (!$stockValidation['valid']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $stockValidation['message']
                ]);
            }
            
            // 3. Tạo đơn hàng
            $order = $this->createOrder($request, $cart);
            
            // 4. Tạo chi tiết đơn hàng và cập nhật tồn kho
            $this->createOrderDetails($order, $cart);
            
            // 5. Xóa giỏ hàng
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
            Log::error('Checkout process error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình đặt hàng!'
            ]);
        }
    }
    
    /**
     * Hiển thị trang thành công
     */
    public function success($orderId)
    {
        $order = Order::with('orderDetails.product')->findOrFail($orderId);
        
        // Kiểm tra quyền truy cập
        if (auth()->check()) {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Không có quyền truy cập đơn hàng này.');
            }
        } else {
            // Guest user - kiểm tra session
            if ($order->user_id !== null) {
                abort(403, 'Không có quyền truy cập đơn hàng này.');
            }
        }
        
        return view('orders.checkout-success', compact('order'));
    }
    
    /**
     * Tạo đơn hàng mới
     */
    private function createOrder(Request $request, Cart $cart)
    {
        $customerInfo = $request->input('customer_info');
        $paymentMethod = $request->input('payment_method');
        
        // Generate order number
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
            // User đã đăng nhập
            $user = auth()->user();
            $orderData = array_merge($orderData, [
                'user_id' => $user->id,
                'shipping_address' => $user->address,
                'shipping_city' => $user->city ?? 'TP. Hồ Chí Minh',
                'shipping_province' => $user->province ?? 'TP. Hồ Chí Minh',
            ]);
        } else {
            // Guest user
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
    
    /**
     * Tạo chi tiết đơn hàng
     */
    private function createOrderDetails(Order $order, Cart $cart)
    {
        foreach ($cart->cartDetails as $item) {
            // Tạo order detail
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price_at_purchase' => $item->price_at_add,
                'quantity' => $item->quantity,
            ]);
            
            // Cập nhật tồn kho
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('quantity', $item->quantity);
            }
        }
    }
    
    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        do {
            // Format: ORD + YYYYMMDD + 4 số random
            $orderNumber = 'ORD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('tracking_number', $orderNumber)->exists());
        
        return $orderNumber;
    }
    
    /**
     * Validate stock internal
     */
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
    
    /**
     * Lấy giỏ hàng hiện tại
     */
    private function getCurrentCart()
    {
      
        if (auth()->check()) {
            return Cart::with('cartDetails.product')->where('user_id', auth()->id())->first();
        } else {
            $sessionId = session()->getId();
            return Cart::with('cartDetails.product')->where('session_id', $sessionId)->first();
        }
    }
    
    /**
     * Cập nhật tổng giỏ hàng
     */
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
    
    /**
     * Xóa giỏ hàng sau khi đặt hàng thành công
     */
    private function clearCart(Cart $cart)
    {
        $cart->cartDetails()->delete();

        $cart->delete();
    }
}