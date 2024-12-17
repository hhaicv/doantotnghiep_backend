<?php

namespace App\Http\Controllers;

use App\Events\OrderTicket;
use App\Events\PromotionCreated;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\StoreStopRequest;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Http\Requests\UpdateStopRequest;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Jobs\ActivatePromotionJob;
use App\Jobs\DeactivatePromotionJob;
use App\Mail\PromotionAdded;
use App\Models\Banner;
use App\Models\Bus;
use App\Models\Contact;
use App\Models\Driver;
use App\Models\Information;
use App\Models\Promotion;
use App\Models\PromotionCategory;
use App\Models\Review;
use App\Models\Route;
use App\Models\Stage;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\TicketBooking;
use App\Models\TicketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeEmployeeController extends Controller
{
    const PATH_VIEW = 'admin.buses.';
    const PATH_UPLOAD = 'buses';

    const PAYMENT_STATUS_PAID = 'paid'; // Đã thanh toán

    public function tripStatistical(Request $request)
    {
        $totalRevenue = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)->sum('total_price');
        $totalTickets = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)->sum('total_tickets');
        $totalUser = User::where('type', 'user')->count();
        $totalBus = Bus::count();

        $monthlyData = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)
            ->selectRaw('
                SUM(total_price) as revenue,
                COUNT(*) as total_tickets,
                MONTH(created_at) as month
            ')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $topRoutes = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)
            ->with('route')
            ->selectRaw('route_id, COUNT(*) as count')
            ->groupBy('route_id')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        return view('employee.dashboard', compact('totalRevenue', 'totalTickets', 'totalUser', 'monthlyData', 'totalBus', 'topRoutes'));
    }

    public function contacts()
    {
        $data = Contact::all();
        return view('employee.contacts.index', compact('data'));
    }
    public function banners()
    {
        $data = Banner::all();
        return view('employee.banners.index', compact('data'));
    }
    public function createBanner()
    {
        // Hiển thị form tạo banner
        return view('employee.banners.create');
    }

    public function storeBanner(StoreBannerRequest $request)
    {

        $data = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            $data['image_url'] = Storage::put(self::PATH_UPLOAD, $request->file('image_url'));
        }

        $model = Banner::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Banner được thêm thành công');
        } else {
            return redirect()->back()->with('failes', 'Banner không được thêm thành công');
        }
    }

    public function editBanner(string $id)
    {
        $model = Banner::query()->findOrFail($id);
        return view('employee.banners.edit', compact('model'));
    }

    public function updateBanner(UpdateBannerRequest $request, string $id)
    {
        // Cập nhật banner
        $data = Banner::query()->findOrFail($id);

        $model = $request->except('image_url');
        if ($request->hasFile('image_url')) {
            $model['image_url'] = Storage::put(self::PATH_UPLOAD, $request->file('image_url'));
        }
        $image = $data->image_url;
        $res = $data->update($model);

        if ($request->hasFile('image_url') && $image && Storage::exists($image)) {
            Storage::delete($image);
        }

        if ($res) {
            return redirect()->back()->with('success', 'Banner cập nhật thành công');
        } else {
            return redirect()->back()->with('failes', 'Banner cập nhật không thành công');
        }
    }

    public function destroyBanner(string $id)
    {
        $data = Banner::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('employee.banners')->with('success', 'Banner deleted successfully');
    }
    public function statusBanners(Request $request, $id)
    {
        $role = Banner::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }

    public function reviews()
    {
        $data = Review::all();
        return view('employee.reviews.index', compact('data'));
    }

    public function information()
    {
        $data = Information::all();
        return view('employee.information.index', compact('data'));
    }

    public function routes()
    {
        $stops = Stop::all();
        $data = Route::with(['stages.startStop', 'stages.endStop'])->get()->map(function ($route) {
            $stopIds = $route->stages->flatMap(function ($stage) {
                return [$stage->start_stop_id, $stage->end_stop_id];
            })
                ->unique()
                ->sort()
                ->values();

            $route->stages = $stopIds;

            return $route;
        });
        return view('employee.routes.index', compact('data', 'stops'));
    }
    public function statusRoute(Request $request, string $id)
    {
        // Tìm bản ghi theo ID
        $role = Route::findOrFail($id);
        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        // Lưu thay đổi vào cơ sở dữ liệu
        $role->save();
        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }

    public function createRoute()
    {
        $stops = Stop::whereNotNull('parent_id')->get();
        return view('employee.routes.create', compact('stops'));
    }

    public function storeRoute(StoreRouteRequest $request)
    {
        $data = $request->except('start_stop_id', 'end_stop_id', 'fare', 'stage_order');
        $model = Route::query()->create($data);

        if ($model) {
            // Lấy các thông tin điểm dừng từ yêu cầu
            $startStops = $request->input('start_stop_id');
            $endStops = $request->input('end_stop_id');
            $fares = $request->input('fare');
            $stageOrders = $request->input('stage_order');

            // Kiểm tra xem có thông tin chặng không
            if (is_array($startStops) && is_array($endStops) && is_array($fares)) {
                // Lưu vào bảng stage
                foreach ($startStops as $index => $fromStopId) {
                    $stageData = [
                        'route_id' => $model->id, // ID của tuyến đường vừa tạo
                        'start_stop_id' => $fromStopId,
                        'end_stop_id' => $endStops[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                        'fare' => $fares[$index] ?? null, // Thêm kiểm tra để tránh lỗi
                    ];
                    Stage::create($stageData);
                }
            }
            return redirect()->back()->with('success', 'Bạn thêm thành công');
        } else {
            return redirect()->back()->with('failes', 'Bạn không thêm thành công');
        }
    }

    public function editRoute(string $id)
    {
        $stops = Stop::query()->get();
        $data = Route::query()->findOrFail($id);
        $stages = $data->stages; // Lấy ra các chặng của tuyến đường
        return view('employee.routes.edit', compact('stops', 'data', 'stages'));
    }

    public function updateRoute(UpdateRouteRequest $request, string $id)
    {
        $data = Route::query()->findOrFail($id);
        $model = $request->all();

        $res = $data->update($model);

        if ($res) {
            // Cập nhật chặng
            $this->updateStages($request, $data);

            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('failes', 'Chuyến xe không sửa thành công');
        }
    }
    protected function updateStages(Request $request, Route $route)
    {
        // Xử lý các chặng đã có
        if ($request->has('start_stop_id') && $request->has('end_stop_id')) {
            $startStops = $request->input('start_stop_id');
            $endStops = $request->input('end_stop_id');
            $fares = $request->input('fare');


            // Cập nhật các chặng hiện có
            foreach ($route->stages as $index => $stage) {
                if (isset($startStops[$index]) && isset($endStops[$index])) {
                    $stage->start_stop_id = $startStops[$index];
                    $stage->end_stop_id = $endStops[$index];
                    $stage->fare = $fares[$index];

                    $stage->save(); // Lưu lại chặng đã cập nhật
                }
            }

            // Thêm các chặng mới
            for ($i = count($route->stages); $i < count($startStops); $i++) {
                if (!empty($startStops[$i]) && !empty($endStops[$i])) {
                    $route->stages()->create([
                        'start_stop_id' => $startStops[$i],
                        'end_stop_id' => $endStops[$i],
                        'fare' => $fares[$i],
                    ]);
                }
            }
        }

        // Xóa các chặng không còn trong form
        $existingStageIds = $route->stages->pluck('id')->toArray();
        $currentStageIds = array_filter(array_merge($request->input('stage_ids', []))); // Nhận các ID từ request

        // Xóa các chặng không có trong form
        foreach ($existingStageIds as $stageId) {
            if (!in_array($stageId, $currentStageIds)) {
                $route->stages()->find($stageId)->delete();
            }
        }
    }


    public function destroyRoute(string $id)
    {
        $data = Route::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully');
    }

    public function stops()
    {
        $data = Stop::whereNull('parent_id')->with('children')->get();
        return view('employee.stops.index', compact('data'));
    }
    public function createStop()
    {

        $parents = Stop::whereNull('parent_id')->get();
        return view('employee.stops.create', compact('parents'));
    }

    public function storeStop(StoreStopRequest $request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $model = Stop::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Điểm dừng thêm thành công');
        } else {
            return redirect()->back()->with('failes', 'Điểm dừng không thêm thành công');
        }
    }
    public function editStop(string $id)
    {
        $data = Stop::query()->findOrFail($id);

        $children = Stop::whereNotNull('parent_id')->get();
        $parents = Stop::with('children')->whereNull('parent_id')->get(); // Lấy các điểm dừng cha kèm children
        return view('employee.stops.edit', compact('data', 'children', 'parents'));
    }
    public function updateStop(UpdateStopRequest $request, string $id)
    {
        try {
            // Lấy dữ liệu điểm dừng theo ID
            $stop = Stop::query()->findOrFail($id);

            // Chuẩn bị dữ liệu cập nhật
            $modelData = $request->except('image');

            $oldImage = $stop->image;

            // Xử lý hình ảnh nếu có
            if ($request->hasFile('image')) {
                $modelData['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            }

            // Cập nhật dữ liệu
            $stop->update($modelData);


            // Xóa hình ảnh cũ nếu cần
            if ($request->hasFile('image') && $oldImage && Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }

            // Trả về thông báo thành công
            return redirect()->back()->with('success', 'Điểm dừng được sửa thành công');
        } catch (\Exception $e) {
            // Xử lý lỗi
            return redirect()->back()->with('failes', 'Điểm dừng đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    public function destroyStop(string $id)
    {
        $data = Stop::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.stops')->with('success', 'Bus_staiton deleted successfully');
    }



    public function buses()
    {
        $data = Bus::all();
        return view('employee.buses.index', compact('data'));
    }
    // Hiển thị form thêm xe buýt
    public function createBus()
    {
        $drivers = Driver::query()->where('is_active', false)->get();
        return view('employee.buses.create', compact('drivers'));
    }

    // Lưu xe buýt mới vào cơ sở dữ liệu
    public function storeBus(Request $request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $data['status'] = 'active';
        $res = Bus::query()->create($data);

        if ($res->driver_id) {
            $driver = Driver::find($res->driver_id);
            if ($driver) {
                $driver->is_active = true;  // Đặt trạng thái tài xế là 'true'
                $driver->save();  // Lưu thay đổi trạng thái tài xế
            }
        }
        if ($res) {
            return redirect()->back()->with('success', 'Thêm xe thành công');
        } else {
            return redirect()->back()->with('failes', 'Xe không thêm thành công');
        }
    }

    public function editBus(string $id)
    {
        // Lấy thông tin xe bus
        $model = Bus::query()->findOrFail($id);

        // Lấy danh sách tài xế có is_active = false hoặc là tài xế hiện tại của xe
        $drivers = Driver::query()
            ->where('is_active', false)
            ->orWhere('id', $model->driver_id) // Đảm bảo tài xế hiện tại có mặt trong danh sách
            ->get();

        return view('employee.buses.edit', compact('drivers', 'model'));
    }
    public function updateBus(UpdateBusRequest $request, string $id)
    {
        // Lấy thông tin xe bus từ cơ sở dữ liệu
        $bus = Bus::query()->findOrFail($id);

        // Chuẩn bị dữ liệu từ request (trừ 'image')
        $data = $request->except('image');

        // Kiểm tra và xử lý ảnh
        if ($request->hasFile('image')) {
            // Lưu ảnh mới
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            // Xóa ảnh cũ nếu tồn tại
            if ($bus->image && Storage::exists($bus->image)) {
                Storage::delete($bus->image);
            }
        }

        // Cập nhật dữ liệu bus
        $oldDriverId = $bus->driver_id; // Lưu lại driver_id cũ
        $res = $bus->update($data); // Cập nhật bus và lưu kết quả

        // Xử lý trạng thái tài xế
        // Đặt is_active = false cho tài xế cũ (nếu có)
        if ($oldDriverId && $oldDriverId != $bus->driver_id) {
            $oldDriver = Driver::find($oldDriverId);
            if ($oldDriver) {
                $oldDriver->is_active = false;
                $oldDriver->save();
            }
        }

        // Đặt is_active = true cho tài xế mới (nếu có)
        if ($bus->driver_id) {
            $newDriver = Driver::find($bus->driver_id);
            if ($newDriver) {
                $newDriver->is_active = true;
                $newDriver->save();
            }
        }

        // Xử lý kết quả trả về
        if ($res) {
            return redirect()->back()->with('success', 'Cập nhật xe thành công');
        } else {
            return redirect()->back()->with('failes', 'Xe không cập nhật thành công');
        }
    }
    public function destroyBus(string $id)
    {
        // Tìm bản ghi Bus
        $bus = Bus::query()->findOrFail($id);

        // Xử lý tài xế liên quan
        if ($bus->driver_id) {
            $driver = Driver::find($bus->driver_id);
            if ($driver) {
                $driver->is_active = false; // Đặt trạng thái tài xế là không hoạt động
                $driver->save(); // Lưu thay đổi
            }
        }
        $bus->delete();

        // Kiểm tra nếu là yêu cầu AJAX
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Chuyển hướng về danh sách buses với thông báo thành công
        return redirect()->route('admin.buses')->with('success', 'Bus deleted successfully');
    }
    public function statusBuses(Request $request, string $id)
    {
        // Tìm bản ghi theo ID
        $role = Bus::findOrFail($id);
        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        // Lưu thay đổi vào cơ sở dữ liệu
        $role->save();
        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);
    }


    public function promotions()
    {
        $data = Promotion::all();
        return view('employee.promotions.index', compact('data'));
    }
    public function createPromotion()
    {
        $categories = PromotionCategory::all();
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();

        return view('employee.promotions.create', compact('categories', 'routes', 'buses', 'users'));
    }

    public function storePromotion(StorePromotionRequest $request)
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

        return redirect()->route('employee.promotions.index')->with('success', 'Tạo khuyến mãi thành công và đã gửi email cho người dùng.');
    }

    public function editPromotion(string $id)
    {
        $data = Promotion::with('users', 'routes')->findOrFail($id);
        $routes = Route::all();
        $buses = Bus::all();
        $users = User::all();

        $categories = PromotionCategory::all();
        return view('employee.promotions.edit', compact('data', 'routes', 'buses', 'users', 'categories'));
    }

    public function updatePromotion(UpdatePromotionRequest $request, string $id)
    {
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

        return redirect()->route('employee.promotions')->with('success', 'Cập nhật khuyến mãi thành công');
    }

    public function destroyPromotion(string $id)
    {
        $data = Promotion::query()->findOrFail($id);
        $data->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('employee.promotions')->with('success', 'promotions deleted successfully');
    }

    public function trips()
    {
        $data = Trip::with(['route', 'bus', 'bus.driver'])->get();
        return view('employee.trips.index', compact('data'));
    }
    public function statusTrip(Request $request, $id)
    {
        // Tìm bản ghi theo ID
        $role = Trip::findOrFail($id);

        // Cập nhật trạng thái 'is_active'
        $role->is_active = $request->input('is_active');
        $role->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Trả về phản hồi JSON cho client
        return response()->json(['success' => true]);;
    }

    public function createTrip()
    {
        $buses = Bus::query()->where('is_active', false)->get();
        $routes = Route::query()->get();
        return view('employee.trips.create', compact('buses', 'routes'));
    }

    public function storeTrip(StoreTripRequest $request)
    {

        $interval = $this->getRouteCycle($request->route_id);

        // Chuyển đổi start_time và end_time sang timestamp trong cùng ngày
        $start_timestamp = strtotime('today ' . $request->start_time);
        $end_timestamp = strtotime('today ' . $request->end_time);

        // Lấy tất cả các xe không hoạt động
        $buses = Bus::where('is_active', 0)->get();
        $bus_count = $buses->count(); // Đếm số lượng xe không hoạt động
        $bus_index = 0; // Khởi tạo chỉ số xe

        // Tạo chuyến đi cho mỗi xe không hoạt động
        for ($current_time = $start_timestamp; $current_time <= $end_timestamp; $current_time += $interval * 60) {
            // Kiểm tra nếu có xe không hoạt động để sử dụng
            if ($bus_count > 0 && $bus_index < $bus_count) {
                $bus = $buses[$bus_index]; // Lấy xe không hoạt động theo chỉ số

                // Kiểm tra xem chuyến đi đã tồn tại chưa
                $existing_trip = Trip::where('route_id', $request->route_id)
                    ->where('bus_id', $bus->id)
                    ->where('time_start', date('H:i', $current_time))
                    ->first();

                // Nếu chuyến đi chưa tồn tại thì thêm chuyến mới
                if (!$existing_trip) {
                    Trip::create([
                        'route_id' => $request->route_id,
                        'bus_id' => $bus->id, // Đảm bảo bus_id được cung cấp
                        'time_start' => date('H:i', $current_time),
                    ]);

                    // Đánh dấu xe là hoạt động
                    $bus->is_active = true;
                    $bus->save(); // Lưu thay đổi vào cơ sở dữ liệu

                    $bus_index++;
                }
            } else {
                break;
            }
        }
        return redirect()->back()->with('success', 'Thêm chuyến xe thành công');
    }

    public function editTrip(string $id)
    {
        $data = Trip::query()->with(['bus', 'route', 'bus.driver'])->findOrFail($id);

        $buses = Bus::query()
            ->where('is_active', false)
            ->orWhere('id', $data->bus_id) // Đảm bảo tài xế hiện tại có mặt trong danh sách
            ->get();

        $drivers = Driver::query()
            ->where('is_active', false)
            ->orWhere('id', $data->bus->driver_id) // Đảm bảo tài xế hiện tại có mặt trong danh sách
            ->get();

        $routes = Route::query()->get();

        return view('employee.trips.edit', compact('data', 'routes', 'buses', 'drivers'));
    }

    public function updateTrip(UpdateTripRequest $request, string $id)
    {
        $data = Trip::query()->findOrFail($id);
        $model = $request->all();

        // Lưu lại thông tin ban đầu
        $oldDriverId = $data->bus->driver_id ?? null;
        $oldBusId = $data->bus_id;

        // Cập nhật thông tin chuyến xe
        $res = $data->update($model);

        // Xử lý trạng thái bus
        if ($oldBusId && $oldBusId != $data->bus_id) {
            $oldBus = Bus::find($oldBusId);
            if ($oldBus) {
                $oldBus->is_active = false;
                $oldBus->save();
            }
        }
        if ($data->bus_id) {
            $newBus = Bus::find($data->bus_id);
            if ($newBus) {
                $newBus->is_active = true;
                $newBus->save();
            }
        }

        // Cập nhật tài xế nếu `driver_id` được cung cấp
        if ($request->has('driver_id')) {
            $newDriverId = $request->input('driver_id');
            $bus = $data->bus;
            if ($bus) {
                $bus->driver_id = $newDriverId;
                $bus->save();

                // Xử lý tài xế cũ
                if ($oldDriverId && $oldDriverId != $newDriverId) {
                    $oldDriver = Driver::find($oldDriverId);
                    if ($oldDriver) {
                        $oldDriver->is_active = false;
                        $oldDriver->save();
                    }
                }

                // Kích hoạt tài xế mới
                $newDriver = Driver::find($newDriverId);
                if ($newDriver) {
                    $newDriver->is_active = true;
                    $newDriver->save();
                }
            }
        }

        // Trả về kết quả
        if ($res) {
            return redirect()->back()->with('success', 'Chuyến xe được sửa thành công');
        } else {
            return redirect()->back()->with('failes', 'Chuyến xe không sửa thành công');
        }
    }
    public function getRouteCycle($route_id)
    {
        $route = Route::find($route_id);
        return response()->json([
            'route_id' => $route_id,
            'cycle' => $route ? $route->cycle : 60 // Mặc định là 60 nếu không tìm thấy
        ]);
    }

    public function destroyTrip(string $id)
    {
        $trip = Trip::query()->findOrFail($id);
        $bus_id = $trip->bus_id; // Lưu lại ID của xe trước khi xóa chuyến đi
        $trip->delete();

        // Kiểm tra xem xe còn chuyến đi nào khác không
        $remainingTrips = Trip::where('bus_id', $bus_id)->count();
        if ($remainingTrips === 0) {
            // Nếu xe không còn chuyến đi nào, cập nhật lại trạng thái thành không hoạt động
            $bus = Bus::find($bus_id);
            if ($bus) {
                $bus->is_active = 0;
                $bus->save();
            }
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.trips.index')->with('success', 'Chuyến đi đã xóa thành công');
    }

    public function tickets()
    {
        $data = Stop::query()->get();
        return view('employee.tickets.index', compact('data'));
    }

    public function change($id)
    {
        $data = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod', 'ticketDetails'])
            ->findOrFail($id);

        $stops = Stop::query()->get();

        $startStopName = Stop::where('id',  $data->id_start_stop)->value('stop_name');
        $endStopName = Stop::where('id', $data->id_end_stop)->value('stop_name');

        $nameSeats = $data->ticketDetails->pluck('name_seat')->toArray(); // Chuyển thành mảng
        $mergedNameSeats = implode(", ", $nameSeats);



        return view('employee.tickets.change', compact('data', 'startStopName', 'endStopName', 'mergedNameSeats', 'stops'));
    }

    public function load(Request $request)
    {
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');

        $id_change = $request->query('id_change');



        $showTicket = TicketBooking::query()->findOrFail($id_change);


        $methods = PaymentMethod::query()->get();

        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        // Lấy danh sách ghế bị "lock" quá 15 phút
        TicketDetail::where('status', 'lock')
            ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
                $query->where('date', $date)
                    ->where('trip_id', $trip_id);
            })
            ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
            ->delete();


        // Lấy danh sách ghế đã đặt
        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }

        return view('employee.tickets.load', compact('methods', 'seatsStatus', 'seatCount', 'showTicket'));
    }


    public function uploadTicket(Request $request)
    {
        $data = $request->validate([
            'start_stop_id' => 'required|integer',
            'end_stop_id' => 'required|integer',
            'date' => 'required|date'
        ]);

        $startRouteId = $data['start_stop_id'];
        $endRouteId = $data['end_stop_id'];
        $date = $data['date'];
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();


        // Lấy tên điểm bắt đầu và điểm kết thúc theo `id`
        $startStopName = Stop::where('id', $startRouteId)->value('stop_name');
        $endStopName = Stop::where('id', $endRouteId)->value('stop_name');

        // Lấy tất cả các chuyến có giai đoạn phù hợp
        $trips = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
            $query->where('start_stop_id', $startRouteId)
                ->where('end_stop_id', $endRouteId);
        }])
            ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
                $query->where('start_stop_id', $startRouteId)
                    ->where('end_stop_id', $endRouteId);
            })
            ->when($date === $today, function ($query) use ($currentTime) {
                // Nếu là ngày hôm nay, chỉ lấy các chuyến có time_start lớn hơn giờ hiện tại
                return $query->where('time_start', '>', $currentTime);
            })
            ->orderBy('time_start', 'asc') // Sắp xếp theo time_start từ bé đến lớn
            ->get();

        // Map dữ liệu chuyến
        $tripData = $trips->map(function ($trip) use ($startStopName, $endStopName, $date, $startRouteId, $endRouteId) {
            $stage = $trip->stages->first();
            $bookedSeatsCount = 0;

            if ($trip->ticketBookings) {
                // Đếm số ghế đã đặt theo chuyến và ngày
                $bookedSeatsCount = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip) {
                    $query->where('trip_id', $trip->id)
                        ->where('date', $date);
                })->count();
            }

            $availableSeats = $trip->bus->total_seats - $bookedSeatsCount;

            // Chỉ trả về chuyến nếu có ghế trống
            if ($availableSeats > 0) {
                return [
                    'bus_id' => $trip->bus->id,
                    'route_id' => $trip->route->id,
                    'trip_id' => $trip->id,
                    'time_start' => $trip->time_start,
                    'route_name' => $trip->route->route_name,
                    'fare' => $stage ? $stage->fare : null,
                    'name_bus' => $trip->bus->name_bus,
                    'total_seats' => $trip->bus->total_seats,
                    'booked_seats_count' => $bookedSeatsCount,
                    'available_seats' => $availableSeats,
                    'date' => $date,
                    'start_stop_name' => $startStopName,
                    'end_stop_name' => $endStopName,
                    'start_stop_id' => $startRouteId,
                    'end_stop_id' => $endRouteId,
                ];
            }
            return null;
        })->filter();

        if ($tripData->isEmpty()) {
            return response()->json(['message' => 'Không có chuyến nào.'], 404);
        }
        return response()->json($tripData);
    }

    public function create(Request $request)
    {
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');


        $methods = PaymentMethod::query()->get();

        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        // Lấy danh sách ghế bị "lock" quá 15 phút
        TicketDetail::where('status', 'lock')
            ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
                $query->where('date', $date)
                    ->where('trip_id', $trip_id);
            })
            ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
            ->delete();


        // Lấy danh sách ghế đã đặt
        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }


        return view('employee.tickets.create',  compact('methods', 'seatsStatus', 'seatCount'));
    }



    public function storeTicket(StoreTicketBookingRequest $request)
    {


        if ($request->id_change) {
            $booking = TicketBooking::findOrFail($request->id_change);
            $booking->delete();
        }
        if ($request->has('payment_method_id') && $request->payment_method_id == 2) {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua MoMo";
            $amount = $request->total_price;
            $orderId = time();
            $redirectUrl = route('employee.momo_return');
            $ipnUrl = route('employee.momo_return');
            $extraData = "";
            $requestId = time() . "";
            $requestType = "payWithATM";
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );

            $result = $this->execPostRequest($endpoint, json_encode($data));

            $jsonResult = json_decode($result, true);  // decode json


            // Save order information
            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = $orderId;

            if ($request->id_change) {
                $ticketBookingData['total_price'] = $request->input('price');
            }
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;


            $ticketBookingData['status'] = TicketBooking::PAYMENT_STATUS_UNPAID;


            $ticketBooking = TicketBooking::create($ticketBookingData);

            foreach ($seatNames as $seatName) {
                $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                TicketDetail::create([
                    'ticket_code' => $ticketCode,
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'lock'
                ]);
            }
            return redirect($jsonResult['payUrl']);
        } else if ($request->has('payment_method_id') && $request->payment_method_id == 3) {
            // VNPAY payment logic
            $endpoint = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";  // URL thanh toán VNPay
            $vnp_TmnCode = '6H9JFR7W';  // Mã Merchant của bạn
            $vnp_HashSecret = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  // Mã bí mật của bạn

            // Các tham số thanh toán
            $vnp_Amount = $request->total_price * 100;  // Số tiền thanh toán (VND, nhân với 100)
            $vnp_OrderInfo = "Thanh toán qua VNpay";
            $vnp_OrderType = 'billpayment';
            $vnp_ReturnUrl = route('employee.vnpay_return');  // URL trả về sau khi thanh toán
            $vnp_TxnRef = time();  // Mã giao dịch duy nhất

            // Tạo dữ liệu để gửi lên VNPay
            $vnp_Data = [
                "vnp_Version" => "2.1.0",
                "vnp_Command" => "pay",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Locale" => "vn",
                "vnp_CurrCode" => "VND",
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_IpAddr" => request()->ip(),
                "vnp_CreateDate" => date('YmdHis')
            ];

            // Sắp xếp các tham số theo thứ tự alphabet
            ksort($vnp_Data);

            // Tạo chuỗi dữ liệu hash
            $hashString = '';
            foreach ($vnp_Data as $key => $value) {
                // Đảm bảo không có tham số vnp_SecureHash trong chuỗi này
                if ($value != "") {
                    $hashString .= urlencode($key) . "=" . urlencode($value) . "&";
                }
            }
            // Loại bỏ dấu "&" cuối chuỗi

            $hashString = rtrim($hashString, '&');

            // Tạo chữ ký bảo mật (HMAC SHA512)
            $vnp_SecureHash = hash_hmac('sha512', $hashString, $vnp_HashSecret);

            $vnp_Data['vnp_SecureHash'] = $vnp_SecureHash;  // Thêm chữ ký vào tham số

            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = $vnp_TxnRef;
            if ($request->id_change) {
                $ticketBookingData['total_price'] = $request->input('price');
            }
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;

            $ticketBookingData['status'] = TicketBooking::PAYMENT_STATUS_UNPAID;

            $ticketBooking = TicketBooking::create($ticketBookingData);

            foreach ($seatNames as $seatName) {
                $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                TicketDetail::create([
                    'ticket_code' => $ticketCode,
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'lock'
                ]);
            }

            // Xây dựng URL redirect sang VNPay
            $vnp_Url = $endpoint . "?" . http_build_query($vnp_Data);

            return redirect($vnp_Url); // Chuyển hướng tới VNPay để thanh toán
        } else {
            return DB::transaction(function () use ($request) {
                $ticketBookingData = $request->except('name_seat', 'fare');
                $seatNames = explode(', ', $request->input('name_seat'));
                $totalTickets = count($seatNames);

                $orderCode = strtoupper(Str::random(8));
                $ticketBookingData['order_code'] = $orderCode;
                $ticketBookingData['total_tickets'] = $totalTickets;

                // Thiết lập status của TicketBooking dựa trên payment_method_id
                $ticketBookingData['status'] = $request->input('payment_method_id') == 1
                    ? TicketBooking::PAYMENT_STATUS_PAID
                    : TicketBooking::PAYMENT_STATUS_UNPAID;

                $ticketBooking = TicketBooking::create($ticketBookingData);

                foreach ($seatNames as $seatName) {
                    $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                    TicketDetail::create([
                        'ticket_code' => $ticketCode,
                        'ticket_booking_id' => $ticketBooking->id,
                        'name_seat' => $seatName,
                        'price' => $request->input('fare'),
                        'status' => 'booked'
                    ]);
                }
                event(new OrderTicket($ticketBooking));
                $data = Stop::query()->get();
                return redirect()
                    ->route('employee.tickets') // Thay bằng route của trang 'create'
                    ->with('success', 'Đặt vé thành công!')
                    ->with('data', $data);
            });
        }
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function momo_return(Request $request)
    {
        $orderId = $request->input('orderId');
        $resultCode = $request->input('resultCode'); // Mã phản hồi của MoMo

        // Tìm đơn hàng theo order ID
        $ticketBooking = TicketBooking::where('order_code', $orderId)->first();

        if (!$ticketBooking) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
        }

        // Cập nhật trạng thái thanh toán dựa trên resultCode từ MoMo
        if ($resultCode == 0) {
            // Thanh toán thành công
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID;
            $ticketBooking->save();

            // Lấy danh sách ghế liên quan đến đơn hàng
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

            // Cập nhật trạng thái ghế từ 'lock' thành 'booked'
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'booked';
                $ticketDetail->save();
            }
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('success', 'Đặt vé thành công!')
                ->with('data', $data);
        } else {
            // Thanh toán thất bại
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->delete();
            }
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('failes', 'Đặt vé thất bại!')
                ->with('data', $data);
        }
    }
    public function vnpay_return(Request $request)
    {
        // Lấy toàn bộ dữ liệu từ response của VNPay
        $vnpayResponse = $request->all();


        // Lấy chữ ký từ VNPay và loại bỏ nó khỏi dữ liệu phản hồi
        $vnpaySecureHash = $request->input('vnp_SecureHash');
        unset($vnpayResponse['vnp_SecureHash']);  // Loại bỏ chữ ký để tính toán lại

        // Sắp xếp các tham số theo thứ tự alphabetic
        ksort($vnpayResponse);

        // Xây dựng chuỗi để tính toán chữ ký
        $hashString = '';
        foreach ($vnpayResponse as $key => $value) {
            if ($value != "") {
                $hashString .= urlencode($key) . "=" . urlencode($value) . "&";
            }
        }
        $hashString = rtrim($hashString, '&');  // Loại bỏ dấu "&" cuối chuỗi

        // Tính toán lại chữ ký HMAC SHA512
        $secretKey = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  // Mã bí mật của bạn
        $calculatedHash = hash_hmac('sha512', $hashString, $secretKey);

        // Kiểm tra tính hợp lệ của chữ ký
        if ($calculatedHash !== $vnpaySecureHash) {
            return response()->json(['message' => 'Chữ ký không hợp lệ.'], 400);
        }

        // Lấy mã đơn hàng từ VNPay
        $orderId = trim($vnpayResponse['vnp_TxnRef']);  // Loại bỏ khoảng trắng


        // Tìm kiếm đơn hàng từ cơ sở dữ liệu
        $ticketBooking = TicketBooking::where('order_code', $orderId)->first();



        // Nếu không tìm thấy đơn hàng, trả về thông báo lỗi
        if (!$ticketBooking) {
            // Trả về thông báo lỗi cho người dùng
            return response()->json(['message' => 'Không tìm thấy đơn hàng. Vui lòng kiểm tra lại hoặc liên hệ hỗ trợ.'], 404);
        }

        // Kiểm tra trạng thái thanh toán
        $paymentStatus = $vnpayResponse['vnp_ResponseCode'];  // Mã phản hồi của VNPay

        if ($paymentStatus == '00') {
            // Thanh toán thành công
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID;
            $ticketBooking->save();

            // Lấy danh sách ghế liên quan đến đơn hàng
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

            // Cập nhật trạng thái ghế từ 'lock' thành 'booked'
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'booked';
                $ticketDetail->save();
            }
            event(new OrderTicket($ticketBooking));
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('success', 'Đặt vé thành công!')
                ->with('data', $data);
        } else {
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->delete();
            }
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('failes', 'Đặt vé thất bại!')
                ->with('data', $data);
        }
    }

    public function listtickets(Request $request)
    {
        $query = TicketBooking::with(['route', 'paymentMethod', 'trip']);

        // Lọc theo ngày nếu có tham số 'date'
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        // Lọc theo mã đơn hàng nếu có
        if ($request->has('order_code') && $request->order_code) {
            $query->where('order_code', 'like', "%" . $request->order_code . "%");
        }

        // Lọc theo phương thức thanh toán
        if ($request->has('payment_method_id') && $request->payment_method_id) {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        if ($request->has('payment_status') && $request->payment_status !== 'all') {
            // Lấy giá trị trạng thái thanh toán từ request
            $paymentStatus = $request->payment_status;

            // Kiểm tra nếu payment_status là một giá trị hợp lệ trong PAYMENT_STATUSES
            if (array_key_exists($paymentStatus, TicketBooking::PAYMENT_STATUSES)) {
                // Lọc theo trạng thái thanh toán
                $query->where('status', $paymentStatus);
            }
        }

        // Lấy dữ liệu
        $data = $query->orderByDesc('date')->get();


        return view('employee.tickets.list', compact('data'));
    }

    public function show(string $id)
    {
        $showTicket = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod', 'ticketDetails', 'bus.driver'])
            ->findOrFail($id);
        return view('employee.tickets.show', compact('showTicket'));
    }


    public function edit(string $id)
    {
        $showPayment = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod', 'ticketDetails'])
            ->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('showPayment'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function destroy(string $id)
    {
        try {
            // Tìm vé đặt theo ID
            $ticket = TicketBooking::findOrFail($id);

            // Xóa vé đặt
            $ticket->delete();

            // Trả về phản hồi JSON thành công
            return response()->json([
                'status' => 'success',
                'message' => 'Vé đã được xóa thành công.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Nếu không tìm thấy vé đặt
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy vé đặt.'
            ], 404);
        } catch (\Exception $e) {
            // Xử lý các lỗi khác
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra. Không thể xóa vé!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
