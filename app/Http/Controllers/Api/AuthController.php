<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        $token = $user->createToken(env('SANCTUM_NAME'))->plainTextToken;

        return response()->json([
            'status' => 'Thành công',
            'message' => 'User đăng kí thành công.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ],);
        }

        $token = $user->createToken(env('SANCTUM_NAME'))->plainTextToken;

        return response()->json([
            'status' => 'Thành Công',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        // Kiểm tra xem type có phải là 'all' không
        if ($request->input('type') === 'all') {
            // Xóa tất cả token của người dùng
            $request->user()->tokens()->delete();
    
            return response()->json([
                'status' => 'Thành công',
                'message' => 'Đã đăng xuất khỏi tất cả token.',
            ]);
        } else {
            // Lấy token hiện tại từ user
            $currentToken = $request->user()->currentAccessToken();
    
            // Kiểm tra xem token có tồn tại không
            if ($currentToken) {
                // Xóa token hiện tại
                $currentToken->delete();
    
                return response()->json([
                    'status' => 'Thành công',
                    'message' => 'Đăng xuất thành công.',
                ]);
            }
    
            return response()->json([
                'status' => 'Lỗi',
                'message' => 'Không tìm thấy token.',
            ], 404);
        }
    }
    
    
}
