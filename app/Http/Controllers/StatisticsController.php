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
    public function tripStatistical(Request $request)
    {
        $conditions = [];

        // Lọc theo từ khóa (tên chuyến)
        if ($request->has('keyword') && $request->keyword != '') {
            $conditions[] = ['phone', 'LIKE', '%' . $request->keyword . '%'];
        }

        // Lọc theo loại (ngày, tuần, tháng, khoảng thời gian)
        if ($request->has('type') && $request->type != '') {
            if ($request->type == 'day') {
                $from = $request->from ?: date('Y-m-d');
                $conditions[] = ['created_at', 'DATE', date_format(date_create($from), "Y-m-d")];
            } elseif ($request->type == 'week') {
                // Thêm xử lý lọc theo tuần
            } elseif ($request->type == 'month') {
                // Thêm xử lý lọc theo tháng
            } elseif ($request->type == 'option') {
                $from = $request->from ?: date('Y-m-d');
                $to = $request->to ?: date('Y-m-d');
                $conditions[] = ['created_at', 'BETWEEN', [$from, $to]];
            }
        }

        $trips = TicketBooking::where($conditions)->get();


        // Tính tổng vé và doanh thu
        $data = [
            'total_tickets' => $trips->sum('total_tickets'),
            'total_revenue' => $trips->sum('total_price'),
        ];

        $totalTickets = $trips->pluck('total_tickets')->toArray(); // Lấy dữ liệu total_tickets dưới dạng mảng
        $totalRevenue = $trips->pluck('total_price')->toArray(); // Lấy dữ liệu total_price dưới dạng mảng
//        dd($data,$totalTickets, $totalRevenue);
        return view('admin.statistics.statistical_trip', compact('trips', 'data', 'totalTickets', 'totalRevenue'));
    }

//    public function eggOpenStatistical(Request $request)
//    {
//        if (!$this->checkRole('30.7')) {
//            return redirect()->route('admin.dashboard')->with('error', config('constants.notice_not_allowed'));
//        }
//        $conditions = [];
//        if ($request->keyword) {
//            $whereLike = [
//                ['ref_code', 'LIKE', $request->keyword],
//                ['username', 'ORLIKE', $request->keyword]
//            ];
//            $users = $this->userRepository->findAttributes($whereLike, ['id', 'username', 'ref_code']);
//            if ($users && collect($users)->count() > 0) {
//                $arrIdList = collect($users)->pluck('id')->toArray();
//                $conditions[] = ['user_id', 'IN', $arrIdList];
//            }
//        }
//        if ($request->type) {
//            if ($request->type == 'day') {
//                $from = $request->from ?: date('Y-m-d');
//                $conditions[] = ['created_at', 'DATE', date_format(date_create($from), "Y-m-d")];
//            } else {
//                $from = $request->from ?: date('Y-m-d');
//                $to = $request->to ?: date('Y-m-d');
//                $between = [date_format(date_create($from), "Y-m-d H:i:s"), date_format(date_create($to), "Y-m-d") . " 23:59:59"];
//                $conditions[] = ['created_at', 'BETWEEN', $between];
//            }
//        }
//
//        $eggOpenHistoryData = $this->eggOpenHistoryRepository->findWhere($conditions, ['id','hero_type','rarity','fee']);
//        $grouped = collect($eggOpenHistoryData)->groupBy('rarity')->map(function ($group) {
//            $arr['opens_total'] = $group->count('id');
//            $arr['fees_total'] = $group->sum('fee');
//            return $arr;
//        });
//        $totalOpens = $eggOpenHistoryData->count();
//
//        return view('admins.statistical.egg_open_statistical', compact('grouped', 'totalOpens'));
//    }

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
