<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Mail;

class PromotionController extends Controller
{
    const PATH_VIEW = 'admin.promotions.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $data = Promotion::with('users')->get(); // Lấy danh sách khuyến mãi cùng người dùng
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
    $data['status'] = $request->has('status') ? 1 : 0; // Kiểm tra trạng thái checkbox
    $promotion = Promotion::create($data);

    // Gắn người dùng vào khuyến mãi
    $userIds = $request->input('users', []);
    $promotion->users()->attach($userIds);

    // Kiểm tra nếu chọn gửi đến tất cả người dùng
    if ($request->input('send_to_all')) { // Giả sử bạn có checkbox để chọn tất cả
        $users = User::all(); // Lấy tất cả người dùng
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

    return redirect()->route('admin.promotions.index')->with('success', 'Tạo khuyến mãi thành công và đã gửi email cho người dùng.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Promotion::with('users')->findOrFail($id); // Lấy khuyến mãi cùng người dùng liên quan
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

        // Cập nhật dữ liệu khuyến mãi
        $data = $request->all();
        $data['new_customer_only'] = $request->has('new_customer_only') ? 1 : 0; // Kiểm tra trạng thái checkbox
        $promotion->update($data);

        // Cập nhật người dùng liên kết
        $promotion->users()->sync($request->input('users', []));

        return redirect()->route('admin.promotions.index')->with('success', 'Cập nhật khuyến mãi thành công');
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
}
