<?php

namespace App\Http\Controllers;

use App\Events\OrderTicket;
use App\Events\SeatBooked;
use App\Events\TicketCancel;
use App\Models\Cancle;
use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\UpdateTicketBookingRequest;
use App\Mail\TicketCancel as MailTicketCancel;
use App\Models\PaymentMethod;
use App\Models\Seat;
use App\Models\Stop;
use App\Models\TicketDetail;
use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TicketBookingController extends Controller
{
    const PATH_VIEW = "admin.tickets.";
    public function index()
    {

        $data = Stop::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }


    public function change($id)
    {
        $data = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod', 'ticketDetails'])
            ->findOrFail($id);

        $stops = Stop::query()->get();

        $startStopName = Stop::where('id',  $data->id_start_stop)->value('stop_name');
        $endStopName = Stop::where('id', $data->id_end_stop)->value('stop_name');

        $nameSeats = $data->ticketDetails->pluck('name_seat')->toArray(); // Chuyển thành mảng
        $mergedNameSeats = implode(", ", $nameSeats);


        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'startStopName', 'endStopName', 'mergedNameSeats', 'stops'));
    }


    public function uploadTicket(Request $request)
    {
        $data = $request->validate([
            'start_stop_id' => 'required|integer',
            'end_stop_id' => 'required|integer',
            'date' => 'required|date'
        ]);

        $startRouteId = $data['start_stop_id'];
        $endRouteId = $data['end_stop_id'];
        $date = $data['date'];
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();


        // Lấy tên điểm bắt đầu và điểm kết thúc theo `id`
        $startStopName = Stop::where('id', $startRouteId)->value('stop_name');
        $endStopName = Stop::where('id', $endRouteId)->value('stop_name');

        // Lấy tất cả các chuyến có giai đoạn phù hợp
        $trips = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
            $query->where('start_stop_id', $startRouteId)
                ->where('end_stop_id', $endRouteId);
        }])
            ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
                $query->where('start_stop_id', $startRouteId)
                    ->where('end_stop_id', $endRouteId);
            })
            ->when($date === $today, function ($query) use ($currentTime) {
                // Nếu là ngày hôm nay, chỉ lấy các chuyến có time_start lớn hơn giờ hiện tại
                return $query->where('time_start', '>', $currentTime);
            })
            ->orderBy('time_start', 'asc') // Sắp xếp theo time_start từ bé đến lớn
            ->get();

        // Map dữ liệu chuyến
        $tripData = $trips->map(function ($trip) use ($startStopName, $endStopName, $date, $startRouteId, $endRouteId) {
            $stage = $trip->stages->first();
            $bookedSeatsCount = 0;

            if ($trip->ticketBookings) {
                // Đếm số ghế đã đặt theo chuyến và ngày
                $bookedSeatsCount = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip) {
                    $query->where('trip_id', $trip->id)
                        ->where('date', $date);
                })
                    ->where('status', '!=', 'available') // Loại bỏ ghế có trạng thái 'available'
                    ->count();
            }

            $availableSeats = $trip->bus->total_seats - $bookedSeatsCount;

            // Chỉ trả về chuyến nếu có ghế trống
            if ($availableSeats > 0) {
                return [
                    'bus_id' => $trip->bus->id,
                    'route_id' => $trip->route->id,
                    'trip_id' => $trip->id,
                    'time_start' => $trip->time_start,
                    'route_name' => $trip->route->route_name,
                    'fare' => $stage ? $stage->fare : null,
                    'name_bus' => $trip->bus->name_bus,
                    'total_seats' => $trip->bus->total_seats,
                    'booked_seats_count' => $bookedSeatsCount,
                    'available_seats' => $availableSeats,
                    'date' => $date,
                    'start_stop_name' => $startStopName,
                    'end_stop_name' => $endStopName,
                    'start_stop_id' => $startRouteId,
                    'end_stop_id' => $endRouteId,
                ];
            }
            return null;
        })->filter();

        if ($tripData->isEmpty()) {
            return response()->json(['message' => 'Không có chuyến nào.'], 404);
        }
        return response()->json($tripData);
    }

    public function create(Request $request)
    {
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');


        $methods = PaymentMethod::query()->get();

        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        // Lấy danh sách ghế bị "lock" quá 15 phút
        // TicketDetail::where('status', 'lock')
        //     ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
        //         $query->where('date', $date)
        //             ->where('trip_id', $trip_id);
        //     })
        //     ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
        //     ->delete();

        // $expiredSeats = TicketDetail::where('status', 'lock')
        //     ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
        //         $query->where('date', $date)
        //             ->where('trip_id', $trip_id);
        //     })
        //     ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
        //     ->get();

        // // Nếu có ghế hết hạn, cập nhật trạng thái của ticketBooking
        // if ($expiredSeats->isNotEmpty()) {
        //     $ticketBooking = $expiredSeats->first()->ticketBooking;
        //     if ($ticketBooking) {
        //         $ticketBooking->update(['status' => TicketBooking::PAYMENT_STATUS_OVERDUE]);
        //     }
        // }

        // // Xóa ghế bị "lock" quá 15 phút
        // $expiredSeats->each->delete();

        $expiredSeats = TicketDetail::where('status', 'lock')
            ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
                $query->where('date', $date)
                    ->where('trip_id', $trip_id);
            })
            ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
            ->get();

        // Nếu có ghế hết hạn, cập nhật trạng thái của ticketBooking
        if ($expiredSeats->isNotEmpty()) {
            $ticketBooking = $expiredSeats->first()->ticketBooking;
            if ($ticketBooking) {
                $ticketBooking->update(['status' => TicketBooking::PAYMENT_STATUS_OVERDUE]);
            }
        }

        // Cập nhật trạng thái ghế từ "lock" thành "available"
        $expiredSeats->each(function ($seat) {
            $seat->update(['status' => 'available']);
        });


        // Lấy danh sách ghế đã đặt
        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }


        return view(self::PATH_VIEW . 'create', compact('methods', 'seatsStatus', 'seatCount'));
    }




    // public function updateStatus(Request $request)
    // {
    //     $validated = $request->validate([
    //         'seat_name' => 'required|string', // Đổi từ name_seat thành seat_name
    //         'trip_id' => 'required', // Đổi từ name_seat thành seat_name
    //         'date' => 'required', // Đổi từ name_seat thành seat_name
    //         'status' => 'required|string|in:available,selected,booked,lock',
    //     ]);

    //     $seat = Seat::where('name_seat', $validated['seat_name'])->first();


    //     $seat = new Seat();
    //     $seat->name_seat = $validated['seat_name'];
    //     $seat->trip_id = $validated['trip_id'];
    //     $seat->date = $validated['date'];
    //     $seat->status = $validated['status'];
    //     $seat->save();


    //     if ($seat) {
    //         $seat->status = $validated['status'];
    //         $seat->save();

    //         // Phát sự kiện cập nhật trạng thái
    //         broadcast(new SeatBooked($seat))->toOthers();

    //         return response()->json(['success' => true, 'message' => 'Seat status updated successfully']);
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'Seat not found'], 404);
    //     }
    // }



    public function store(StoreTicketBookingRequest $request)
    {
        if ($request->id_change) {
            $booking = TicketBooking::findOrFail($request->id_change);
            $booking->delete();
        }
        if ($request->has('payment_method_id') && $request->payment_method_id == 2) {
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            $orderInfo = "Thanh toán qua MoMo";
            $amount = $request->total_price;
            $orderId = time();
            $redirectUrl = route('admin.momo_return');
            $ipnUrl = route('admin.momo_return');
            $extraData = "";
            $requestId = time() . "";
            $requestType = "payWithATM";
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );

            $result = $this->execPostRequest($endpoint, json_encode($data));

            $jsonResult = json_decode($result, true);  // decode json


            // Save order information
            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = $orderId;

            if ($request->id_change) {
                $ticketBookingData['total_price'] = $request->input('price');
            }
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;


            $ticketBookingData['status'] = TicketBooking::PAYMENT_STATUS_UNPAID;


            $ticketBooking = TicketBooking::create($ticketBookingData);

            foreach ($seatNames as $seatName) {
                $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                TicketDetail::create([
                    'ticket_code' => $ticketCode,
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'lock'
                ]);
            }
            return redirect($jsonResult['payUrl']);
        } else if ($request->has('payment_method_id') && $request->payment_method_id == 3) {
            // VNPAY payment logic
            $endpoint = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";  // URL thanh toán VNPay
            $vnp_TmnCode = '6H9JFR7W';  // Mã Merchant của bạn
            $vnp_HashSecret = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  // Mã bí mật của bạn

            // Các tham số thanh toán
            $vnp_Amount = $request->total_price * 100;  // Số tiền thanh toán (VND, nhân với 100)
            $vnp_OrderInfo = "Thanh toán qua VNpay";
            $vnp_OrderType = 'billpayment';
            $vnp_ReturnUrl = route('admin.vnpay_return');  // URL trả về sau khi thanh toán
            $vnp_TxnRef = time();  // Mã giao dịch duy nhất

            // Tạo dữ liệu để gửi lên VNPay
            $vnp_Data = [
                "vnp_Version" => "2.1.0",
                "vnp_Command" => "pay",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Locale" => "vn",
                "vnp_CurrCode" => "VND",
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_IpAddr" => request()->ip(),
                "vnp_CreateDate" => date('YmdHis')
            ];

            // Sắp xếp các tham số theo thứ tự alphabet
            ksort($vnp_Data);

            // Tạo chuỗi dữ liệu hash
            $hashString = '';
            foreach ($vnp_Data as $key => $value) {
                // Đảm bảo không có tham số vnp_SecureHash trong chuỗi này
                if ($value != "") {
                    $hashString .= urlencode($key) . "=" . urlencode($value) . "&";
                }
            }
            // Loại bỏ dấu "&" cuối chuỗi

            $hashString = rtrim($hashString, '&');

            // Tạo chữ ký bảo mật (HMAC SHA512)
            $vnp_SecureHash = hash_hmac('sha512', $hashString, $vnp_HashSecret);

            $vnp_Data['vnp_SecureHash'] = $vnp_SecureHash;  // Thêm chữ ký vào tham số

            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = $vnp_TxnRef;
            if ($request->id_change) {
                $ticketBookingData['total_price'] = $request->input('price');
            }
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;

            $ticketBookingData['status'] = TicketBooking::PAYMENT_STATUS_UNPAID;

            $ticketBooking = TicketBooking::create($ticketBookingData);

            foreach ($seatNames as $seatName) {
                $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                TicketDetail::create([
                    'ticket_code' => $ticketCode,
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'lock'
                ]);
            }

            // Xây dựng URL redirect sang VNPay
            $vnp_Url = $endpoint . "?" . http_build_query($vnp_Data);

            return redirect($vnp_Url); // Chuyển hướng tới VNPay để thanh toán
        } else {
            return DB::transaction(function () use ($request) {
                $ticketBookingData = $request->except('name_seat', 'fare');
                $seatNames = explode(', ', $request->input('name_seat'));
                $totalTickets = count($seatNames);

                $orderCode = strtoupper(Str::random(8));
                $ticketBookingData['order_code'] = $orderCode;
                $ticketBookingData['total_tickets'] = $totalTickets;

                // Thiết lập status của TicketBooking dựa trên payment_method_id
                $ticketBookingData['status'] = $request->input('payment_method_id') == 1
                    ? TicketBooking::PAYMENT_STATUS_PAID
                    : TicketBooking::PAYMENT_STATUS_UNPAID;
                if ($request->id_change) {
                    $ticketBookingData['total_price'] = $request->input('price');
                }

                $ticketBooking = TicketBooking::create($ticketBookingData);

                foreach ($seatNames as $seatName) {
                    $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                    TicketDetail::create([
                        'ticket_code' => $ticketCode,
                        'ticket_booking_id' => $ticketBooking->id,
                        'name_seat' => $seatName,
                        'price' => $request->input('fare'),
                        'status' => 'booked'
                    ]);
                }
                event(new OrderTicket($ticketBooking));
                $data = Stop::query()->get();
                return redirect()
                    ->route('admin.tickets.index') // Thay bằng route của trang 'create'
                    ->with('success', 'Đặt vé thành công!')
                    ->with('data', $data);
            });
        }
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function momo_return(Request $request)
    {
        $orderId = $request->input('orderId');
        $resultCode = $request->input('resultCode'); // Mã phản hồi của MoMo

        // Tìm đơn hàng theo order ID
        $ticketBooking = TicketBooking::where('order_code', $orderId)->first();

        if (!$ticketBooking) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
        }

        // Cập nhật trạng thái thanh toán dựa trên resultCode từ MoMo
        if ($resultCode == 0) {
            // Thanh toán thành công
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID;
            $ticketBooking->save();

            // Lấy danh sách ghế liên quan đến đơn hàng
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

            // Cập nhật trạng thái ghế từ 'lock' thành 'booked'
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'booked';
                $ticketDetail->save();
            }
            $data = Stop::query()->get();
            event(new OrderTicket($ticketBooking));
            return redirect()
                ->route('admin.tickets.index')
                ->with('success', 'Đặt vé thành công!')
                ->with('data', $data);
        } else {
            // Thanh toán thất bại
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'available';
                $ticketDetail->save();
            }
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('failes', 'Đặt vé thất bại!')
                ->with('data', $data);
        }
    }
    public function vnpay_return(Request $request)
    {
        // Lấy toàn bộ dữ liệu từ response của VNPay
        $vnpayResponse = $request->all();


        // Lấy chữ ký từ VNPay và loại bỏ nó khỏi dữ liệu phản hồi
        $vnpaySecureHash = $request->input('vnp_SecureHash');
        unset($vnpayResponse['vnp_SecureHash']);  // Loại bỏ chữ ký để tính toán lại

        // Sắp xếp các tham số theo thứ tự alphabetic
        ksort($vnpayResponse);

        // Xây dựng chuỗi để tính toán chữ ký
        $hashString = '';
        foreach ($vnpayResponse as $key => $value) {
            if ($value != "") {
                $hashString .= urlencode($key) . "=" . urlencode($value) . "&";
            }
        }
        $hashString = rtrim($hashString, '&');  // Loại bỏ dấu "&" cuối chuỗi

        // Tính toán lại chữ ký HMAC SHA512
        $secretKey = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  // Mã bí mật của bạn
        $calculatedHash = hash_hmac('sha512', $hashString, $secretKey);

        // Kiểm tra tính hợp lệ của chữ ký
        if ($calculatedHash !== $vnpaySecureHash) {
            return response()->json(['message' => 'Chữ ký không hợp lệ.'], 400);
        }

        // Lấy mã đơn hàng từ VNPay
        $orderId = trim($vnpayResponse['vnp_TxnRef']);  // Loại bỏ khoảng trắng


        // Tìm kiếm đơn hàng từ cơ sở dữ liệu
        $ticketBooking = TicketBooking::where('order_code', $orderId)->first();



        // Nếu không tìm thấy đơn hàng, trả về thông báo lỗi
        if (!$ticketBooking) {
            // Trả về thông báo lỗi cho người dùng
            return response()->json(['message' => 'Không tìm thấy đơn hàng. Vui lòng kiểm tra lại hoặc liên hệ hỗ trợ.'], 404);
        }

        // Kiểm tra trạng thái thanh toán
        $paymentStatus = $vnpayResponse['vnp_ResponseCode'];  // Mã phản hồi của VNPay

        if ($paymentStatus == '00') {
            // Thanh toán thành công
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID;
            $ticketBooking->save();

            // Lấy danh sách ghế liên quan đến đơn hàng
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

            // Cập nhật trạng thái ghế từ 'lock' thành 'booked'
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'booked';
                $ticketDetail->save();
            }
            event(new OrderTicket($ticketBooking));
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('success', 'Đặt vé thành công!')
                ->with('data', $data);
        } else {
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'available';
                $ticketDetail->save();
            }
            $data = Stop::query()->get();
            return redirect()
                ->route('admin.tickets.index')
                ->with('failes', 'Đặt vé thất bại!')
                ->with('data', $data);
        }
    }

    public function list(Request $request)
    {
        $query = TicketBooking::with(['route', 'paymentMethod', 'trip', 'cancel']);

        // Lọc theo ngày nếu có tham số 'date'
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        // Lọc theo mã đơn hàng nếu có
        if ($request->has('order_code') && $request->order_code) {
            $query->where('order_code', 'like', "%" . $request->order_code . "%");
        }

        // Lọc theo phương thức thanh toán
        if ($request->has('payment_method_id') && $request->payment_method_id) {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        if ($request->has('payment_status') && $request->payment_status !== 'all') {
            // Lấy giá trị trạng thái thanh toán từ request
            $paymentStatus = $request->payment_status;

            // Kiểm tra nếu payment_status là một giá trị hợp lệ trong PAYMENT_STATUSES
            if (array_key_exists($paymentStatus, TicketBooking::PAYMENT_STATUSES)) {
                // Lọc theo trạng thái thanh toán
                $query->where('status', $paymentStatus);
            }
        }
        // Lấy dữ liệu
        $data = $query->orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function show(string $id)
    {

        $showTicket = TicketBooking::query()
            ->with([
                'trip',
                'bus',
                'route',
                'user',
                'paymentMethod',
                'ticketDetails',
                'bus.driver'
            ])
            ->findOrFail($id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('showTicket'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $showPayment = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod', 'ticketDetails'])
            ->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('showPayment'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function load(Request $request)
    {
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');

        $id_change = $request->query('id_change');



        $showTicket = TicketBooking::query()->findOrFail($id_change);


        $methods = PaymentMethod::query()->get();

        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        // Lấy danh sách ghế bị "lock" quá 15 phút
        TicketDetail::where('status', 'lock')
            ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
                $query->where('date', $date)
                    ->where('trip_id', $trip_id);
            })
            ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
            ->delete();


        // Lấy danh sách ghế đã đặt
        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }

        return view(self::PATH_VIEW . 'load', compact('methods', 'seatsStatus', 'seatCount', 'showTicket'));
    }







    public function destroy(string $id)
    {
        try {
            // Tìm vé đặt theo ID
            $ticket = TicketBooking::findOrFail($id);

            // Xóa vé đặt
            $ticket->delete();

            // Trả về phản hồi JSON thành công
            return response()->json([
                'status' => 'success',
                'message' => 'Vé đã được xóa thành công.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Nếu không tìm thấy vé đặt
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy vé đặt.'
            ], 404);
        } catch (\Exception $e) {
            // Xử lý các lỗi khác
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra. Không thể xóa vé!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancel(string $id)
    {
        $ticketBooking = TicketBooking::findOrFail($id);

        $ticketBooking->status = TicketBooking::PAYMENT_STATUS_REFUNDED;
        $ticketBooking->save();

        // Lấy danh sách ghế liên quan đến đơn hàng
        $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

        // Cập nhật trạng thái ghế từ 'lock' thành 'available'
        foreach ($ticketDetails as $ticketDetail) {
            $ticketDetail->status = 'available';
            $ticketDetail->save();
        }

        $cancel = Cancle::where('ticket_booking_id', $id)->firstOrFail();

        event(new TicketCancel($cancel));



        $cancel->delete();


        return redirect()->back();
    }
}
