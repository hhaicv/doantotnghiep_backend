<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Mail\OtpMail;
use Exception;

class AuthController extends Controller
{
    // Đăng ký người dùng
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

    // Đăng nhập người dùng
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
                'password' =>['Mật khẩu không chính xác']
            ]);
        }

        $token = $user->createToken(env('SANCTUM_NAME', 'DefaultTokenName'))->plainTextToken;

        return response()->json([
            'status' => 'Thành công',
            'message' => 'Đăng nhập thành công.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'phone' => $user->phone,
            ]
        ]);
    }

    // Đăng xuất người dùng
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

    // Cập nhật thông tin tài khoản
    public function updateAccount(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|max:10',
            'address' => 'sometimes|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        try {
            $user->update($validatedData);

            return response()->json([
                'status' => 'Thành công',
                'message' => 'Cập nhật tài khoản thành công.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Lỗi',
                'message' => 'Cập nhật tài khoản thất bại. Vui lòng thử lại sau.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Gửi mã OTP để thay đổi mật khẩu
    public function requestPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $otp = Str::random(6);  // Tạo mã OTP ngẫu nhiên

        // Lưu OTP và thời gian hết hạn (5 phút)
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Gửi OTP qua email
        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json([
            'status' => 'Thành công',
            'message' => 'Mã OTP đã được gửi vào email của bạn.',
        ], 200);
    }

    // Cập nhật mật khẩu sau khi xác thực OTP
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',  // Kiểm tra mã OTP
            'password' => 'required|string|min:8|confirmed',  // Kiểm tra mật khẩu mới
        ]);

        $user = $request->user();

        $user = User::where('email', $request->email)->first(); // Hoặc dùng 'user_id'
        if (!$user) {
            return response()->json(['status' => 'Lỗi', 'message' => 'Người dùng không tồn tại.'], 404);
        }

        // Kiểm tra OTP và thời gian hết hạn (Sử dụng optional để tránh lỗi nếu các thuộc tính là null)
        if (optional($user)->otp !== $request->otp || now()->gt(optional($user)->otp_expires_at)) {
            return response()->json([
                'status' => 'Lỗi',
                'message' => 'Mã OTP không hợp lệ hoặc đã hết hạn.',
            ], 400);
        }

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->password);
        $user->otp = null;  // Xóa OTP sau khi xác thực
        $user->otp_expires_at = null;  // Xóa thời gian hết hạn OTP
        $user->save();

        return response()->json([
            'status' => 'Thành công',
            'message' => 'Mật khẩu đã được thay đổi thành công.',
        ], 200);
    }
}

//"email": "anhtrieu147@gmail.com",
//  "otp": "tUtf8L",
//  "password": "12345678",
//  "password_confirmation": "12345678"
