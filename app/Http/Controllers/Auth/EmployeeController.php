<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class EmployeeController extends Controller
{
    public function showEmployeeLoginForm()
    {
        return view('auth.employee_login'); 
    }

    public function employeeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /**
             * @var User $user
             */
            $user = Auth::user();
    
            if ($user->isEmployee()) {
                return redirect()->route('employee.dashboard');
            } else {
                Log::info('User details: ', (array)$user);
                Auth::logout();
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
    

}
