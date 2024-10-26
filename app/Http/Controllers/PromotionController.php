<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Route;
use App\Models\User;

class PromotionController extends Controller
{
    const PATH_VIEW = 'admin.promotions.';
    /**
     * 
     * Display a listing of the resource.
     */
    public function index()
    {   
        $users= User::all(); 
         $data = Promotion::all();
         return view(self::PATH_VIEW . __FUNCTION__, compact('data','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Route::all(); // Lấy tất cả tuyến đường
        $buses = Bus::all(); // Lấy tất cả loại xe
        $users= User::all(); // lấy tất cả user
        return view(self::PATH_VIEW . __FUNCTION__, compact('routes','buses','users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {

        $userIds = $request->input('user_ids'); // Mảng các user ID

        // Kiểm tra ngày bắt đầu và kết thúc
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if ($startDate >= $endDate) {
            return redirect()->back()->with('error', 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc.');
        }
    
        $data = $request->except('user_ids');
        $data['new_customer_only'] = $request->has('new_customer_only') ? 1 : 0;
    
        // Tạo khuyến mãi
        $promotion = Promotion::create($data);
    
        if ($promotion) {
            // Gắn người dùng vào khuyến mãi
            $promotion->users()->sync($userIds);
    
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('danger', 'Bạn không thêm thành công');
        }
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
        $data = Promotion::query()->findOrFail($id);
        $routes = Route::all();  
        $buses = Bus::all(); 
        $users= User::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data','routes','buses','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);

        $userIds = $request->input('user_ids'); // Mảng các user ID
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        if ($startDate >= $endDate) {
            return redirect()->back()->with('error', 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc.');
        }
    
        $data = $request->except('user_ids');
        $promotion->update($data);
    
        // Cập nhật người dùng liên kết với khuyến mãi này
        $promotion->users()->sync($userIds);
    
        return redirect()->back()->with('success', 'Danh mục khuyến mãi được sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Promotion::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'Promotions deleted successfully');
    }
    public function statusPromotion(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $promotion = Promotion::findOrFail($id); // Thay 'Category' bằng model phù hợp

        // Cập nhật trạng thái 'is_active'
        $promotion->new_customer_only = $request->input('new_customer_only');
        $promotion->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }
}
