<?php

namespace App\Http\Controllers;

use App\Events\PromotionCreated;
use App\Jobs\ActivatePromotionJob;
use App\Jobs\DeactivatePromotionJob;
use App\Mail\PromotionAdded;
use App\Mail\PromotionNotificationMail;
use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Events\PromotionNotification;

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
        $categories = PromotionCategory::all();
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();


        return view(self::PATH_VIEW . __FUNCTION__, compact('routes', 'buses', 'users','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {
        // Lấy tất cả dữ liệu từ request
        $data = $request->all();

        // Xử lý ngày bắt đầu và ngày kết thúc
        $data['start_date'] = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;

        $data['end_date'] = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        // Kiểm tra và lưu file ảnh nếu có
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        // Tạo khuyến mãi
        $promotion = Promotion::create($data);

        // Kiểm tra trạng thái khuyến mãi
        // Đảm bảo trạng thái được gán đúng dựa trên ngày bắt đầu và ngày kết thúc
        if ($promotion->count == 0) {
            $promotion->status = 'closed'; // Đóng nếu hết số lượng
        } elseif ($promotion->end_date && Carbon::now()->gte(Carbon::parse($promotion->end_date))) {
            $promotion->status = 'closed'; // Đóng nếu đã qua ngày kết thúc
        } elseif ($promotion->start_date && Carbon::now()->lt(Carbon::parse($promotion->start_date))) {
            $promotion->status = 'pending'; // Chưa đến ngày bắt đầu
        } else {
            $promotion->status = 'open'; // Mở nếu đủ điều kiện (đã đến ngày bắt đầu và chưa hết ngày kết thúc)
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

        // Gắn nhiều tuyến đường vào khuyến mãi
        $routeIds = $request->input('routes', []);
        if (!empty($routeIds)) {
            $promotion->routes()->attach($routeIds);
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
        if ($request->has('promotion_category_id') && $request->input('promotion_category_id')) {
            $promotion->promotionCategory()->associate($request->input('promotion_category_id'));
            $promotion->save();
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
        // Lấy các tuyến đường và người dùng liên kết với khuyến mại hiện tại
    // $promotionRoutes = $data->routes()->pluck('route_id')->toArray();
    // $promotionUsers = $data->users()->pluck('user_id')->toArray();

    // Chỉ hiển thị danh sách các tuyến đường và người dùng liên quan
    // $routes = Route::whereIn('id', $promotionRoutes)->get();
    // $users = User::whereIn('id', $promotionUsers)->get();

        $categories = PromotionCategory::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'routes', 'buses', 'users','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
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
        if ($request->has('promotion_category_id') && $request->input('promotion_category_id')) {
            $promotion->promotionCategory()->associate($request->input('promotion_category_id'));
            $promotion->save();
        }


        $promotion->save();


        $promotion->users()->sync($request->input('users', []));

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
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để áp dụng mã khuyến mãi.');
        }
    
        $user = auth()->user();
        $voucherCode = $request->input('code');
        $routeId = $request->input('route_id'); // Tuyến đường người dùng đang sử dụng
    
        // Kiểm tra mã khuyến mãi hợp lệ
        $promotion = Promotion::where('code', $voucherCode)
            ->where('status', 'open')
            ->first();
    
        if (!$promotion) {
            return redirect()->back()->with('error', 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.');
        }
    
        // Kiểm tra xem người dùng đã sử dụng mã khuyến mãi này chưa
        if ($promotion->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Bạn đã áp dụng mã khuyến mãi này trước đó rồi. Mã chỉ có thể sử dụng một lần.');
        }
    
        // Kiểm tra tuyến đường có liên kết với mã khuyến mãi hay không
        if (!$promotion->routes()->where('route_id', $routeId)->exists()) {
            return redirect()->back()->with('error', 'Mã khuyến mãi này không áp dụng cho tuyến đường bạn đang sử dụng.');
        }
    
        // Kiểm tra số lượng mã khuyến mãi còn lại
        if ($promotion->count <= 0) {
            $promotion->update(['status' => 'closed']);
            return redirect()->back()->with('error', 'Số lượng mã khuyến mãi đã hết.');
        }
    
        // Kiểm tra ngày hết hạn của mã khuyến mãi
        if (Carbon::now()->gt(Carbon::parse($promotion->end_date))) {
            $promotion->update(['status' => 'closed']);
            return redirect()->back()->with('error', 'Mã khuyến mãi đã hết hạn.');
        }
    
        // Giảm số lượng mã khuyến mãi khi người dùng áp dụng
        $promotion->decrement('count');
        if ($promotion->count == 0) {
            $promotion->update(['status' => 'closed']);
        }
    
        return redirect()->back()->with('success', 'Mã khuyến mãi đã được áp dụng thành công.');
    }
    
}

