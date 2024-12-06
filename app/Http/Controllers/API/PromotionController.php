<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Jobs\ActivatePromotionJob;
use App\Jobs\DeactivatePromotionJob;
use App\Models\User;
use App\Models\Route;
use App\Models\PromotionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PromotionAdded;
use Carbon\Carbon;

class PromotionController extends Controller
{
    const PATH_UPLOAD = 'promotions';

    /**
     * Danh sách khuyến mãi.
     */
    public function index()
    {
        $promotions = Promotion::with('users', 'routes', 'promotionCategory')->get();
        return response()->json([
            'success' => true,
            'data' => $promotions,
        ], 200);
    }
    public function getByCategory($categoryId)
    {
        // Kiểm tra xem danh mục có tồn tại hay không
        $category = PromotionCategory::find($categoryId);

        if (!$category) {
            dd($category->promotions); // 
            // Trả về lỗi nếu danh mục không tồn tại
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại.',
            ], 404);
        }

        // Lấy tất cả các khuyến mãi trong danh mục này (không lọc theo trạng thái)
        $promotions = $category->promotions; // Đây là cách gọi phương thức `promotions()` đã khai báo ở model PromotionCategory
        
        // Trả về danh sách các khuyến mãi trong danh mục
        return response()->json([
            'success' => true,
            'data' => $promotions,
        ], 200);
    }

    /**
     * Tạo khuyến mãi mới.
     */
    public function store(StorePromotionRequest $request)
    {
        $data = $request->all();

        // Xử lý ngày bắt đầu và ngày kết thúc
        $data['start_date'] = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $data['end_date'] = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        // Lưu ảnh nếu có
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $promotion = Promotion::create($data);

        // Gắn quan hệ
        $promotion->users()->attach($request->input('users', []));
        $promotion->routes()->attach($request->input('routes', []));
        if ($request->has('promotion_category_id')) {
            $promotion->promotionCategory()->associate($request->input('promotion_category_id'));
            $promotion->save();
        }

        // Gửi email nếu cần
        if ($request->input('send_to_all')) {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new PromotionAdded($promotion));
            }
        } else {
            foreach ($request->input('users', []) as $userId) {
                $user = User::find($userId);
                if ($user) {
                    Mail::to($user->email)->send(new PromotionAdded($promotion));
                }
            }
        }

        // Xử lý trạng thái khuyến mãi trực tiếp
        if ($promotion->count == 0) {
            $promotion->update(['status' => 'closed']);
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->update(['status' => 'pending']);
            ActivatePromotionJob::dispatch($promotion)->delay(Carbon::parse($promotion->start_date));
        } else {
            $promotion->update(['status' => 'open']);
        }

        if ($promotion->end_date) {
            DeactivatePromotionJob::dispatch($promotion)->delay(Carbon::parse($promotion->end_date));
        }

        return response()->json([
            'success' => true,
            'message' => 'Tạo khuyến mãi thành công.',
            'data' => $promotion,
        ], 201);
    }

    /**
     * Cập nhật khuyến mãi.
     */
    public function update(UpdatePromotionRequest $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $data = $request->all();

        $data['start_date'] = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $data['end_date'] = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        if ($request->hasFile('image')) {
            if ($promotion->image) {
                Storage::delete($promotion->image);
            }
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $promotion->update($data);

        // Gắn quan hệ
        $promotion->users()->sync($request->input('users', []));
        $promotion->routes()->sync($request->input('routes', []));
        if ($request->has('promotion_category_id')) {
            $promotion->promotionCategory()->associate($request->input('promotion_category_id'));
            $promotion->save();
        }

        // Xử lý trạng thái khuyến mãi trực tiếp
        if ($promotion->count == 0) {
            $promotion->update(['status' => 'closed']);
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->update(['status' => 'pending']);
            ActivatePromotionJob::dispatch($promotion)->delay(Carbon::parse($promotion->start_date));
        } else {
            $promotion->update(['status' => 'open']);
        }

        if ($promotion->end_date) {
            DeactivatePromotionJob::dispatch($promotion)->delay(Carbon::parse($promotion->end_date));
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật khuyến mãi thành công.',
            'data' => $promotion,
        ], 200);
    }

    /**
     * Xóa khuyến mãi.
     */
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa khuyến mãi thành công.',
        ], 200);
    }

    /**
     * Áp dụng mã khuyến mãi.
     */
    public function applyVoucher(Request $request)
    {
        // if (!auth()->check()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Bạn cần đăng nhập để áp dụng mã khuyến mãi.',
        //     ], 401);
        // }

        $user = auth()->user();
        $voucherCode = $request->input('code');
        $routeId = $request->input('route_id');

        $promotion = Promotion::where('code', $voucherCode)->where('status', 'open')->first();

        if (!$promotion) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.',
            ], 400);
        }

        if ($promotion->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã áp dụng mã khuyến mãi này trước đó.',
            ], 400);
        }

        if (!$promotion->routes()->where('route_id', $routeId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không áp dụng cho tuyến đường này.',
            ], 400);
        }

        if ($promotion->count <= 0) {
            $promotion->update(['status' => 'closed']);
            return response()->json([
                'success' => false,
                'message' => 'Số lượng mã khuyến mãi đã hết.',
            ], 400);
        }

        $promotion->decrement('count');
        if ($promotion->count == 0) {
            $promotion->update(['status' => 'closed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mã khuyến mãi đã được áp dụng thành công.',
        ], 200);
    }
}
