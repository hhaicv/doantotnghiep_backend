<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Models\Stage;
use App\Models\Stop;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    const PATH_VIEW = 'admin.routess.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stops = Stop::all(); // Lấy tất cả các điểm dừng
        $data = Route::with(['stages.startStop', 'stages.endStop'])->get()->map(function ($route) {
            // Gộp start_stop_id và end_stop_id vào một mảng duy nhất cho mỗi route
            $stopIds = $route->stages->flatMap(function ($stage) {
                return [$stage->start_stop_id, $stage->end_stop_id];
            })
                ->unique() // Loại bỏ các ID trùng lặp
                ->sort() // Sắp xếp theo thứ tự tăng dần
                ->values(); // Đặt lại các key để đảm bảo tuần tự

            // Gán mảng đã xử lý vào thuộc tính stages của route để truyền vào view
            $route->stages = $stopIds;

            return $route;
        });

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'stops'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stops = Stop::whereNotNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('stops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRouteRequest $request)
    {
        $data = $request->except('start_stop_id', 'end_stop_id', 'fare', 'stage_order');
        $model = Route::query()->create($data);

        if ($model) {
            // Lấy các thông tin điểm dừng từ yêu cầu
            $startStops = $request->input('start_stop_id');
            $endStops = $request->input('end_stop_id');
            $fares = $request->input('fare');
            $stageOrders = $request->input('stage_order');

            // Kiểm tra xem có thông tin chặng không
            if (is_array($startStops) && is_array($endStops) && is_array($fares)) {
                // Lưu vào bảng stage
                foreach ($startStops as $index => $fromStopId) {
                    $stageData = [
                        'route_id' => $model->id, // ID của tuyến đường vừa tạo
                        'start_stop_id' => $fromStopId,
                        'end_stop_id' => $endStops[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                        'fare' => $fares[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                    ];
                    Stage::create($stageData);
                }
            }
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('failes', 'Bạn không thêm thành công');
        }
    }

    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stops = Stop::query()->get();
        $data = Route::query()->findOrFail($id);
        $stages = $data->stages; // Lấy ra các chặng của tuyến đường
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'stops', 'stages'));
    }

    public function update(UpdateRouteRequest $request, string $id)
    {
        $data = Route::query()->findOrFail($id);
        $model = $request->all();

        $res = $data->update($model);

        if ($res) {
            // Cập nhật chặng
            $this->updateStages($request, $data);

            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Chuyến xe không sửa thành công');
        }
    }

    protected function updateStages(Request $request, Route $route)
    {
        // Xử lý các chặng đã có
        if ($request->has('start_stop_id') && $request->has('end_stop_id')) {
            $startStops = $request->input('start_stop_id');
            $endStops = $request->input('end_stop_id');
            $fares = $request->input('fare');


            // Cập nhật các chặng hiện có
            foreach ($route->stages as $index => $stage) {
                if (isset($startStops[$index]) && isset($endStops[$index])) {
                    $stage->start_stop_id = $startStops[$index];
                    $stage->end_stop_id = $endStops[$index];
                    $stage->fare = $fares[$index];

                    $stage->save(); // Lưu lại chặng đã cập nhật
                }
            }

            // Thêm các chặng mới
            for ($i = count($route->stages); $i < count($startStops); $i++) {
                if (!empty($startStops[$i]) && !empty($endStops[$i])) {
                    $route->stages()->create([
                        'start_stop_id' => $startStops[$i],
                        'end_stop_id' => $endStops[$i],
                        'fare' => $fares[$i],
                    ]);
                }
            }
        }

        // Xóa các chặng không còn trong form
        $existingStageIds = $route->stages->pluck('id')->toArray();
        $currentStageIds = array_filter(array_merge($request->input('stage_ids', []))); // Nhận các ID từ request

        // Xóa các chặng không có trong form
        foreach ($existingStageIds as $stageId) {
            if (!in_array($stageId, $currentStageIds)) {
                $route->stages()->find($stageId)->delete();
            }
        }
    }


    public function destroy(string $id)
    {
        $data = Route::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully');
    }

    public function statusRoute(Request $request, string $id)
    {
        // Tìm bản ghi theo ID
        $role = Route::findOrFail($id);
        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        // Lưu thay đổi vào cơ sở dữ liệu
        $role->save();
        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
