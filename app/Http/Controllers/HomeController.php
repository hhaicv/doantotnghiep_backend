<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\TicketBooking;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function totalPrice()
    {
        // Tính tổng doanh thu (total_price) và tổng số vé (total_tickets) trực tiếp
        $totalRevenue = TicketBooking::sum('total_price');
        $totalTickets = TicketBooking::sum('total_tickets');
        $totalUser = User::where('type', 'user')->count();
        $totalBus = Bus::count();

        $monthlyData = TicketBooking::selectRaw('
            SUM(total_price) as revenue,
            COUNT(*) as total_tickets,
            MONTH(created_at) as month
        ')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Truyền dữ liệu vào view
        return view('admin.dashboard', compact('totalRevenue', 'totalTickets', 'totalUser','monthlyData','totalBus'));
    }


}
