<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    const PATH_VIEW = 'admin.roles.';

    public function index()
    {
        $data = Role::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->all();
        $res = Role::create($data);
        if ($res) {
            return redirect()->back()->with('success', 'thêm thành công');
        } else {
            return redirect()->back()->with('success', 'thêm không thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Role::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $data = Role::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Phân quyền được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Phân quyền không sửa thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Role::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Roles deleted successfully');
    }

    public function statusRole(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $role = Role::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
