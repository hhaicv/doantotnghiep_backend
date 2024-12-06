<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Http\Requests\StoreInformationRequest;
use App\Http\Requests\UpdateInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $information = Information::all();
            return response()->json([
                'success' => true,
                'data' => $information
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách thông tin: ' . $e->getMessage()
            ], 500);
        }
    }
  
    public function store(StoreInformationRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Xử lý upload ảnh
            if ($request->hasFile('thumbnail_image')) {
                $file = $request->file('thumbnail_image');
                $path = $file->store('informations', 'public'); 
                $data['thumbnail_image'] = $path;
            }

            $information = Information::create([
                'thumbnail_image' => $data['thumbnail_image'] ?? null,
                'title' => $data['title'],
                'content' => $data['content'],
                'summary' => $data['summary'],
                'status' => $data['status'] ?? 1,
            ]);

            return response()->json([
                'success' => true,
                'data' => $information
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo thông tin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $information = Information::find($id);

            if (!$information) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thông tin không tồn tại'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $information
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin chi tiết: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateInformationRequest $request, $id): JsonResponse
    {
        try {
            $information = Information::find($id);

            if (!$information) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thông tin không tồn tại'
                ], 404);
            }

            $data = $request->validated();

            // Xử lý upload ảnh
            if ($request->hasFile('thumbnail_image')) {
                // Xóa ảnh cũ nếu có
                if ($information->thumbnail_image) {
                    Storage::disk('public')->delete($information->thumbnail_image);
                }

                $file = $request->file('thumbnail_image');
                $path = $file->store('informations', 'public');
                $data['thumbnail_image'] = $path;
            }

            $information->update([
                'thumbnail_image' => $data['thumbnail_image'] ?? $information->thumbnail_image,
                'title' => $data['title'] ?? $information->title,
                'content' => $data['content'] ?? $information->content,
                'summary' => $data['summary'] ?? $information->summary,
                'status' => $data['status'] ?? $information->status,
            ]);

            return response()->json([
                'success' => true,
                'data' => $information
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật thông tin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $information = Information::find($id);

            if (!$information) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thông tin không tồn tại'
                ], 404);
            }

            // Xóa ảnh nếu có
            if ($information->thumbnail_image) {
                Storage::disk('public')->delete($information->thumbnail_image);
            }

            $information->delete();

            return response()->json([
                'success' => true,
                'message' => 'Thông tin đã được xóa thành công'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa thông tin: ' . $e->getMessage()
            ], 500);
        }
    }
}
