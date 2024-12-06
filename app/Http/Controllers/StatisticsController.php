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
        // Tạo query ban đầu
        $query = TicketBooking::query();

        // Lọc theo từ khóa (tên chuyến)
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        // Lọc theo loại (ngày, tuần, tháng, khoảng thời gian)
        if ($request->has('type') && $request->type != '') {
            if ($request->type == 'day') {
                $from = $request->from ?: date('Y-m-d');
                $query->whereDate('created_at', $from);
            } elseif ($request->type == 'week') {
                $week = $request->week ?: date('W'); // Lấy tuần hiện tại nếu không có giá trị
                $year = $request->year ?: date('Y'); // Lấy năm hiện tại nếu không có giá trị
                $query->whereRaw('YEARWEEK(created_at, 1) = YEARWEEK(?, 1)', [date("{$year}-W{$week}")]);
            } elseif ($request->type == 'month') {
                $month = $request->month ?: date('m'); // Lấy tháng hiện tại nếu không có giá trị
                $year = $request->year ?: date('Y');  // Lấy năm hiện tại nếu không có giá trị
                $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            } elseif ($request->type == 'option') {
                $from = $request->from ?: date('Y-m-d');
                $to = $request->to ?: date('Y-m-d');
                $query->whereBetween('created_at', [$from, $to]);
            }
        }

        // Lấy danh sách chuyến theo các điều kiện lọc
        $trips = $query->get();

        // Tính tổng vé và doanh thu
        $data = [
            'total_tickets' => $trips->sum('total_tickets'),
            'total_revenue' => $trips->sum('total_price'),
        ];

        // Lấy dữ liệu chi tiết cho biểu đồ
        $totalTickets = $trips->pluck('total_tickets')->toArray(); // Mảng số lượng vé
        $totalRevenue = $trips->pluck('total_price')->toArray();   // Mảng doanh thu

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


}
