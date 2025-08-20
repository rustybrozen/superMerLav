<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

use App\Http\Controllers\Admin\SummaryController;



Route::middleware(['isAdmin'])->group(function () {


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
    Route::get('/tracking-order', [TrackingController::class, 'index'])->name('tracking');
    Route::post('/tracking-order', [TrackingController::class, 'check'])->name('tracking.check');
  });








  Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
      Route::post('/buy', [CartController::class, 'buy'])->name('cart.buy');
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
    Route::get('/details/{order}', [OrderController::class, 'details'])->name('order.details');
    Route::get('/track/{orderId}', [OrderController::class, 'track'])->name('order.track');
    Route::get('/', [OrderController::class, 'orders'])->name('order.all');
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

});

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

  Route::post('/logout', [AuthController::class, 'logout'])->name('logoutAdmin');
  
  Route::get('/dashboard', [SummaryController::class, 'index'])->name('dashboard');
  Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.show');



  Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
  Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
  Route::patch('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
  Route::patch('/products/{product}/toggle', [AdminProductController::class, 'toggleActive'])->name('products.toggle');
  Route::delete('/products/{product}/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');


  Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
  Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
  Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
  Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggleActive'])->name('categories.toggle');



  Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
  Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleDisabled'])->name('users.toggle');



  Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
  Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
  Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
  Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');


});






// Admin testing without an account
// Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
