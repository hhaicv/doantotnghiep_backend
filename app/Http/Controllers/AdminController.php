<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\StoreAdminRequest;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    const PATH_VIEW = 'admin.admins.';
    const PATH_UPLOAD = 'admins';

    public function index()
    {

        $admins = Admin::all();
        return view(self::PATH_VIEW . 'index', compact('admins'));
    }
    public function create()
    {
        $roles = Role::all();

        // Trả về view thêm mới tài khoản
        return view(self::PATH_VIEW . 'create', compact('roles'));
    }

    public function store(StoreAdminRequest $request)
{
    // Lấy dữ liệu từ form
    $data = $request->all();

    // Mã hóa mật khẩu
    $data['password'] = bcrypt($request->password);

    // Xử lý upload ảnh
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store(self::PATH_UPLOAD, 'public');
    }

    // Tạo mới tài khoản quản trị
    $admin = Admin::create($data);

    // Kiểm tra kết quả và phản hồi
    if ($admin) {
        return redirect()->route('admin.admins.index')->with('success', 'Tài khoản quản trị đã được tạo thành công.');
    } else {
        return redirect()->route('admin.admins.index')->with('failes', 'Không thể tạo tài khoản quản trị.');
    }
}



    public function edit($id)
    {
        // Tìm người dùng theo ID
        $model = Admin::findOrFail($id);
        $roles = Role::all();

        return view(self::PATH_VIEW . 'edit', compact('model', 'roles')); // Không cần role nữa
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $admins = Admin::findOrFail($id);
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

        // Xử lý ảnh
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $image = $admins->image;
        $res = $admins->update($data);

        if ($request->hasFile('image') && $image && Storage::exists($image)) {
            Storage::delete($image);
        }

        if ($res) {
            return redirect()->back()->with('success', 'Thông tin người dùng được sửa thành công.');
        } else {
            return redirect()->back()->with('failes', 'Không thể sửa thông tin người dùng.');
        }
    }



    public function destroy($id)
    {
        // Tìm người dùng theo ID và xóa

        $admins = Admin::findOrFail($id);
        $admins->delete();

        // Xử lý yêu cầu Ajax
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Người dùng đã được xóa.');
    }

    // Cập nhật trạng thái của người dùng (kích hoạt / vô hiệu hóa)
    public function statusAdmin(Request $request, $id)
    {
        // Tìm người dùng theo ID và cập nhật trạng thái

        $admins = Admin::findOrFail($id);
        $admins->is_active = $request->input('is_active');
        $admins->save();

        return response()->json(['success' => true]);
    }
}
