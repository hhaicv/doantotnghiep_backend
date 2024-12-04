<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.driver_login');
    }

    public function driverLogin(Request $request)
    {
        // Validate yêu cầu đăng nhập
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Thử đăng nhập bằng guard 'driver'
        if (Auth::guard('driver')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('driver.dashboard'); // Chuyển hướng đến trang dashboard
        }

        // Đăng nhập không thành công
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function logout()
    {
        Auth::guard('driver')->logout(); // Đăng xuất
        return redirect()->route('driver.login')->with('success', 'Đăng xuất thành công!'); // Redirect về trang login
    }
}
