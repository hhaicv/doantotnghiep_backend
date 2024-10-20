<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
    const PATH_VIEW = 'admin.buses.';
    const PATH_UPLOAD = 'buses';

    public function index()
    {
        $data = Bus::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function store(StoreBusRequest $request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $data['status'] = 'active';
        $res = Bus::query()->create($data);
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
        $model = Bus::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('model'));
    }

    public function update(UpdateBusRequest $request, string $id)
    {
        $data = Bus::query()->findOrFail($id);
        $model = $request->except('image');
        if ($request->hasFile('image')) {
            $model['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $image = $data->image;
        $res = $data->update($model);
        if ($request->hasFile('image') && $image && Storage::exists($image)) {
            Storage::delete($image);
        }
        if ($res) {
            return redirect()->back()->with('success', 'buses được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'buses không sửa thành công');
        }
    }

    public function destroy(string $id)
    {
        $data = Bus::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.buses.index')->with('success', 'buses deleted successfully');
    }

    public function statusBuses(Request $request,string $id)
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
