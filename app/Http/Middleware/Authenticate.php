<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Nếu URL yêu cầu có chứa 'admin', chuyển hướng đến trang đăng nhập admin
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        // Nếu không, chuyển hướng đến trang đăng nhập người dùng thông thường
        return $request->expectsJson() ? null : route('login');
    }
}
