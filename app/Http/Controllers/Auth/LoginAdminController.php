<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginAdminController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request)
    {
        // Validate yêu cầu đăng nhập
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Thử đăng nhập bằng guard 'admin'
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();

            // Kiểm tra xem người dùng có phải là admin không
            if ($admin->name_role === 'admin') {

                return redirect()->route('admin.dashboard');
            } else {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Bạn không có quyền truy cập.',
                ]);
            }
        }

        // Đăng nhập không thành công
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }
    public function logout()
    {
        Auth::guard('admin')->logout(); // Đăng xuất admin
        return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công!'); // Redirect về trang login
    }
}
