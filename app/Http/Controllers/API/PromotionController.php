<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\PromotionCreated;
use App\Jobs\ActivatePromotionJob;
use App\Jobs\DeactivatePromotionJob;
use App\Mail\PromotionAdded;
use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\PromotionCategory;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Route;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    const PATH_UPLOAD = 'promotions';

    public function index()
    {
        $data = Promotion::with('users', 'routes')->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function create()
    {
        $categories = PromotionCategory::all();
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => compact('categories', 'routes', 'buses', 'users')
        ]);
    }

    public function store(StorePromotionRequest $request)
    {
        $data = $request->all();
        $data['start_date'] = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $data['end_date'] = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $promotion = Promotion::create($data);

        if ($promotion->count == 0) {
            $promotion->status = 'closed';
        } elseif ($promotion->end_date && Carbon::now()->gte(Carbon::parse($promotion->end_date))) {
            $promotion->status = 'closed';
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->status = 'pending';
        } else {
            $promotion->status = 'open';
        }

        $promotion->save();

        if ($promotion->start_date) {
            dispatch(new ActivatePromotionJob($promotion))->delay($promotion->start_date);
        }

        if ($promotion->end_date) {
            dispatch(new DeactivatePromotionJob($promotion))->delay($promotion->end_date);
        }

        $userIds = $request->input('users', []);
        $promotion->users()->attach($userIds);

        $routeIds = $request->input('routes', []);
        if (!empty($routeIds)) {
            $promotion->routes()->attach($routeIds);
        }

        if ($request->input('send_to_all')) {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new PromotionAdded($promotion));
            }
        } else {
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    Mail::to($user->email)->send(new PromotionAdded($promotion));
                }
            }
        }

        if ($request->has('promotion_category_id') && $request->input('promotion_category_id')) {
            $promotion->promotionCategory()->associate($request->input('promotion_category_id'));
            $promotion->save();
        }

        event(new PromotionCreated($promotion));

        return response()->json(['success' => true, 'message' => 'Tạo khuyến mãi thành công.', 'data' => $promotion]);
    }

    public function edit($id)
    {
        $data = Promotion::with('users', 'routes')->findOrFail($id);
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();
        $categories = PromotionCategory::all();

        return response()->json([
            'success' => true,
            'data' => compact('data', 'routes', 'buses', 'users', 'categories')
        ]);
    }

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

        if ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            dispatch(new ActivatePromotionJob($promotion))->delay($promotion->start_date);
        }

        if ($promotion->end_date && Carbon::now()->lt(Carbon::parse($promotion->end_date))) {
            dispatch(new DeactivatePromotionJob($promotion))->delay($promotion->end_date);
        }

        if ($promotion->count == 0 && $promotion->status != 'closed') {
            $promotion->status = 'closed';
        } elseif ($promotion->end_date && Carbon::now()->gte(Carbon::parse($promotion->end_date))) {
            $promotion->status = 'closed';
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->status = 'pending';
        } else {
            $promotion->status = 'open';
        }

        if ($request->has('promotion_category_id') && $request->input('promotion_category_id')) {
            $promotion->promotionCategory()->associate($request->input('promotion_category_id'));
            $promotion->save();
        }

        $promotion->save();
        $promotion->users()->sync($request->input('users', []));
        $promotion->routes()->sync($request->input('routes', []));

        broadcast(new PromotionCreated($promotion))->toOthers();

        return response()->json(['success' => true, 'message' => 'Cập nhật khuyến mãi thành công.', 'data' => $promotion]);
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return response()->json(['success' => true, 'message' => 'Xóa khuyến mãi thành công.']);
    }

    public function statusPromotion(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->new_customer_only = $request->input('new_customer_only');
        $promotion->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái khuyến mãi thành công.']);
    }

    public function assignPromotionsToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $promotionIds = $request->input('promotion_ids');
        $user->promotions()->sync($promotionIds);

        return response()->json(['success' => true, 'message' => 'Gán khuyến mãi cho người dùng thành công.']);
    }

    public function assignUsersToPromotion(Request $request, $promotionId)
    {
        $promotion = Promotion::findOrFail($promotionId);
        $userIds = $request->input('user_ids');
        $promotion->users()->sync($userIds);

        return response()->json(['success' => true, 'message' => 'Gán người dùng vào khuyến mãi thành công.']);
    }

    public function sendPromotionNotification($userId = null)
    {
        $promotion = Promotion::latest()->first();

        if (!$promotion) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy khuyến mãi nào.'], 404);
        }

        $promotionData = [
            'code' => $promotion->code,
            'discount' => $promotion->discount,
            'description' => $promotion->description,
            'end_date' => $promotion->end_date,
        ];

        return response()->json(['success' => true, 'data' => $promotionData]);
    }

    public function showPromotions()
    {
        $promotions = Promotion::where('status', 1)
            ->where('count', '>', 0)
            ->whereDate('end_date', '>=', now())
            ->get();

        $expiredPromotions = Promotion::where('status', 1)
            ->where('count', 0)
            ->orWhereDate('end_date', '<', now())
            ->get();

        return response()->json([
            'success' => true,
            'active_promotions' => $promotions,
            'expired_promotions' => $expiredPromotions
        ]);
    }
    public function applyVoucher(Request $request)
    {
        // Lấy thông tin từ request
        $voucherCode = $request->input('code');
        $routeId = $request->input('route_id');
        $userId = $request->input('user_id');
        
        // Tìm mã khuyến mãi theo mã
        $promotion = Promotion::where('code', $voucherCode)
            ->where('status', 'open')
            ->first();
        
        // Nếu không tìm thấy mã khuyến mãi
        if (!$promotion) {
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.']);
        }
    
        // // Kiểm tra xem người dùng đã sử dụng mã này chưa
        // $usedPromotion = $promotion->users()->where('user_id', $userId)->exists();
        // if ($usedPromotion) {
        //     return response()->json(['success' => false, 'message' => 'Bạn đã sử dụng mã khuyến mãi này.']);
        // }
    
        // Kiểm tra xem mã khuyến mãi có áp dụng cho tuyến đường này không
        $appliesToRoute = $promotion->routes()->where('route_id', $routeId)->exists();
        if (!$appliesToRoute) {
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi không áp dụng cho tuyến đường đã chọn.']);
        }
    
        // Kiểm tra số lượng khuyến mãi còn lại
        if ($promotion->count <= 0) {
            $promotion->update(['status' => 'closed']);
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi không còn khả dụng.']);
        }
    
        // Kiểm tra ngày hết hạn khuyến mãi
        if (Carbon::now()->gt(Carbon::parse($promotion->end_date))) {
            $promotion->update(['status' => 'closed']);
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi đã hết hạn.']);
        }
    
        // Giảm số lượng khuyến mãi và cập nhật trạng thái nếu cần
        $promotion->decrement('count');
        if ($promotion->count == 0) {
            $promotion->update(['status' => 'closed']);
        }
    
        // Liên kết mã khuyến mãi với người dùng
        $promotion->users()->attach($userId); // Đảm bảo sử dụng attach nếu bạn đang dùng bảng trung gian
    
        return response()->json(['success' => true, 'message' => 'Áp dụng mã khuyến mãi thành công.']);
    }
    
    
}
