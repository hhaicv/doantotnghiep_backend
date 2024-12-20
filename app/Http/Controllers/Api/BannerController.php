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
  
    public function store(StoreBannerRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $path = $file->store('banners', 'public'); 
                $data['image_url'] = $path;
            }

            $banner = Banner::create([
                'image_url' => $data['image_url'],
                'link' => $data['link'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status'] ?? 1, 
            ]);

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

            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $path = $file->store('banners', 'public');
                $data['image_url'] = $path;
            }

            $banner->update([
                'image_url' => $data['image_url'] ?? $banner->image_url,
                'link' => $data['link'] ?? $banner->link,
                'start_date' => $data['start_date'] ?? $banner->start_date,
                'end_date' => $data['end_date'] ?? $banner->end_date,
                'status' => $data['status'] ?? $banner->status,
            ]);

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
