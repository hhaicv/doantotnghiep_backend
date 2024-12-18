<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Stop;
use App\Http\Requests\StoreStopRequest;
use App\Http\Requests\UpdateStopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StopController extends Controller
{
    const PATH_VIEW = 'admin.stops.';

    const PATH_UPLOAD = 'stops';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Stop::whereNull('parent_id')->with('children')->get();

        foreach ($data as $stop) {
            $stop->has_related_data = $this->hasRelatedData($stop->id);
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    private function hasRelatedData($stopId)
    {
        $hasRelatedData = false;

        // Kiểm tra bảng chuyến (Trip)
        if (Stop::where('parent_id', $stopId)->exists()) {
            $hasRelatedData = true;
        }
        if (Stage::where('start_stop_id', $stopId)->exists()) {
            $hasRelatedData = true;
        }

        return $hasRelatedData;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $parents = Stop::whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('parents'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStopRequest $request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $model = Stop::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Điểm dừng thêm thành công');
        } else {
            return redirect()->back()->with('failes', 'Điểm dừng không thêm thành công');
        }
    }


    public function edit(string $id)
    {
        $data = Stop::query()->findOrFail($id);

        $children = Stop::whereNotNull('parent_id')->get();
        $parents = Stop::with('children')->whereNull('parent_id')->get(); // Lấy các điểm dừng cha kèm children
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'parents', 'children'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStopRequest $request, string $id)
    {
        try {
            // Lấy dữ liệu điểm dừng theo ID
            $stop = Stop::query()->findOrFail($id);

            // Chuẩn bị dữ liệu cập nhật
            $modelData = $request->except('image');

            $oldImage = $stop->image;

            // Xử lý hình ảnh nếu có
            if ($request->hasFile('image')) {
                $modelData['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            }

            // Cập nhật dữ liệu
            $stop->update($modelData);


            // Xóa hình ảnh cũ nếu cần
            if ($request->hasFile('image') && $oldImage && Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }

            // Trả về thông báo thành công
            return redirect()->back()->with('success', 'Điểm dừng được sửa thành công');
        } catch (\Exception $e) {
            // Xử lý lỗi
            return redirect()->back()->with('failes', 'Điểm dừng đã xảy ra lỗi: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stop = Stop::query()->findOrFail($id);

        // Kiểm tra nếu `Stop` có liên kết với các `Stop` con
        if ($stop->children()->exists() || $this->hasRelatedData($stop->id)) {
            return response()->json(['error' => 'Không thể xóa điểm dừng này vì nó đang được sử dụng.'], 400);
        }

        // Xóa ảnh đại diện nếu có
        if ($stop->image && Storage::exists($stop->image)) {
            Storage::delete($stop->image);
        }

        $stop->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.stops.index')->with('success', 'Trạm đã được xóa thành công.');
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
