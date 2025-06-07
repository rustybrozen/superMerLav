<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;




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







Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');






Route::middleware('auth')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/dashboard', function () {
    return view('account.dashboard');
  })->name('dashboard');
  Route::get('/user/profile', [UserController::class, 'showProfile'])->name('profile.show');
  Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('profile.update');
  Route::post('/user/password', [UserController::class, 'changePassword'])->name('profile.password');
});

