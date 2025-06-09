<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;




Route::get('/', [HomeController::class, 'Home'])->name('home');
Route::get('/home', [HomeController::class, 'Home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');







Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/shop/detail/{product}', [ProductController::class, 'detail'])->name('detail');







Route::middleware('guest')->group(function () {
  Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
  Route::post('/register', [AuthController::class, 'register']);

  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
});






Route::prefix('cart')->group(function () {
  Route::get('/', [CartController::class, 'index'])->name('cart');
  Route::post('/add', [CartController::class, 'add'])->name('cart.add');
  Route::patch('/update', [CartController::class, 'update'])->name('cart.update');
  Route::delete('/remove', [CartController::class, 'remove'])->name('cart.remove');
  Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
  Route::get('/data', [CartController::class, 'getCartData'])->name('cart.data');
  // Route::patch('/address', [CartController::class, 'updateAddress'])->name('cart.address.update');
  // Route::get('/address', [CartController::class, 'getAddress'])->name('cart.address.get');



  Route::get('/guest-info', [CartController::class, 'getGuestInfo'])->name('cart.guest-info.get');
  Route::patch('/guest-info', [CartController::class, 'updateGuestInfo'])->name('cart.guest-info.update');
  Route::post('/validate-stock', [CheckoutController::class, 'validateStock'])->name('cart.validate-stock');
});


Route::prefix('checkout')->group(function () {
  Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
  Route::get('/failed', [CheckoutController::class, 'failed'])->name('checkout.failed');
});


Route::prefix('order')->group(function () {
  Route::get('/success/{orderId}', [OrderController::class, 'success'])->name('order.success');
  Route::get('/details/{orderId}', [OrderController::class, 'details'])->name('order.details');
  Route::get('/track/{orderId}', [OrderController::class, 'track'])->name('order.track');
});





Route::middleware('auth')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/dashboard', function () {
    return view('account.dashboard');
  })->name('dashboard');
  Route::get('/user/profile', [UserController::class, 'showProfile'])->name('profile.show');
  Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('profile.update');
  Route::post('/user/password', [UserController::class, 'changePassword'])->name('profile.password');
});

