<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class AdminProfileController extends Controller
{
 
    public function index(Request $request){
        return view('admin.profile', ['user' => $request->user()]);
    }
 

   public function updateProfile(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'fullname' => 'nullable|string|max:50',
            'phone' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:50', Rule::unique('users')->ignore($user->id)],
            'address' => 'nullable|string|max:100',
        ]);

        $user->update($validated);
        return redirect()->route('dashboard')->with('message', 'Cập nhật thông tin thành công!');
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('dashboard')->with('message', 'Thay đổi mật khẩu thành công!');
    }
}
