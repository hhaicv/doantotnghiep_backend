<?php

namespace App\Http\Controllers;

use App\Models\NewCategory;
use App\Http\Requests\StoreNewCategoryRequest;
use App\Http\Requests\UpdateNewCategoryRequest;
use Illuminate\Http\Request;


class NewCategoryController extends Controller
{
    const PATH_VIEW = 'admin.new_categories.';
    public function index()
    {
        $data = NewCategory::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewCategoryRequest $request)
    {
        $data = $request->all();
        $model = NewCategory::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }


    public function edit(string $id)
    {
        $data = NewCategory::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function update(UpdateNewCategoryRequest $request, string $id)
    {
        $data = NewCategory::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Danh mục tin tức được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Danh mục tin tức không sửa thành công');
        }
    }

    public function destroy(string $id)
    {
        $data = NewCategory::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.new_categories.index')->with('success', 'Category deleted successfully');
    }

    public function statusNewCategory(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $category = NewCategory::findOrFail($id); // Thay 'Category' bằng model phù hợp

        // Cập nhật trạng thái 'is_active'
        $category->is_active = $request->input('is_active');
        $category->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
