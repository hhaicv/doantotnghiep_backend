<?php

namespace App\Http\Controllers\API;

use App\Events\PromotionCreated;
use App\Http\Controllers\Controller;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Jobs\ActivatePromotionJob;
use App\Jobs\DeactivatePromotionJob;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    const PATH_VIEW = 'admin.promotions.';
    const PATH_UPLOAD = 'promotions';

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

        // Xử lý ngày bắt đầu và ngày kết thúc
        $data['start_date'] = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $data['end_date'] = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        // Tạo khuyến mãi
        $promotion = Promotion::create($data);

        // Kiểm tra trạng thái khuyến mãi dựa trên ngày bắt đầu và ngày kết thúc
        if ($promotion->count == 0) {
            $promotion->status = 'closed'; // Đóng nếu hết số lượng
        } elseif ($promotion->end_date && Carbon::now()->gte(Carbon::parse($promotion->end_date))) {
            $promotion->status = 'closed'; // Đóng nếu đã qua ngày kết thúc
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->status = 'pending'; // Chưa đến ngày bắt đầu
        } else {
            $promotion->status = 'open'; // Mở nếu đủ điều kiện
        }

        $promotion->save();

        // Lên lịch tự động kích hoạt nếu có start_date
        if ($promotion->start_date) {
            dispatch(new ActivatePromotionJob($promotion))->delay($promotion->start_date);
        }

        // Lên lịch tự động đóng nếu có end_date
        if ($promotion->end_date) {
            dispatch(new DeactivatePromotionJob($promotion))->delay($promotion->end_date);
        }

        // Gắn người dùng vào khuyến mãi
        $userIds = $request->input('users', []);
        $promotion->users()->attach($userIds);

        // Gắn tuyến đường vào khuyến mãi
        $routeIds = $request->input('routes', []);
        if (!empty($routeIds)) {
            $promotion->routes()->attach($routeIds);
        }

        // Phát sự kiện thông báo mã khuyến mãi mới
        broadcast(new PromotionCreated($promotion))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Khuyến mãi được tạo thành công.',
            'data' => $promotion
        ], 201); // HTTP 201 Created
    }

    public function update(UpdatePromotionRequest $request, string $id)
    {
        // Lấy khuyến mãi từ database
        $promotion = Promotion::findOrFail($id);
        $data = $request->all();

        // Chuyển đổi ngày bắt đầu và kết thúc thành kiểu Carbon nếu có
        $data['start_date'] = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $data['end_date'] = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        // Kiểm tra và lưu ảnh nếu có ảnh mới
        if ($request->hasFile('image')) {
            // Nếu có ảnh cũ, xóa đi
            if ($promotion->image) {
                Storage::delete($promotion->image);
            }

            // Lưu ảnh mới
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        // Cập nhật bản ghi khuyến mãi
        $promotion->update($data);

        // Lên lịch tự động kích hoạt khuyến mãi nếu có ngày bắt đầu
        if ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            dispatch(new ActivatePromotionJob($promotion))->delay($promotion->start_date);
        }

        // Lên lịch tự động đóng khuyến mãi nếu có ngày kết thúc
        if ($promotion->end_date && Carbon::now()->lt(Carbon::parse($promotion->end_date))) {
            dispatch(new DeactivatePromotionJob($promotion))->delay($promotion->end_date);
        }

        // Kiểm tra lại trạng thái khuyến mãi sau khi cập nhật
        if ($promotion->count == 0 && $promotion->status != 'closed') {
            $promotion->status = 'closed'; // Đóng khuyến mãi nếu hết số lượng
        } elseif ($promotion->end_date && Carbon::now()->gte(Carbon::parse($promotion->end_date))) {
            $promotion->status = 'closed'; // Đóng khuyến mãi nếu đã hết hạn
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->status = 'pending'; // Đặt trạng thái là "Chưa kích hoạt" nếu chưa đến ngày bắt đầu
        } else {
            $promotion->status = 'open'; // Nếu không có điều kiện nào thỏa mãn thì mở khuyến mãi
        }

        $promotion->save();

        // Đồng bộ lại người dùng và tuyến đường
        $promotion->users()->sync($request->input('users', []));
        $promotion->routes()->sync($request->input('routes', []));

        // Phát sự kiện thông báo khuyến mãi đã được cập nhật
        broadcast(new PromotionCreated($promotion))->toOthers();

        // Trả về JSON với thông tin khuyến mãi đã cập nhật
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật khuyến mãi thành công.',
            'data' => $promotion
        ], 200); // HTTP 200 OK
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
