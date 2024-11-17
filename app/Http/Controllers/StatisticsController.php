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
            $conditions[] = ['name', 'LIKE', '%' . $request->keyword . '%'];
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


}
