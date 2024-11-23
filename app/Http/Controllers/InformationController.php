<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Http\Requests\StoreInformationRequest;
use App\Http\Requests\UpdateInformationRequest;
use App\Models\NewCategory;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    const PATH_VIEW = 'admin.information.';

    const PATH_UPLOAD = 'information';

    public function index()
    {
        $data = Information::query()->get();

        $newCategories = NewCategory::all(); 

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'newCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newCategories = NewCategory::query()->pluck('name', 'id')->all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('newCategories'));
    }


    public function store(StoreInformationRequest $request)
    {
        $data = $request->except('thumbnail_image');
        $dataNewCategories = $request->newCategories;
        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = Storage::put(self::PATH_UPLOAD, $request->file('thumbnail_image'));
        }
        $res = Information::query()->create($data);
        $res->newCategories()->sync($dataNewCategories);
        if ($res) {
            return redirect()->back()->with('success', 'Thêm tin tức thành công');
        } else {
            return redirect()->back()->with('failes', 'Thêm tin tức không thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Information::query()->findOrFail($id);
        $data->increment('views_count');
        $newCategories = NewCategory::all(); // Retrieve all categories (optional if needed for filters)

        return view(self::PATH_VIEW . __FUNCTION__, compact('data','newCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = Information::query()->with('newCategories')->findOrFail($id);
        $allCategories = NewCategory::all();
        $newCategories = $data->newCategories()->pluck('id')->toArray();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data',  'allCategories', 'newCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInformationRequest $request, string $id)
    {
        $model = Information::query()->findOrFail($id);
        $data = $request->except("thumbnail_image", "newCategories");


        $dataNewCategory = $request->newCategories;


        if ($request->hasFile('thumbnail_image')) {
            // kiểm tra xem có upload file không
            $data['thumbnail_image'] = Storage::put(self::PATH_UPLOAD, $request->file('thumbnail_image'));
        }

        $cover = $model->thumbnail_image;
        $model->update($data);

        if ($request->hasFile('thumbnail_image') && $cover && Storage::exists($cover)) {
            Storage::delete($cover);
        }

        $res = $model->newCategories()->sync($dataNewCategory);

        if ($res) {
            return redirect()->back()->with('success', 'Tin tức cập nhật thành công');
        } else {
            return redirect()->back()->with('failes', 'Tin tức cập nhật không thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Information::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.information.index')->with('success', 'Information deleted successfully');
    }
}
