<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
    //
    public function index()
    {

      $cart = $this->getOrCreateCart();
      $cartItems = $cart->cartDetails()->with('product')->get();
        return view('account.cart', compact('cart','cartItems'));
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

    // Determine if user is authenticated or use session ID
    if (Auth::check()) {
        $cart = Cart::where('user_id', Auth::id())->firstOrCreate([
            'user_id' => Auth::id()
        ]);
    } else {
        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    // Add product to cart
    $cart->addItem($productId, $quantity);

    return response()->json(['success' => true]);
}


}
