<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeatStatus;
use App\Models\BusSeat;
use App\Events\SeatStatusUpdated;

class SeatController extends Controller
{
    public function showSeats($busId)
    {
        // Lấy tất cả ghế của chuyến đi
        $seats = BusSeat::where('bus_id', $busId)->get();
   
        $seatCount = $seats->count(); // Đếm số lượng ghế

        
        // Lấy trạng thái ghế từ bảng SeatStatus
        $seatStatuses = SeatStatus::whereIn('bus_seat_id', $seats->pluck('id'))->get()->keyBy('bus_seat_id');
        
        // Trả về view cùng với thông tin ghế và trạng thái
        return view('seats', compact('seats', 'seatStatuses', 'busId','seatCount'));
    }
    public function getSeatStatus($busId)
    {
        $seats = SeatStatus::whereHas('busSeat', function ($query) use ($busId) {
            $query->where('bus_id', $busId);
        })->get();

        return response()->json($seats);
    }

    public function bookSeat(Request $request)
{
    // Kiểm tra dữ liệu gửi đến
   

    // Tiến hành tìm kiếm SeatStatus với bus_id
    $seatStatus = SeatStatus::where('bus_id', $request->bus_id)->first();

    // Kiểm tra xem SeatStatus có tồn tại hay không
    if (!$seatStatus) {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin ghế.'], 404);
    }

    // Nếu ghế có trạng thái 'available', cập nhật thành 'booked'
    if ($seatStatus->status == 'available') {
        $seatStatus->update(['status' => 'booked']);
        return response()->json(['success' => true, 'message' => 'Ghế đã được đặt.']);
    }

    return response()->json(['success' => false, 'message' => 'Ghế không khả dụng.']);
}



}
