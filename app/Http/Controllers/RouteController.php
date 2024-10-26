<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
<<<<<<< HEAD
=======
use App\Models\Stage;
use App\Models\Stop;
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
use Illuminate\Http\Request;

class RouteController extends Controller
{
    const PATH_VIEW = 'admin.routess.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Route::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
<<<<<<< HEAD
        return view(self::PATH_VIEW . __FUNCTION__);
=======
        $stops = Stop::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('stops'));
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRouteRequest $request)
    {
<<<<<<< HEAD
        $data = $request->all();
        $model = Route::query()->create($data);
        if ($model) {
=======
        $data = $request->except('start_stop_id', 'end_stop_id', 'fare', 'stage_order');
        $model = Route::query()->create($data);

        if ($model) {
            // Lấy các thông tin điểm dừng từ yêu cầu
            $startStops = $request->input('start_stop_id');
            $endStops = $request->input('end_stop_id');
            $fares = $request->input('fare');
            $stageOrders = $request->input('stage_order');

            // Kiểm tra xem có thông tin chặng không
            if (is_array($startStops) && is_array($endStops) && is_array($fares) && is_array($stageOrders)) {
                // Lưu vào bảng stage
                foreach ($startStops as $index => $fromStopId) {
                    $stageData = [
                        'route_id' => $model->id, // ID của tuyến đường vừa tạo
                        'start_stop_id' => $fromStopId,
                        'end_stop_id' => $endStops[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                        'fare' => $fares[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                        'stage_order' => $stageOrders[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                    ];
                    Stage::create($stageData);
                }
            }
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }

<<<<<<< HEAD
    /**
     * Display the specified resource.
     */
=======
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
<<<<<<< HEAD
        $data = Route::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
=======
        $stops = Stop::query()->get();
        $data = Route::query()->findOrFail($id);
        $stages = $data->stages; // Lấy ra các chặng của tuyến đường
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'stops', 'stages'));
    }

    // public function update(UpdateRouteRequest $request, string $id)
    // {
    //     $data = Route::query()->findOrFail($id);
    //     $model = $request->all();
    //     $res = $data->update($model);
    //     if ($res) {
    //         return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
    //     } else {
    //         return redirect()->back()->with('danger', 'Chuyến xe không sửa thành công');
    //     }
    // }

>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    public function update(UpdateRouteRequest $request, string $id)
    {
        $data = Route::query()->findOrFail($id);
        $model = $request->all();
<<<<<<< HEAD
        $res = $data->update($model);
        if ($res) {
=======

        // Cập nhật thông tin của tuyến đường
        $res = $data->update($model);

        if ($res) {
            // Cập nhật chặng
            $this->updateStages($request, $data);

>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Chuyến xe không sửa thành công');
        }
    }

<<<<<<< HEAD
    /**
     * Remove the specified resource from storage.
     */
=======
    protected function updateStages(Request $request, Route $route)
    {
        // Xử lý các chặng đã có
        if ($request->has('start_stop_id') && $request->has('end_stop_id')) {
            $startStops = $request->input('start_stop_id');
            $endStops = $request->input('end_stop_id');
            $fares = $request->input('fare');
            $stageOrders = $request->input('stage_order');

            // Cập nhật các chặng hiện có
            foreach ($route->stages as $index => $stage) {
                if (isset($startStops[$index]) && isset($endStops[$index])) {
                    $stage->start_stop_id = $startStops[$index];
                    $stage->end_stop_id = $endStops[$index];
                    $stage->fare = $fares[$index];
                    $stage->stage_order = $stageOrders[$index];
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
                        'stage_order' => $stageOrders[$i],
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


>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    public function destroy(string $id)
    {
        $data = Route::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully');
    }
<<<<<<< HEAD
   
    public function statusRoute(Request $request,string $id)
=======

    public function statusRoute(Request $request, string $id)
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    {
        // Tìm bản ghi theo ID
        $role = Route::findOrFail($id);
        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        // Lưu thay đổi vào cơ sở dữ liệu
<<<<<<< HEAD
        $role->save(); 
=======
        $role->save();
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
