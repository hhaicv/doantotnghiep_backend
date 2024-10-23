<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập hoặc không có vai trò là admin (role_id = 1 là admin)
        if (!Auth::check() || Auth::user()->name_role != 'admin') {
            // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
            if (!Auth::check()) {
                return redirect()->route('admin.login');
            }

            // Nếu đã đăng nhập nhưng không phải admin, chuyển hướng về trang chủ kèm thông báo lỗi
            return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này!');
        }

        // Nếu là admin, tiếp tục truy cập trang
        return $next($request);
    }
}
