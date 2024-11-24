<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('users', 'routes')->get();
        return response()->json([
            'status' => 'success',
            'data' => $promotions
        ], 200);
    }
    public function store(StorePromotionRequest $request)
    {
        $data = $request->all();

        // Lưu ảnh nếu có
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Tạo khuyến mãi
        $promotion = Promotion::create($data);

        // Gắn người dùng vào khuyến mãi
        $promotion->users()->attach($request->input('users', []));

        // Gắn tuyến đường vào khuyến mãi
        $promotion->routes()->attach($request->input('routes', []));

        return response()->json([
            'status' => 'success',
            'message' => 'Khuyến mãi được tạo thành công.',
            'data' => $promotion
        ], 201);
    }
    public function update(UpdatePromotionRequest $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($promotion->image) {
                Storage::delete($promotion->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $promotion->update($data);

        // Đồng bộ lại user và route
        $promotion->users()->sync($request->input('users', []));
        $promotion->routes()->sync($request->input('routes', []));

        return response()->json([
            'status' => 'success',
            'message' => 'Khuyến mãi được cập nhật thành công.',
            'data' => $promotion
        ], 200);
    }
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Khuyến mãi đã được xóa.'
        ], 200);
    }
    public function applyVoucher(Request $request)
    {
        $user = auth()->user();
        $voucherCode = $request->input('code');
    
        // Kiểm tra mã khuyến mãi hợp lệ
        $promotion = Promotion::where('code', $voucherCode)
            ->where('status', 'open')
            ->first();
    
        if (!$promotion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.'
            ], 400);
        }
    
        // Kiểm tra số lượng mã khuyến mãi còn lại
        if ($promotion->count <= 0) {
            $promotion->update(['status' => 'closed']);
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng mã khuyến mãi đã hết.'
            ], 400);
        }
    
        // Kiểm tra ngày hết hạn của mã khuyến mãi
        if (Carbon::now()->gt(Carbon::parse($promotion->end_date))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mã khuyến mãi đã hết hạn.'
            ], 400);
        }
    
        // Giảm số lượng mã khuyến mãi
        $promotion->decrement('count');
    
        return response()->json([
            'status' => 'success',
            'message' => 'Mã khuyến mãi đã được áp dụng thành công.',
            'data' => $promotion
        ], 200);
    }
    
}
