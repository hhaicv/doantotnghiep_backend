<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $contacts = Contact::all();
            return response()->json([
                'success' => true,
                'data' => $contacts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách liên hệ: ' . $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $contact = Contact::create($data);

            return response()->json([
                'success' => true,
                'data' => $contact
            ], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo liên hệ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'success' => false,
                    'message' => 'Liên hệ không tồn tại'
                ], 404); // 404 Not Found
            }

            return response()->json([
                'success' => true,
                'data' => $contact
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin liên hệ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, $id): JsonResponse
    {
        try {
            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'success' => false,
                    'message' => 'Liên hệ không tồn tại'
                ], 404);
            }

            $data = $request->validated();
            $contact->update($data);

            return response()->json([
                'success' => true,
                'data' => $contact
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật liên hệ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'success' => false,
                    'message' => 'Liên hệ không tồn tại'
                ], 404);
            }

            $contact->delete();

            return response()->json([
                'success' => true,
                'message' => 'Liên hệ đã được xóa thành công'
            ], 204); // 204 No Content
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa liên hệ: ' . $e->getMessage()
            ], 500);
        }
    }
}
