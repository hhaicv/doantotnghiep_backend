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
    {
        $promotionUsers = PromotionUser::with('promotion')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('promotionUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $promotions = Promotion::all();
        $users = User::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('promotions', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionUserRequest $request)
    {
        $data = $request->all();
        $data['new_customer_only'] = $request->has('new_customer_only') ? 1 : 0; // Kiểm tra trạng thái
        $model = PromotionUser::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('failes', 'Bạn không thêm thành công');
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
        return view(self::PATH_VIEW . __FUNCTION__, compact('promotions', 'promotionUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionUserRequest $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $data = $request->all();
        $data['new_customer_only'] = $request->has('new_customer_only') ? 1 : 0; // Kiểm tra trạng thái
    
        // Cập nhật khuyến mãi
        $promotion->update($data);
    
        // Cập nhật các quan hệ nếu cần
        $promotion->users()->sync($request->users);
        $promotion->routes()->sync($request->route_id);
        $promotion->busTypes()->sync($request->bus_type_id);
    
        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật khuyến mãi thành công!');
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
