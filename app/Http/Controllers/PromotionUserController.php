<?php

namespace App\Http\Controllers;

use App\Models\PromotionUser;
use App\Models\Promotion;
use App\Models\User;
use App\Http\Requests\StorePromotionUserRequest;
use App\Http\Requests\UpdatePromotionUserRequest;

class PromotionUserController extends Controller
{
    const PATH_VIEW = 'admin.promotion_users.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {     $promotionUsers = PromotionUser::with('promotion')->get();
        dd( $promotionUsers);
        die();
        return view(self::PATH_VIEW . __FUNCTION__, compact('promotionUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $promotions = Promotion::all();
        $users = User::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('promotions','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionUserRequest $request)
    {
        $data = $request->all();
        $model = PromotionUser::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PromotionUser $promotionUser)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promotionUser = PromotionUser::findOrFail($id);
        $promotions = Promotion::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('promotions','promotionUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionUserRequest $request, string $id)
    {
        $promotionUser = PromotionUser::findOrFail($id);
        $promotionUser->update($request->all());
        return redirect()->route('promotion_users.index')->with('success', 'Khuyến mãi người dùng đã được cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = PromotionUser::findOrFail($id);
        $data->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.promotion_user.index')->with('success', 'Khuyến mãi đã được xóa thành công');
    }
}
