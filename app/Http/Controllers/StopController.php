<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use App\Http\Requests\StoreStopRequest;
use App\Http\Requests\UpdateStopRequest;
use Illuminate\Http\Request;

class StopController extends Controller
{
    const PATH_VIEW = 'admin.stops.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Stop::with('children')->whereNull('parent_id')->get();
        return view( self::PATH_VIEW. __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Stop::whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__,compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStopRequest $request)
    {
        $data = $request->all();
        $model = Stop::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Stop::query()->findOrFail($id);
        $children = Stop::whereNotNull('parent_id')->get();
        $parents = Stop::with('children')->whereNull('parent_id')->get(); // Lấy các điểm dừng cha kèm children
        return view(self::PATH_VIEW . __FUNCTION__, compact('data','parents','children'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStopRequest $request, string $id)
    {
        $data = Stop::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Danh mục điểm dừng được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Danh mục điểm dừng không sửa thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Stop::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.stops.index')->with('success', 'Bus_staiton deleted successfully');
    }
    public function statusStop(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $category = Stop::findOrFail($id); // Thay 'Category' bằng model phù hợp

        // Cập nhật trạng thái 'is_active'
        $category->is_active = $request->input('is_active');
        $category->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
