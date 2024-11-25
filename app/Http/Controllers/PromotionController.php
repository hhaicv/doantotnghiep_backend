<?php

namespace App\Http\Controllers;

use App\Events\PromotionCreated;
use App\Mail\PromotionAdded;
use App\Mail\PromotionNotificationMail;
use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Events\PromotionNotification;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Route;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    const PATH_VIEW = 'admin.promotions.';
    const PATH_UPLOAD = 'promotions';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $data = Promotion::with('users', 'routes')->get(); // Lấy danh sách khuyến mãi cùng người dùng
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();


        return view(self::PATH_VIEW . __FUNCTION__, compact('routes', 'buses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {

        $data = $request->all();
        $data = $request->except('image');

        // Kiểm tra xem có file ảnh không
        if ($request->hasFile('image')) {
            // Lưu ảnh vào thư mục 'public/images'
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $promotion = Promotion::create($data);
        // Nếu số lượng khuyến mãi bằng 0, đóng khuyến mãi
        if ($promotion->count == 0) {
            $promotion->status = 'closed'; // Đóng khuyến mãi
            $promotion->save();
        }

        // Gắn người dùng vào khuyến mãi
        $userIds = $request->input('users', []);
        $promotion->users()->attach($userIds);

        // Gắn nhiều tuyến đường vào khuyến mãi
        $routeIds = $request->input('routes', []);
        if (!empty($routeIds)) {
            $promotion->routes()->attach($routeIds);  // Gắn các tuyến đường vào bảng promotion_route
        }



        // Kiểm tra nếu chọn gửi đến tất cả người dùng
        if ($request->input('send_to_all')) {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new PromotionAdded($promotion));
            }
        } else {
            // Gửi email đến người dùng đã chọn
            foreach ($userIds as $userId) {
                $user = User::find($userId);
                if ($user) {
                    Mail::to($user->email)->send(new PromotionAdded($promotion));
                }
            }
        }
        // Phát sự kiện thông báo mã khuyến mãi mới
        event(new PromotionCreated($promotion));

        return redirect()->route('admin.promotions.index')->with('success', 'Tạo khuyến mãi thành công và đã gửi email cho người dùng.');
    }

    public function show(Promotion $promotion)
    {
        //
    }


    public function edit(string $id)
    {
        $data = Promotion::with('users', 'routes')->findOrFail($id);
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'routes', 'buses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $data = $request->all();
        // $data['new_customer_only'] = $request->has('new_customer_only') ? 1 : 0;
        if ($request->hasFile('image')) {

            if ($promotion->image) {
                Storage::delete($promotion->image);
            }

            // Lưu ảnh mới
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        // Cập nhật bản ghi khuyến mãi
        $promotion->update($data);
        if ($promotion->count == 0 && $promotion->status != 'closed') {
            $promotion->status = 'closed'; // Đóng khuyến mãi
            $promotion->save();
        }

        // Cập nhật người dùng liên kết
        $promotion->users()->sync($request->input('users', []));

        // Cập nhật tuyến đường liên kết
        $promotion->routes()->sync($request->input('routes', []));
        broadcast(new PromotionCreated($promotion))->toOthers();
        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật khuyến mãi thành công');
    }
    public function destroy(string $id)
    {
        $data = Promotion::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.promotions.index')->with('success', 'promotions deleted successfully');
    }
    /**
     * Update promotion status.
     */
    public function statusPromotion(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->new_customer_only = $request->input('new_customer_only');
        $promotion->save();

        return response()->json(['success' => true]);
    }

    /**
     * Assign multiple promotions to a user.
     */
    public function assignPromotionsToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $promotionIds = $request->input('promotion_ids');

        // Gán khuyến mãi cho user
        $user->promotions()->sync($promotionIds);

        return redirect()->back()->with('success', 'Khuyến mãi đã được gắn cho người dùng thành công');
    }

    /**
     * Assign multiple users to a promotion.
     */
    public function assignUsersToPromotion(Request $request, $promotionId)
    {
        $promotion = Promotion::findOrFail($promotionId);
        $userIds = $request->input('user_ids');

        // Gắn người dùng cho khuyến mãi
        $promotion->users()->sync($userIds);

        return redirect()->back()->with('success', 'Người dùng đã được gắn cho khuyến mãi thành công');
    }
    public function sendPromotionNotification($userId = null)
    {
        // Lấy khuyến mãi mới nhất
        $promotion = Promotion::latest()->first();

        if (!$promotion) {
            return response()->json(['status' => 'No promotions found'], 404);
        }

        // Chuẩn bị dữ liệu khuyến mãi
        $promotionData = [
            'code' => $promotion->code,
            'discount' => $promotion->discount,
            'description' => $promotion->description,
            'end_date' => $promotion->end_date,
        ];
    }
    public function showPromotions()
    {
        $promotions = Promotion::where('status', 1)
            ->where('count', '>', 0)
            ->whereDate('end_date', '>=', now())
            ->get();

        // Lấy tất cả các mã khuyến mãi đã hết số lượng hoặc đã hết hạn
        $expiredPromotions = Promotion::where('status', 1)
            ->where('count', 0)
            ->orWhereDate('end_date', '<', now())
            ->get();

        // Trả về view với các mã khuyến mãi đang hoạt động và hết hạn
        return view('admin.promotions.index', compact('promotions', 'expiredPromotions'));
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
            return redirect()->back()->with('error', 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.');
        }

        // Kiểm tra số lượng mã khuyến mãi còn lại
        if ($promotion->count <= 0) {
            // Cập nhật trạng thái mã khuyến mãi nếu số lượng = 0
            $promotion->update(['status' => 'closed']);
            return redirect()->back()->with('error', 'Số lượng mã khuyến mãi đã hết.');
        }

        // Kiểm tra ngày hết hạn của mã khuyến mãi
        if (Carbon::now()->gt(Carbon::parse($promotion->end_date))) {
            return redirect()->back()->with('error', 'Mã khuyến mãi đã hết hạn.');
        }

        // Giảm số lượng mã khuyến mãi khi người dùng áp dụng
        $promotion->decrement('count');

        return redirect()->back()->with('success', 'Mã khuyến mãi đã được áp dụng thành công.');
    }
}

