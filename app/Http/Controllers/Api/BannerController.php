<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $banners = Banner::all();
            return response()->json([
                'success' => true,
                'data' => $banners
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách banner: ' . $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $banner = Banner::create($data);

            return response()->json([
                'success' => true,
                'data' => $banner
            ], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $banner = Banner::find($id);

            if (!$banner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Banner không tồn tại'
                ], 404); // 404 Not Found
            }

            return response()->json([
                'success' => true,
                'data' => $banner
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, $id): JsonResponse
    {
        try {
            $banner = Banner::find($id);

            if (!$banner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Banner không tồn tại'
                ], 404);
            }

            $data = $request->validated();
            $banner->update($data);

            return response()->json([
                'success' => true,
                'data' => $banner
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $banner = Banner::find($id);

            if (!$banner) {
                return response()->json([
                    'success' => false,
                    'message' => 'Banner không tồn tại'
                ], 404);
            }

            $banner->delete();

            return response()->json([
                'success' => true,
                'message' => 'Banner đã được xóa thành công'
            ], 204); // 204 No Content
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa banner: ' . $e->getMessage()
            ], 500);
        }
    }
}
