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
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store(self::PATH_UPLOAD, 'public');
        }
        $admin = Admin::create($data);
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

        return view(self::PATH_VIEW . 'edit', compact('model', 'roles'));
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $admins = Admin::findOrFail($id);
        $model = $request->all();

        if ($request->filled('password')) {
            $model['password'] = bcrypt($request->password);
        } else {
            unset($model['password']);
        }
        if ($request->has('name_role')) {
            $model['type'] = $request->input('name_role');
        }
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
        $admins = Admin::findOrFail($id);
        $admins->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Người dùng đã được xóa.');
    }


    public function statusAdmin(Request $request, $id)
    {
        $admins = Admin::findOrFail($id);
        $admins->is_active = $request->input('is_active');
        $admins->save();

        return response()->json(['success' => true]);
    }
}
