<?php

namespace App\Http\Controllers;

use App\Models\NewCategory;
use App\Http\Requests\StoreNewCategoryRequest;
use App\Http\Requests\UpdateNewCategoryRequest;

class NewCategoryController extends Controller
{
    const PATH_VIEW = 'admin.news_categories.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = NewCategory::query()->get();
        return view( self::PATH_VIEW. __FUNCTION__, compact('data'));
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

    /**
     * Display the specified resource.
     */
    public function show(NewCategory $newCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = NewCategory::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewCategoryRequest $request, string $id)
    {
        $model = NewCategory::query()->findOrFail($id);
        $data = $request->all();
      
        $res = $model->update($data);
        
        if ($res) {
            return redirect()->back()->with('success', 'Bạn sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không sửa thành công');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = NewCategory::query()->findOrFail($id);
        $data->delete();
        return back();
    }
}
