<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\StoreAdminRequest;

class AdminController extends Controller
{
    const PATH_VIEW = 'admin.admins.';

    public function index()
    {
        $admins = Admin::all();
        return view(self::PATH_VIEW . 'index', compact('admins'));
    }


    public function edit($id)
    {
        // Tìm người dùng theo ID
        $model = Admin::findOrFail($id);
        return view(self::PATH_VIEW . 'edit', compact('model')); // Không cần role nữa
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

        $res = $admins->update($model);

        if ($res) {
            return redirect()->back()->with('success', 'Thông tin người dùng được sửa thành công.');
        } else {
            return redirect()->back()->with('danger', 'Không thể sửa thông tin người dùng.');
        }
    }

    public function destroy($id)
    {
        // Tìm người dùng theo ID và xóa
        $user = Admin::findOrFail($id);
        $user->delete();

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
        $user = Admin::findOrFail($id);
        $user->is_active = $request->input('is_active');
        $user->save();

        return response()->json(['success' => true]);
    }

}
