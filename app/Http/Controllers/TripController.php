<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;

class TripController extends Controller
{
    const PATH_VIEW = 'admin.trips.';

    public function index()
    {
        $data = Trip::with(['route', 'bus'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
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
        return redirect()->back()->with('success', 'Bạn thêm thành công');
    }



    public function edit(string $id)
    {
        $data = Trip::query()->with(['bus', 'route'])->findOrFail($id);
        $buses = Bus::query()->get();
        $routes = Route::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'buses', 'routes'));
    }


    public function update(UpdateTripRequest $request, string $id)
    {
        $data = Trip::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Chuyến xe không sửa thành công');
        }
    }
    public function destroy(string $id)
    {
        $trip = Trip::query()->findOrFail($id);
        $bus_id = $trip->bus_id; // Lưu lại ID của xe trước khi xóa chuyến đi
        $trip->delete();

        // Kiểm tra xem xe còn chuyến đi nào khác không
        $remainingTrips = Trip::where('bus_id', $bus_id)->count();
        if ($remainingTrips === 0) {
            // Nếu xe không còn chuyến đi nào, cập nhật lại trạng thái thành không hoạt động
            $bus = Bus::find($bus_id);
            if ($bus) {
                $bus->is_active = 0;
                $bus->save();
            }
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.banners.index')->with('success', 'Chuyến đi đã xóa thành công');
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
