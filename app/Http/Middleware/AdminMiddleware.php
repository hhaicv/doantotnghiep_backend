<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập trước khi truy cập!');
    }

    $user = Auth::user();

    if (!$user->name_role || $user->name_role !== 'admin') {
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này!');
    }

    return $next($request);
}

}

