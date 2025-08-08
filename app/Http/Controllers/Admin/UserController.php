<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Simple search (optional)
        $q = trim((string) $request->get('q'));

        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('username', 'like', "%{$q}%")
                        ->orWhere('fullname', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.users', compact('users', 'q'));
    }

    public function toggleDisabled(User $user)
    {
        // Safety rails
        if (Auth::id() === $user->id) {
            return back()->with('error', "Bạn không thể vô hiệu quá tài khoản cá nhân.");
        }
        // Optional: block disabling admins
        if ($user->is_admin) {
            return back()->with('error', "Bạn không thể vô hiệu hóa tài khoản này.");
        }

        $user->is_disabled = ! $user->is_disabled;
        $user->save();

        return back()->with('ok', 'Thay đổi thành công');
    }
}