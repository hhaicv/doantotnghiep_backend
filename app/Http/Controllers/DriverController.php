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
        // Lấy tất cả dữ liệu từ request ngoại trừ profile_image
        $data = $request->except('profile_image');

        $model = new Driver($data);
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = Storage::put(self::PATH_UPLOAD, $request->file('profile_image'));
        }
        $model = Driver::query()->create($data);
        // Lưu đối tượng driver vào cơ sở dữ liệu
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
        $data = Driver::query()->findOrFail($id);

        // Định dạng lại ngày sinh trước khi cập nhật (nếu cần)
        if ($request->filled('date_of_birth')) {
            $data['date_of_birth'] = Carbon::createFromFormat('Y-m-d', $request->date_of_birth)->format('Y-m-d');
        }

        $model = $request->except('profile_image');
        if ($request->hasFile('profile_image')) {
            $model['profile_image'] = Storage::put(self::PATH_UPLOAD, $request->file('profile_image'));
        }

        $image = $data->profile_image;

        $res = $data->update($model);

        if ($request->hasFile('profile_image') && $image && Storage::exists($image)) {
            Storage::delete($image);
        }

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
