<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\TicketBooking;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const PAYMENT_STATUS_PAID = 'paid'; // Đã thanh toán

    public function totalPrice()
    {
        $totalRevenue = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)->sum('total_price');  // Tổng doanh thu cho các vé đã thanh toán
        $totalTickets = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)->sum('total_tickets');  // Tổng số vé đã thanh toán
    
        $totalUser = User::where('type', 'user')->count();  
    
        $totalBus = Bus::count();  
    
        $monthlyData = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)
            ->selectRaw('
                SUM(total_price) as revenue,  
                COUNT(*) as total_tickets,  
                MONTH(created_at) as month 
            ')
            ->groupBy('month') 
            ->orderBy('month', 'asc')  
            ->get();
    
        $topRoutes = TicketBooking::where('status', self::PAYMENT_STATUS_PAID)
            ->with('route') 
            ->selectRaw('route_id, COUNT(*) as count') 
            ->groupBy('route_id') 
            ->orderBy('count', 'desc')  
            ->take(5)  
            ->get();
    
        return view('admin.dashboard', compact('totalRevenue', 'totalTickets', 'totalUser', 'monthlyData', 'totalBus', 'topRoutes'));
    }
    


}
