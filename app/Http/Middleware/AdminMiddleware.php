<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập bằng guard 'admin'
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập trước khi truy cập!');
        }

        $admin = Auth::guard('admin')->user();

        // Kiểm tra quyền admin
        if (!$admin->name_role || $admin->name_role !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này!');
        }

        return $next($request);
    }
}
