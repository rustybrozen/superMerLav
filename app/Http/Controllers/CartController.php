<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->cartDetails()->with('product')->get();
        return view('account.cart', compact('cart', 'cartItems'));
    }







    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::getCart(Auth::id());
        }
        return Cart::getCart(null, session()->getId());
    }









    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cart = $this->getOrCreateCart();
        $cart->addItem($productId, $quantity);
        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
            'cart_count' => $cart->total_items,
            'cart_total' => number_format($cart->total)
        ]);
    }



    public function buy(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    $cart = $this->getOrCreateCart();
    $cart->addItem($productId, $quantity);

    return redirect()->route('cart')
        ->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
}








    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = $this->getOrCreateCart();
        $cartDetail = $cart->cartDetails()->where('product_id', $productId)->first();
        if (!$cartDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không có trong giỏ hàng!'
            ], 404);
        }
        $cart->updateItemQuantity($productId, $quantity);
        $cart->refresh();
        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật số lượng!',
            'cart_count' => $cart->total_items,
            'quantity' => $cart->cartDetails()->where('product_id', $productId)->first()->quantity,
            'cart_total' => number_format($cart->total),
            'item_subtotal' => number_format($cartDetail->fresh()->subtotal)
        ]);
    }









    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        $productId = $request->input('product_id');
        $cart = $this->getOrCreateCart();
        $cartDetail = $cart->cartDetails()->where('product_id', $productId)->first();
        if (!$cartDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không có trong giỏ hàng!'
            ], 404);
        }
        $cart->removeItem($productId);
        $cart->refresh();
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
            'cart_count' => $cart->total_items,
            'cart_total' => number_format($cart->total)
        ]);
    }








    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->clear();
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng!'
        ]);
    }









    // Helper method to get cart data for AJAX responses
    public function getCartData()
    {
        $cart = $this->getOrCreateCart();
        return response()->json([
            'success' => true,
            'cart_count' => $cart->total_items,
            'cart_total' => number_format($cart->total),
            'items' => $cart->cartDetails()->with('product')->get()->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price_at_add,
                    'subtotal' => number_format($item->subtotal),
                    'product_name' => $item->product->name
                ];
            })
        ]);
    }




    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500'
        ]);

        $address = $request->input('address');

        if (Auth::check()) {
            $user = Auth::user();
            $user->update(['address' => $address]);
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật địa chỉ thành công!',
                'address' => $address,
                'user_authenticated' => true
            ]);
        } else {
            session(['guest_address' => $address]);
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu địa chỉ giao hàng!',
                'address' => $address,
                'user_authenticated' => false
            ]);
        }
    }








    public function getAddress()
    {
        if (Auth::check()) {
            $address = Auth::user()->address ?? '';
            return response()->json([
                'success' => true,
                'address' => $address,
                'user_authenticated' => true
            ]);
        } else {
            $address = session('guest_address', '');
            return response()->json([
                'success' => true,
                'address' => $address,
                'user_authenticated' => false
            ]);
        }
    }







    public function updateGuestInfo(Request $request)
    {


        $request->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'fullname' => 'required|string|max:50'
        ]);


        if (Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Phương thức này chỉ dành cho khác không sử dụng tài khoản!'
            ], 400);
        }
        session([
            'guest_address' => $request->address,
            'guest_phone' => $request->phone,
            'guest_email' => $request->email,
            'guest_fullname' => $request->fullname
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Đã lưu thông tin giao hàng!',
            'data' => [
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'fullname' => $request->fullname
            ]
        ]);
    }












    public function getGuestInfo()
    {

        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'user_authenticated' => true,
                'data' => [
                    'address' => Auth::user()->address ?? '',
                    'phone' => Auth::user()->phone ?? '',
                    'email' => Auth::user()->email ?? '',
                    'fullname' => Auth::user()->fullname ?? ''
                ]
            ]);
        }
        return response()->json([
            'success' => true,
            'user_authenticated' => false,
            'data' => [
                'address' => session('guest_address', ''),
                'phone' => session('guest_phone', ''),
                'email' => session('guest_email', ''),
                'fullname' => session('guest_fullname', '')
            ]
        ]);
    }

}