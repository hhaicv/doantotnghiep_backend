<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    const PATH_VIEW = 'admin.banners.';
    const PATH_UPLOAD = 'banners';


    public function index()
    {
        $data = Banner::query()->get();
        return view(self::PATH_VIEW. __FUNCTION__, compact('data'));
    }


    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }


    public function store(StoreBannerRequest $request)
    {
        $data = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            $data['image_url'] = Storage::put(self::PATH_UPLOAD, $request->file('image_url'));
        }

        $model = Banner::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Banner được thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Banner không được thêm thành công');
        }
    }


    public function show(Banner $banner)
    {
        //
    }


    public function edit(string $id)
    {
        $model = Banner::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('model'));
    }


    public function update(UpdateBannerRequest $request, string $id)
    {
        $data = Banner::query()->findOrFail($id);

        $model = $request->except('image_url');
        if ($request->hasFile('image_url')) {
            $model['image_url'] = Storage::put(self::PATH_UPLOAD, $request->file('image_url'));
        }
        $image = $data->image_url;
        $res = $data->update($model);

        if ($request->hasFile('image_url') && $image && Storage::exists($image)) {
            Storage::delete($image);
        }

        if ($res) {
            return redirect()->back()->with('success', 'Banner được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Banner không sửa thành công');
        }
    }


    public function destroy(string $id)
    {
        $data = Banner::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
    }

    public function statusBanner(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $role = Banner::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
