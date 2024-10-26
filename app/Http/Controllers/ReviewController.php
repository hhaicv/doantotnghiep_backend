<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    const PATH_VIEW = 'admin.reviews.';
    public function index()
    {
        $data = Review::with(['trip.route'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $trips = Trip::query()->get();
        $users = User::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $data = $request->all();
        $res = Review::create($data);

        if ($res) {
            return redirect()->back()->with('success', 'Nhận xét thêm thành công');
        } else {
            return redirect()->back()->with('success', 'Nhận xét thêm không thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Review::query()->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, string $id)
    {
        $data = Review::query()->findOrFail($id);
        $model = $request->all();
        $res = $data->update($model);
        if ($res) {
            return redirect()->back()->with('success', 'Nhận xét được sửa thành công');
        } else {
            return redirect()->back()->with('danger', 'Nhận xét không sửa thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Review::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully');
    }

    public function statusRole(Request $request, string $id)
    {
        // Tìm bản ghi theo ID
        $role = Review::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
