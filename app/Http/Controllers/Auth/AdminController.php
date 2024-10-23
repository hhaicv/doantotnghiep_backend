<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('auth.admin_login'); // Tạo view cho đăng nhập admin
    }

    public function adminLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Kiểm tra nếu người dùng có vai trò admin
        if (Auth::user()->name_role === 'admin') { // 1 là ID của admin
            return redirect()->route('admin.dashboard'); 
        } else {
            Auth::logout(); // Đăng xuất nếu không phải admin
            return back()->withErrors([
                'email' => 'Bạn không có quyền truy cập vào trang này.',
            ]);
        }
    }

    // Đăng nhập không thành công
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ]);
}

    
}
