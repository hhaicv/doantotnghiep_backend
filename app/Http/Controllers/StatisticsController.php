<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Route;
use App\Models\TicketBooking;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function showRevenue() {
        $revenue = $this->revenueStatistics();
        $routes = $this->revenueByRoute();
        $buses = $this->revenueByBusType();
        return view('statistics.revenue', compact('revenue', 'routes', 'buses'));
    }
    
    // 1.1 Doanh thu theo khoảng thời gian
    public function revenueStatistics()
    {
        $todayRevenue = Payment::whereDate('created_at', Carbon::today())->sum('amount');
        $weeklyRevenue = Payment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
        $monthlyRevenue = Payment::whereMonth('created_at', Carbon::now()->month)->sum('amount');
        $yearlyRevenue = Payment::whereYear('created_at', Carbon::now()->year)->sum('amount');

        return [
            'today' => $todayRevenue,
            'week' => $weeklyRevenue,
            'month' => $monthlyRevenue,
            'year' => $yearlyRevenue,
        ];
    }

    // 1.2 Doanh thu theo tuyến đường
    public function revenueByRoute()
    {
        return Route::withSum(['trips.ticketBookings.payment' => function ($query) {
            $query->where('status', 'paid'); // Giả sử chỉ lấy doanh thu từ vé đã thanh toán
        }], 'amount')->get();
    }
    
    // 1.3 Doanh thu theo loại xe
    public function revenueByBusType()
    {
        return Bus::withSum(['trips.ticketBookings.payment' => function ($query) {
            $query->where('status', 'paid');
        }], 'amount')->get();
    }

    // 2. Thống kê vé đặt
    // 2.1 Số lượng vé đặt theo ngày
    public function ticketStatistics()
    {
        $todayTickets = TicketBooking::whereDate('created_at', Carbon::today())->count();
        $weeklyTickets = TicketBooking::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyTickets = TicketBooking::whereMonth('created_at', Carbon::now()->month)->count();
        $yearlyTickets = TicketBooking::whereYear('created_at', Carbon::now()->year)->count();

        return [
            'today' => $todayTickets,
            'week' => $weeklyTickets,
            'month' => $monthlyTickets,
            'year' => $yearlyTickets,
        ];
    }

    // 2.2 Số lượng vé đặt theo tuyến đường
    public function ticketsByRoute()
    {
        return Route::withCount('trips.ticketBookings')->get();
    }

    // 2.3 Số lượng vé đặt theo loại xe
    public function ticketsByBusType()
    {
        return Bus::withCount('trips.ticketBookings')->get();
    }

    // 2.4 Chuyến xe được đặt nhiều nhất
    public function mostBookedTrip()
    {
        return Trip::withCount('ticketBookings')
            ->orderBy('ticket_bookings_count', 'desc')
            ->first();
    }

    // 2.5 Tỷ lệ lấp đầy của các chuyến
    public function tripOccupancyRate()
    {
        return Trip::with(['bus.seats', 'ticketBookings'])->get()->map(function ($trip) {
            $totalSeats = $trip->bus->seats->count();
            $bookedSeats = $trip->ticketBookings->count();
            $occupancyRate = $totalSeats > 0 ? ($bookedSeats / $totalSeats) * 100 : 0;

            return [
                'trip_id' => $trip->id,
                'occupancy_rate' => $occupancyRate,
            ];
        });
    }

    // 3. Thống kê người dùng
    // 3.1 Số lượng khách hàng đăng ký theo thời gian
    public function newUserStatistics()
    {
        $dailyNewUsers = User::whereDate('created_at', Carbon::today())->count();
        $weeklyNewUsers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyNewUsers = User::whereMonth('created_at', Carbon::now()->month)->count();

        return [
            'daily' => $dailyNewUsers,
            'weekly' => $weeklyNewUsers,
            'monthly' => $monthlyNewUsers,
        ];
    }

    // 3.2 Tỷ lệ quay lại của khách hàng
    public function customerReturnRate()
    {
        $totalCustomers = User::count();
        $returningCustomers = User::has('ticketBookings', '>', 1)->count();
        $returnRate = $totalCustomers > 0 ? ($returningCustomers / $totalCustomers) * 100 : 0;

        return $returnRate;
    }

    // 3.3 Khách hàng tiềm năng
    public function frequentCustomers()
    {
        return User::withCount('ticketBookings')
            ->having('ticket_bookings_count', '>=', 5) // Giả sử đặt từ 5 lần trở lên là tiềm năng
            ->get();
    }

    // 4. Thống kê hoạt động thanh toán
    // 4.1 Tỷ lệ thanh toán thành công 
    public function successfulPaymentRate()
    {
        $totalPayments = Payment::count();
        $successfulPayments = Payment::where('status', 'paid')->count();
        $successRate = $totalPayments > 0 ? ($successfulPayments / $totalPayments) * 100 : 0;

        return $successRate;
    }

    // 4.2 Phân tích phương thức thanh toán
    public function paymentMethodStatistics()
    {
        return PaymentMethod::withCount('payments')->get();
    }
}
