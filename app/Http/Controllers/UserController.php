<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    const PATH_VIEW = 'admin.users.';

    public function index()
    {
        $data = User::all();
        return view(self::PATH_VIEW . 'index', compact('data'));
    }

    // Phương thức tạo view thêm mới tài khoản user
    public function create()
    {

        // Trả về view thêm mới tài khoản user
        return view(self::PATH_VIEW . 'create');
    }

    // Phương thức lưu tài khoản user vào database
    public function store(StoreUserRequest $request)  // Sử dụng StoreUserRequest để validate dữ liệu
    {
        // Lấy dữ liệu từ form
        $model = $request->all();

        // Mã hóa mật khẩu
        $model['password'] = bcrypt($request->password);

        // Cài đặt mặc định cho type (ví dụ là 'user') nếu chưa có
        if (!isset($model['type'])) {
            $model['type'] = User::TYPE_USER;  // Gán loại người dùng là 'user'
        }

        // Cài đặt mặc định cho is_active nếu chưa có
        if (!isset($model['is_active'])) {
            $model['is_active'] = true;  // Mặc định kích hoạt tài khoản
        }

        // Tạo mới tài khoản user
        $user = User::create($model);  // Thay Admin thành User

        if ($user) {
            return redirect()->route('admin.users.index')->with('success', 'Tài khoản người dùng đã được tạo thành công.');
        } else {
            return redirect()->route('admin.users.index')->with('failes', 'Không thể tạo tài khoản người dùng.');
        }
    }

    public function edit($id)
    {
        // Tìm người dùng theo ID
        $model = User::findOrFail($id);
        return view(self::PATH_VIEW . 'edit', compact('model')); // Không cần role nữa
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $model = $request->all();

        // Nếu mật khẩu được nhập thì mã hóa mật khẩu mới
        if ($request->filled('password')) {
            $model['password'] = bcrypt($request->password);
        } else {
            // Bỏ qua trường password nếu không có thay đổi
            unset($model['password']);
        }

        // Cập nhật loại người dùng
        if ($request->has('name_role')) {
            $model['type'] = $request->input('name_role');
        }

        $res = $user->update($model);

        if ($res) {
            return redirect()->back()->with('success', 'Thông tin người dùng được sửa thành công.');
        } else {
            return redirect()->back()->with('danger', 'Không thể sửa thông tin người dùng.');
        }
    }

    public function destroy($id)
    {
        // Tìm người dùng theo ID và xóa
        $user = User::findOrFail($id);
        $user->delete();

        // Xử lý yêu cầu Ajax
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa.');
    }

    // Cập nhật trạng thái của người dùng (kích hoạt / vô hiệu hóa)
    public function statusUser(Request $request, $id)
    {
        // Tìm người dùng theo ID và cập nhật trạng thái
        $user = User::findOrFail($id);
        $user->is_active = $request->input('is_active');
        $user->save();

        return response()->json(['success' => true]);
    }

    // Hiển thị danh sách nhân viên
    public function employeeIndex()
    {
        $employees = User::where('type', 'employee')->get(); // Lấy danh sách nhân viên
        return view(self::PATH_VIEW . 'employees', compact('employees'));
    }

    // Hiển thị danh sách người dùng
    public function userIndex()
    {
        $users = User::where('type', 'user')->get(); // Lấy danh sách người dùng
        return view(self::PATH_VIEW . 'users', compact('users'));
    }
}
