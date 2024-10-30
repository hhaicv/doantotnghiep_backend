<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewCategory;
use App\Http\Requests\StoreNewCategoryRequest;
use App\Http\Requests\UpdateNewCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $categories = NewCategory::all();
            return response()->json([
                'success' => true,
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách danh mục: ' . $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function store(StoreNewCategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $category = NewCategory::create($data);
            return response()->json([
                'success' => true,
                'data' => $category,
            ], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi thêm danh mục: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $category = NewCategory::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại: ' . $e->getMessage(),
            ], 404); // 404 Not Found
        }
    }

    public function update(UpdateNewCategoryRequest $request, $id): JsonResponse
    {
        try {
            $category = NewCategory::findOrFail($id);
            $data = $request->validated();
            $category->update($data);
            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật danh mục: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $category = NewCategory::findOrFail($id);
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Danh mục đã được xóa thành công',
            ], 204); // 204 No Content
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa danh mục: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function statusNewCategory(Request $request, $id): JsonResponse
    {
        try {
            $category = NewCategory::findOrFail($id);
            $category->is_active = $request->input('is_active');
            $category->save();
            return response()->json([
                'success' => true,
                'message' => 'Trạng thái danh mục đã được cập nhật',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật trạng thái: ' . $e->getMessage(),
            ], 500);
        }
    }
}
