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
    public function index( Request $request)
    {
        $userId = $request->input('user_id'); // Nhận `user_id` từ request

        if ($userId) {
            // Lấy danh sách các mã khuyến mãi liên quan đến user đó
            $promotions = Promotion::whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
    
            // Nếu user không có mã khuyến mãi, trả về tất cả mã còn lại
            if ($promotions->isEmpty()) {
                $promotions = Promotion::whereDoesntHave('users')->get();
            }
        } else {
            // Nếu không có `user_id`, lấy tất cả các mã khuyến mãi
            $promotions = Promotion::all();
        }
    
        return response()->json([
            'success' => true,
            'data' => $promotions,
        ]);
    }
    public function getByCategory(Request $request)
    {
      // Lấy user_id từ query string
      $userId = $request->input('user_id');

      // Kiểm tra xem có user_id không
      if (!$userId) {
          return response()->json([
              'success' => false,
              'message' => 'User ID là bắt buộc.',
          ], 400);
      }
  
      // Kiểm tra sự tồn tại của user
      $user = User::find($userId);
      if (!$user) {
          return response()->json([
              'success' => false,
              'message' => 'User không tồn tại.',
          ], 404);
      }
  
      // Lấy tất cả danh mục với các khuyến mãi liên quan đến user_id
      $categories = PromotionCategory::with(['promotions' => function ($query) use ($userId) {
          // Lọc các khuyến mãi của user
          $query->whereHas('users', function ($query) use ($userId) {
              $query->where('user_id', $userId);
          });
      }])->get();
  
      // Kiểm tra nếu không có danh mục hoặc khuyến mãi nào
      if ($categories->isEmpty()) {
          return response()->json([
              'success' => false,
              'message' => 'Không tìm thấy danh mục hoặc khuyến mãi nào cho người dùng này.',
          ], 404);
      }
  
      // Trả về dữ liệu danh mục và các khuyến mãi liên quan
      return response()->json([
          'success' => true,
          'data' => $categories,
      ], 200);
}
    public function show($id)
    {
        $promotion = Promotion::find($id); // Chỉ lấy thông tin của khuyến mãi theo IDv

        if (!$promotion) {
            return response()->json([
                'success' => false,
                'message' => 'Khuyến mãi không tồn tại.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $promotion,
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
    public function applyPromotion(Request $request)
    {
        $userId = $request->input('user_id');
        $promoCode = $request->input('promo_code');
        $routeId = $request->input('route_id'); // Tuyến đường
    
        // Kiểm tra thông tin đầu vào
        if (!$userId || !$promoCode || !$routeId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID, mã khuyến mãi, và tuyến đường là bắt buộc.'
            ], 400);
        }
    
        // Lấy mã khuyến mãi từ cơ sở dữ liệu
        $promotion = Promotion::where('code', $promoCode)->first();
    
        if (!$promotion) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không tồn tại.'
            ], 404);
        }
    
        // Kiểm tra xem mã khuyến mãi có được gán cho người dùng không
        $isAssignedToUser = $promotion->users()->where('user_id', $userId)->exists();
    
        if (!$isAssignedToUser) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền sử dụng mã khuyến mãi này.'
            ], 403);
        }
    
        // Kiểm tra xem mã khuyến mãi có áp dụng cho tuyến đường không
        $isAssignedToRoute = $promotion->routes()->where('route_id', $routeId)->exists();
    
        if (!$isAssignedToRoute) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không áp dụng cho tuyến đường này.'
            ], 403);
        }
    
        // Logic áp dụng mã khuyến mãi (nếu cần)
        return response()->json([
            'success' => true,
            'message' => 'Mã khuyến mãi đã được áp dụng thành công!',
            'data' => $promotion
        ]);
    }
}
