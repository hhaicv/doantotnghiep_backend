<?php
namespace App\Http\Controllers;

use App\Models\TicketBooking;
use App\Models\TicketDetail;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Bus;


class HomeDriverController extends Controller{

    public function index(){

    }
    public function showDashboard()
    {
        // Giả sử bạn đã lấy ID của tài xế từ thông tin đăng nhập
        $driverId = auth()->user()->id; // Nếu sử dụng auth cho tài xế

        // Lấy tất cả các vé mà tài xế này đã phục vụ
        $tickets = TicketBooking::with(['bus.driver', 'ticketDetails'])
            ->whereHas('bus.driver', function ($query) use ($driverId) {
                $query->where('id', $driverId); // Lọc vé của tài xế theo ID
            })
            ->get();

        // Trả về view và truyền biến tickets vào view
        return view('driver.dashboard', compact('tickets'));
    }


}
