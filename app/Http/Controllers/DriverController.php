<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    const PATH_VIEW = 'admin.drivers.';
    const PATH_UPLOAD = 'drivers';

    public function index()
    {
        $data = Driver::query()->get();
        return view(self::PATH_VIEW .  __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW .  __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        $data = $request->except('profile_image');

        // Mã hóa mật khẩu
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Xử lý ảnh
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = Storage::put(self::PATH_UPLOAD, $request->file('profile_image'));
        }

        $model = Driver::create($data);

        if ($model) {
            return redirect()->back()->with('success', 'Tài xế được thêm thành công.');
        } else {
            return redirect()->back()->with('failes', 'Tài xế không được thêm thành công.');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Driver::findOrFail($id);
        return view(self::PATH_VIEW . 'show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Driver::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }


    public function update(UpdateDriverRequest $request, string $id)
    {
        $driver = Driver::findOrFail($id);

        $model = $request->except('profile_image');

        // Định dạng ngày sinh nếu cần
        if ($request->filled('date_of_birth')) {
            $model['date_of_birth'] = Carbon::createFromFormat('Y-m-d', $request->date_of_birth)->format('Y-m-d');
        }

        // Xử lý mật khẩu (nếu cần cập nhật)
        if ($request->filled('password')) {
            $model['password'] = Hash::make($request->password);
        }

        // Xử lý ảnh mới
        if ($request->hasFile('profile_image')) {
            $model['profile_image'] = Storage::put(self::PATH_UPLOAD, $request->file('profile_image'));

            // Xóa ảnh cũ nếu tồn tại
            if ($driver->profile_image && Storage::exists($driver->profile_image)) {
                Storage::delete($driver->profile_image);
            }
        }

        $res = $driver->update($model);

        if ($res) {
            return redirect()->back()->with('success', 'Tài xế được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Tài xế không sửa thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Driver::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.drivers.index')->with('success', 'drivers deleted successfully');
    }

    public function statusDriver(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $role = Driver::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
