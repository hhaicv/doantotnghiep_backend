<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
    const PATH_VIEW = 'admin.buses.';
    const PATH_UPLOAD = 'buses';

    public function index()
    {
        $data = Bus::with('driver')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function create()
    {
        $drivers = Driver::query()->where('is_active', false)->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('drivers'));
    }

    public function store(StoreBusRequest $request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $data['status'] = 'active';
        $res = Bus::query()->create($data);

        if ($res->driver_id) {
            $driver = Driver::find($res->driver_id);
            if ($driver) {
                $driver->is_active = true;  // Đặt trạng thái tài xế là 'true'
                $driver->save();  // Lưu thay đổi trạng thái tài xế
            }
        }
        if ($res) {
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }

    public function show(Bus $Buses)
    {
        //
    }

    public function edit(string $id)
    {
        // Lấy thông tin xe bus
        $model = Bus::query()->findOrFail($id);

        // Lấy danh sách tài xế có is_active = false hoặc là tài xế hiện tại của xe
        $drivers = Driver::query()
            ->where('is_active', false)
            ->orWhere('id', $model->driver_id) // Đảm bảo tài xế hiện tại có mặt trong danh sách
            ->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('model', 'drivers'));
    }

    public function update(UpdateBusRequest $request, string $id)
    {
        // Lấy thông tin xe bus từ cơ sở dữ liệu
        $bus = Bus::query()->findOrFail($id);

        // Chuẩn bị dữ liệu từ request (trừ 'image')
        $data = $request->except('image');

        // Kiểm tra và xử lý ảnh
        if ($request->hasFile('image')) {
            // Lưu ảnh mới
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            // Xóa ảnh cũ nếu tồn tại
            if ($bus->image && Storage::exists($bus->image)) {
                Storage::delete($bus->image);
            }
        }

        // Cập nhật dữ liệu bus
        $oldDriverId = $bus->driver_id; // Lưu lại driver_id cũ
        $bus->update($data);

        // Xử lý trạng thái tài xế
        // Đặt is_active = false cho tài xế cũ (nếu có)
        if ($oldDriverId && $oldDriverId != $bus->driver_id) {
            $oldDriver = Driver::find($oldDriverId);
            if ($oldDriver) {
                $oldDriver->is_active = false;
                $oldDriver->save();
            }
        }

        // Đặt is_active = true cho tài xế mới (nếu có)
        if ($bus->driver_id) {
            $newDriver = Driver::find($bus->driver_id);
            if ($newDriver) {
                $newDriver->is_active = true;
                $newDriver->save();
            }
        }

        // Xử lý kết quả trả về
        return redirect()->back()->with('success', 'Bus được sửa thành công');
    }


    public function destroy(string $id)
    {
        // Tìm bản ghi Bus
        $bus = Bus::query()->findOrFail($id);

        // Xử lý tài xế liên quan
        if ($bus->driver_id) {
            $driver = Driver::find($bus->driver_id);
            if ($driver) {
                $driver->is_active = false; // Đặt trạng thái tài xế là không hoạt động
                $driver->save(); // Lưu thay đổi
            }
        }
        $bus->delete();

        // Kiểm tra nếu là yêu cầu AJAX
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Chuyển hướng về danh sách buses với thông báo thành công
        return redirect()->route('admin.buses.index')->with('success', 'Bus deleted successfully');
    }


    public function statusBuses(Request $request, string $id)
    {
        // Tìm bản ghi theo ID
        $role = Bus::findOrFail($id);
        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        // Lưu thay đổi vào cơ sở dữ liệu
        $role->save();
        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
