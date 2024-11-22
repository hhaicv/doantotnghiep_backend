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
        // Validate yêu cầu đầu vào
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tìm kiếm người dùng theo email
        $user = User::where('email', $request->email)->first();

        // Kiểm tra nếu người dùng không tồn tại hoặc mật khẩu không chính xác
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }

        // Tạo token cho người dùng
        $token = $user->createToken(env('SANCTUM_NAME', 'DefaultTokenName'))->plainTextToken;

        // Trả về thông tin đăng nhập thành công mà không bao gồm mật khẩu hoặc dữ liệu nhạy cảm
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
                // Có thể trả về các trường khác mà bạn muốn, nhưng không phải mật khẩu
            ]
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
    public function updateAccount(Request $request)
    {
        $user = $request->user(); // Lấy người dùng hiện tại

        // Validate các thông tin đầu vào
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|max:10',
            'address' => 'sometimes|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Nếu người dùng muốn thay đổi mật khẩu, mã hóa mật khẩu mới
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        try {
            // Cập nhật thông tin người dùng
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
}
