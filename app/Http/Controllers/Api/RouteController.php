<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Models\Stop;
use App\Models\TicketBooking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RouteController extends Controller
{
    const PAYMENT_STATUS_PAID = 'paid'; // Đã thanh toán
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $routes = Route::all();
            return response()->json([
                'success' => true,
                'data' => $routes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách tuyến: ' . $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    public function popular(): JsonResponse
    {
        try {
            // Lấy các tuyến phổ biến cùng với thông tin route
            $topRoutes = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)
                ->with('route') // Nạp trước quan hệ route
                ->selectRaw('route_id, COUNT(*) as count')
                ->groupBy('route_id')
                ->orderBy('count', 'desc')
                ->take(3)
                ->get();

            // Lặp qua các tuyến để thêm thông tin start_stop và end_stop
            $topRoutes = $topRoutes->map(function ($item) {
                // Lấy start_route_id và end_route_id từ route
                $startStop = Stop::find($item->route->start_route_id ?? null);
                $endStop = Stop::find($item->route->end_route_id ?? null);

                return [
                    'route_id' => $item->route_id,
                    'count' => $item->count,
                    'route_name' => $item->route->route_name ?? null,
                    'start_stop' => $startStop->stop_name ?? null,
                    'start_route_id'=>$item->route->start_route_id ?? null,
                    'end_route_id'=>$item->route->end_route_id ?? null,
                    'end_stop' => $endStop->stop_name ?? null,
                    'cycle'=>$item->route->cycle ?? null,
                    'route_price'=>$item->route->route_price ?? null,
                    'length'=>$item->route->length ?? null,
                ];

            });

            // Trả về kết quả
            return response()->json([
                'success' => true,
                'data' => $topRoutes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách tuyến: ' . $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRouteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $route = Route::create($data);

            return response()->json([
                'success' => true,
                'data' => $route
            ], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo tuyến: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $route = Route::find($id);

            if (!$route) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuyến không tồn tại'
                ], 404); // 404 Not Found
            }

            return response()->json([
                'success' => true,
                'data' => $route
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin tuyến: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRouteRequest $request, $id): JsonResponse
    {
        try {
            $route = Route::find($id);

            if (!$route) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuyến không tồn tại'
                ], 404);
            }

            $data = $request->validated();
            $route->update($data);

            return response()->json([
                'success' => true,
                'data' => $route
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật tuyến: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $route = Route::find($id);

            if (!$route) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuyến không tồn tại'
                ], 404);
            }

            $route->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tuyến đã được xóa thành công'
            ], 204); // 204 No Content
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa tuyến: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the status of the specified route.
     */
    public function statusRoute(Request $request, $id): JsonResponse
    {
        try {
            $route = Route::find($id);

            if (!$route) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuyến không tồn tại'
                ], 404);
            }

            $isActive = $request->input('is_active');

            if (!is_bool($isActive)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giá trị is_active phải là true hoặc false'
                ], 400); // 400 Bad Request
            }

            $route->is_active = $isActive;
            $route->save();

            return response()->json([
                'success' => true,
                'message' => 'Trạng thái tuyến đã được cập nhật thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật trạng thái tuyến: ' . $e->getMessage()
            ], 500);
        }
    }
}
