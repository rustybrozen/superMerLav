<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register-form');
    }

    public function register(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'username' => 'required|string|max:15|unique:users',
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'nullable|string|max:50|unique:users',
            'address' => 'nullable|string|max:100',
            'password' => 'required|string|min:6',
        ]);


        $user = User::create([
            'username' => $validated['username'],
            'fullname' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập');
    }

    public function showLoginForm()
    {
        return view('auth.login-form');
    }

    public function login(Request $request)
    {
        $sessionId = Session::getId();
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);


        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $loginCredentials = [
            $loginField => $credentials['login'],
            'password' => $credentials['password']
        ];


        if (!Auth::attempt($loginCredentials)) {
            throw ValidationException::withMessages([
                'login' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }

        $user = Auth::user();

        if ($user->is_disabled) {
            Auth::logout();
            throw ValidationException::withMessages([
                'login' => 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên.',
            ]);
        }

        if (Auth::attempt($loginCredentials)) {
            $guestCart = Cart::where('session_id', $sessionId)->with('cartDetails')->first();
            $request->session()->regenerate();
            if ($guestCart && $guestCart->cartDetails->isNotEmpty()) {
                $userCart = Cart::where('user_id', $user->id)->firstOrCreate(['user_id' => $user->id]);

                foreach ($guestCart->cartDetails as $detail) {
                    $userCart->addItem($detail->product_id, $detail->quantity);
                }


                $guestCart->clear();
            }
            // Redirect based on user role
            // if (Auth::user()->is_admin) {
            //     return redirect()->route('admin.dashboard')->with('success', 'Chào mừng Admin! 👋');
            // }




            return redirect()->route('dashboard')->with('success', 'Đăng nhập thành công!');
        }

        throw ValidationException::withMessages([
            'login' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công! Hẹn gặp lại!');
    }
}