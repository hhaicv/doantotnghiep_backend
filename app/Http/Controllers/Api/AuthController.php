<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Mã hóa mật khẩu trước khi lưu vào database
        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::create($data);
            $token = $user->createToken(env('SANCTUM_NAME', 'DefaultTokenName'))->plainTextToken;

            return response()->json([
                'status' => 'Thành công',
                'message' => 'Đăng ký tài khoản thành công.',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'Lỗi',
                'message' => 'Đăng ký thất bại. Vui lòng thử lại sau.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
                'email' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }

        $token = $user->createToken(env('SANCTUM_NAME', 'DefaultTokenName'))->plainTextToken;

        return response()->json([
            'status' => 'Thành công',
            'message' => 'Đăng nhập thành công.',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->input('type') === 'all') {
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => 'Thành công',
                'message' => 'Đã đăng xuất khỏi tất cả thiết bị.',
            ]);
        } else {
            $currentToken = $request->user()->currentAccessToken();

            if ($currentToken) {
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
