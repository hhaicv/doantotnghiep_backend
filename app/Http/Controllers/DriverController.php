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
        $data = Driver::all();
        return view(self::PATH_VIEW . 'index', compact('data'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . 'create');
    }

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
            return redirect()->back()->with('fail', 'Tài xế không được thêm thành công.');
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

    public function edit(string $id)
    {
        $data = Driver::findOrFail($id);
        return view(self::PATH_VIEW . 'edit', compact('data'));
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
            return redirect()->back()->with('danger', 'Tài xế không sửa thành công.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);

        // Xóa ảnh đại diện nếu có
        if ($driver->profile_image && Storage::exists($driver->profile_image)) {
            Storage::delete($driver->profile_image);
        }

        $deleted = $driver->delete();

        if (request()->ajax()) {
            return response()->json(['success' => $deleted]);
        }

        return redirect()->route('admin.drivers.index')->with('success', 'Tài xế đã được xóa thành công.');
    }

    public function statusDriver(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->is_active = $request->input('is_active');
        $driver->save();

        return response()->json(['success' => true]);
    }
}
