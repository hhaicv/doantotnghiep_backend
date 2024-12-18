<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\TicketBooking;
use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Route;
use Illuminate\Http\Request;

class TripController extends Controller
{
    const PATH_VIEW = 'admin.trips.';

    public function index()
    {
        $data = Trip::with(['route', 'bus', 'bus.driver'])->get();
        foreach ($data as $trip) {
            $trip->has_related_data = $this->hasRelatedData($trip->id);
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }
    private function hasRelatedData($tripId)
    {
        $hasRelatedData = false;

        // Kiểm tra bảng vé (Ticket)
        if (TicketBooking::where('trip_id', $tripId)->exists()) {
            $hasRelatedData = true;
        }

        // Kiểm tra bảng chuyến (Trip)
        if (Trip::where('bus_id', $tripId)->exists()) {
            $hasRelatedData = true;
        }
        if (Trip::where('route_id', $tripId)->exists()) {
            $hasRelatedData = true;
        }

        return $hasRelatedData;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $buses = Bus::query()->where('is_active', false)->get();
        $routes = Route::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('buses', 'routes'));
    }

    public function getRouteCycle($route_id)
    {
        $route = Route::find($route_id);
        return $route ? $route->cycle : 60; // Mặc định là 60 nếu không tìm thấy
    }

    public function store(StoreTripRequest $request)
    {
        // Lấy chu kỳ của tuyến đường
        $interval = $this->getRouteCycle($request->route_id);

        // Chuyển đổi start_time và end_time sang timestamp trong cùng ngày
        $start_timestamp = strtotime('today ' . $request->start_time);
        $end_timestamp = strtotime('today ' . $request->end_time);

        // Lấy tất cả các xe không hoạt động
        $buses = Bus::where('is_active', 0)->get();
        $bus_count = $buses->count(); // Đếm số lượng xe không hoạt động
        $bus_index = 0; // Khởi tạo chỉ số xe

        // Tạo chuyến đi cho mỗi xe không hoạt động
        for ($current_time = $start_timestamp; $current_time <= $end_timestamp; $current_time += $interval * 60) {
            // Kiểm tra nếu có xe không hoạt động để sử dụng
            if ($bus_count > 0 && $bus_index < $bus_count) {
                $bus = $buses[$bus_index]; // Lấy xe không hoạt động theo chỉ số

                // Kiểm tra xem chuyến đi đã tồn tại chưa
                $existing_trip = Trip::where('route_id', $request->route_id)
                    ->where('bus_id', $bus->id)
                    ->where('time_start', date('H:i', $current_time))
                    ->first();

                // Nếu chuyến đi chưa tồn tại thì thêm chuyến mới
                if (!$existing_trip) {
                    Trip::create([
                        'route_id' => $request->route_id,
                        'bus_id' => $bus->id, // Đảm bảo bus_id được cung cấp
                        'time_start' => date('H:i', $current_time),
                    ]);

                    // Đánh dấu xe là hoạt động
                    $bus->is_active = true;
                    $bus->save(); // Lưu thay đổi vào cơ sở dữ liệu

                    $bus_index++;
                }
            } else {
                break;
            }
        }
        return redirect()->back()->with('success', 'Thêm chuyến xe thành công');
    }



    public function edit(string $id)
    {
        $data = Trip::query()->with(['bus', 'route', 'bus.driver'])->findOrFail($id);

        $buses = Bus::query()
            ->where('is_active', false)
            ->orWhere('id', $data->bus_id) // Đảm bảo tài xế hiện tại có mặt trong danh sách
            ->get();

        $drivers = Driver::query()
            ->where('is_active', false)
            ->orWhere('id', $data->bus->driver_id) // Đảm bảo tài xế hiện tại có mặt trong danh sách
            ->get();

        $routes = Route::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'buses', 'routes', 'drivers'));
    }


    public function update(UpdateTripRequest $request, string $id)
    {


        $data = Trip::query()->findOrFail($id);
        $model = $request->all();

        // Lưu lại thông tin ban đầu
        $oldDriverId = $data->bus->driver_id ?? null;
        $oldBusId = $data->bus_id;

        // Cập nhật thông tin chuyến xe
        $res = $data->update($model);

        // Xử lý trạng thái bus
        if ($oldBusId && $oldBusId != $data->bus_id) {
            $oldBus = Bus::find($oldBusId);
            if ($oldBus) {
                $oldBus->is_active = false;
                $oldBus->save();
            }
        }
        if ($data->bus_id) {
            $newBus = Bus::find($data->bus_id);
            if ($newBus) {
                $newBus->is_active = true;
                $newBus->save();
            }
        }

        // Cập nhật tài xế nếu `driver_id` được cung cấp
        if ($request->has('driver_id')) {
            $newDriverId = $request->input('driver_id');
            $bus = $data->bus;
            if ($bus) {
                $bus->driver_id = $newDriverId;
                $bus->save();

                // Xử lý tài xế cũ
                if ($oldDriverId && $oldDriverId != $newDriverId) {
                    $oldDriver = Driver::find($oldDriverId);
                    if ($oldDriver) {
                        $oldDriver->is_active = false;
                        $oldDriver->save();
                    }
                }

                // Kích hoạt tài xế mới
                $newDriver = Driver::find($newDriverId);
                if ($newDriver) {
                    $newDriver->is_active = true;
                    $newDriver->save();
                }
            }
        }

        // Trả về kết quả
        if ($res) {
            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('failes', 'Chuyến xe không sửa thành công');
        }
    }
    public function destroy(string $id)
    {
        // Tìm chuyến đi
        $trip = Trip::query()->findOrFail($id);

        // Kiểm tra nếu có dữ liệu liên quan
        if ($this->hasRelatedData($id)) {
            return redirect()->route('admin.trips.index')->with('error', 'Chuyến đi có dữ liệu liên quan, không thể xóa.');
        }

        $bus_id = $trip->bus_id; // Lưu lại ID của xe trước khi xóa chuyến đi
        $trip->delete();

        // Kiểm tra xem xe còn chuyến đi nào khác không
        $remainingTrips = Trip::where('bus_id', $bus_id)->count();
        if ($remainingTrips === 0) {
            // Nếu xe không còn chuyến đi nào, cập nhật lại trạng thái thành không hoạt động
            $bus = Bus::find($bus_id);
            if ($bus) {
                $bus->is_active = false;
                $bus->save();
            }
        }

        // Kiểm tra nếu là yêu cầu AJAX
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Chuyển hướng về danh sách trips với thông báo thành công
        return redirect()->route('admin.trips.index')->with('success', 'Chuyến đi đã xóa thành công');
    }

    public function statusTrip(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $role = Trip::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
