<?php

namespace App\Http\Controllers;

use App\Models\PromotionCategory;
use Illuminate\Http\Request;

class PromotionCategoryController extends Controller
{
    const PATH_VIEW = 'admin.promotion_categories.';
    const PATH_UPLOAD = 'promotion_categories';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PromotionCategory::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__,);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $model = PromotionCategory::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = PromotionCategory::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = PromotionCategory::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Danh mục tin tức được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Danh mục tin tức không sửa thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = PromotionCategory::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.promotion_categories.index')->with('success', 'Category deleted successfully');
    }
    public function statusPromotionCategory(Request $request, $id)
    {
        $procategory = PromotionCategory::findOrFail($id);
        $procategory->is_active = $request->input('is_active');
        $procategory->save();

        return response()->json(['success' => true]);
    }
}
