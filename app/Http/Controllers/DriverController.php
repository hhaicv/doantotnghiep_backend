<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Trip;
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
        foreach ($data as $driver) {
            $driver->has_related_data = $this->hasRelatedData($driver->id);
        }
        return view(self::PATH_VIEW . 'index', compact('data'));
    }
    private function hasRelatedData($driverId)
    {
        $hasRelatedData = false;

        // Kiểm tra bảng Bus (dựa vào cột driver_id trực tiếp)
        if (Bus::where('driver_id', $driverId)->exists()) {
            $hasRelatedData = true;
        }

        return $hasRelatedData;
    }

    public function create()
    {
        return view(self::PATH_VIEW . 'create');
    }

    public function store(StoreDriverRequest $request)
    {
        $data = $request->except('profile_image', 'password');


        $data['password'] = bcrypt($request->password);

        // Xử lý ảnh đại diện (profile_image)
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = Storage::put(self::PATH_UPLOAD, $request->file('profile_image'));
        }

        $driver = Driver::create($data);

        if ($driver) {
            return redirect()->back()->with('success', 'Tài xế được thêm thành công.');
        } else {
            return redirect()->back()->with('fail', 'Tài xế không được thêm thành công.');
        }
    }

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

        $data = $request->except('profile_image', 'password');

        // Định dạng lại ngày sinh nếu cần
        if ($request->filled('date_of_birth')) {
            $data['date_of_birth'] = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        }

        // Cập nhật mật khẩu nếu có
        $data['password'] = bcrypt($request->password);


        // Xử lý ảnh đại diện
        if ($request->hasFile('profile_image')) {
            $oldImage = $driver->profile_image;
            $data['profile_image'] = Storage::put(self::PATH_UPLOAD, $request->file('profile_image'));

            // Xóa ảnh cũ nếu tồn tại
            if ($oldImage && Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }
        }

        $updated = $driver->update($data);

        if ($updated) {
            return redirect()->back()->with('success', 'Tài xế được sửa thành công.');
        } else {
            return redirect()->back()->with('danger', 'Tài xế không sửa thành công.');
        }
    }

    public function destroy(string $id)
    {
        $driver = Driver::query()->findOrFail($id);

        if ($driver->bus_id) {
            $bus = Bus::find($driver->bus_id);
            if ($bus) {
                $bus->is_active = false; // Đặt trạng thái tài xế là không hoạt động
                $bus->save(); // Lưu thay đổi
            }
        }

        // Xóa ảnh đại diện nếu có
        if ($driver->profile_image && Storage::exists($driver->profile_image)) {
            Storage::delete($driver->profile_image);
        }

        $driver->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
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
