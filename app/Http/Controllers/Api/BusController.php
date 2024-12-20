<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $buses = Bus::all();
            return response()->json([
                'success' => true,
                'data' => $buses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách xe: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreBusRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $file->store('buses', 'public'); 
                $data['image'] = $path;
            }

            $bus = Bus::create($data);

            return response()->json([
                'success' => true,
                'data' => $bus
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo xe: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $bus = Bus::find($id);

            if (!$bus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Xe không tồn tại'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $bus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin xe: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateBusRequest $request, $id): JsonResponse
    {
        try {
            $bus = Bus::find($id);

            if (!$bus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Xe không tồn tại'
                ], 404);
            }

            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($bus->image) {
                    Storage::disk('public')->delete($bus->image);
                }
                $file = $request->file('image');
                $path = $file->store('buses', 'public');
                $data['image'] = $path;
            }

            $bus->update($data);

            return response()->json([
                'success' => true,
                'data' => $bus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật xe: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $bus = Bus::find($id);

            if (!$bus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Xe không tồn tại'
                ], 404);
            }

            if ($bus->image) {
                Storage::disk('public')->delete($bus->image);
            }

            $bus->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xe đã được xóa thành công'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa xe: ' . $e->getMessage()
            ], 500);
        }
    }
}
