<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('employee.login')->with('error', 'Vui lòng đăng nhập trước khi truy cập!');
        }

        $user = Auth::user();

        // Kiểm tra quyền hạn của người dùng
        if ($user->type !== 'employee') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này!');
        }

        return $next($request);
    }
}
