<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    const PATH_VIEW = 'admin.users.';
    
    public function index()
    {
        $data = User::with('role')->get(); 
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }



    public function edit($id)
    {
        $model = User::with('role')->findOrFail($id); 
        $roles = Role::all();  
        return view(self::PATH_VIEW . __FUNCTION__, compact('model', 'roles'));
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

    $res = $user->update($model);

    if ($res) {
        return redirect()->back()->with('success', 'Thông tin người dùng được sửa thành công.');
    } else {
        return redirect()->back()->with('danger', 'Không thể sửa thông tin người dùng.');
    }
}


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa.');
    }

    // Cập nhật trạng thái của người dùng (kích hoạt / vô hiệu hóa)
    public function statusUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_active = $request->input('is_active');
        $user->save(); 

        return response()->json(['success' => true]);
    }
}
