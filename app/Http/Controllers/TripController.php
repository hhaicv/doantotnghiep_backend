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

        // cái này là do anh check đk thôi em kh quan tâm nhé
        $buses = Bus::query()->where('is_active', false)->get();
        $routes = Route::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('buses', 'routes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        $data = $request->all();
        $model = Trip::query()->create($data);
        if ($model) {
            $bus = Bus::find($model->bus_id); // Tìm xe tương ứng
            if ($bus) {
                $bus->is_active = true; // Hoặc là bạn có thể tạo một trường mới để đánh dấu
                $bus->save(); // Lưu thay đổi vào cơ sở dữ liệu
            }
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }

    public function edit(string $id)
    {
        $data = Trip::query()->with(['bus', 'route'])->findOrFail($id);
        $buses = Bus::query()->get();
        $routes = Route::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'buses', 'routes'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Trip::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
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
