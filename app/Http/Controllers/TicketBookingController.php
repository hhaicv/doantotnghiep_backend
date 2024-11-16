<?php

namespace App\Http\Controllers;

use App\Events\OrderTicket;
use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\UpdateTicketBookingRequest;
use App\Models\Payment;
use App\Models\PaymentMethod;

use App\Models\Stop;
use App\Models\TicketDetail;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketBookingController extends Controller
{
    const PATH_VIEW = "admin.tickets.";
    public function index()
    {

        $data = Stop::query()->get();


        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
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
                })->count();
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

    // public function create(Request $request)
    // {
    //     $trip_id = $request->query('trip_id');
    //     $date = $request->query('date');

    //     $methods = PaymentMethod::query()->get();

    //     $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
    //     $seatCount = $trip->bus->total_seats;

    //     $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
    //         $query->where('date', $date)
    //             ->where('trip_id', $trip_id);
    //     })->get();

    //     $seatsStatus = [];
    //     foreach ($seatsBooked as $seat) {
    //         $seatsStatus[$seat->name_seat] = $seat->status;
    //     }
    //     return view(self::PATH_VIEW . 'create', compact('methods', 'seatsStatus', 'seatCount'));
    // }

    public function create(Request $request)
    {
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');

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

        return view(self::PATH_VIEW . 'create', compact('methods', 'seatsStatus', 'seatCount'));
    }

    public function store(StoreTicketBookingRequest $request)
    {
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
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;

            // Thiết lập status của TicketBooking dựa trên payment_method_id
            $ticketBookingData['status'] = $request->input('payment_method_id') == 1
                ? TicketBooking::PAYMENT_STATUS_PAID
                : TicketBooking::PAYMENT_STATUS_UNPAID;

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
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;

            // Thiết lập status của TicketBooking dựa trên payment_method_id
            $ticketBookingData['status'] = $request->input('payment_method_id') == 1
                ? TicketBooking::PAYMENT_STATUS_PAID
                : TicketBooking::PAYMENT_STATUS_UNPAID;

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
                return redirect()->back()->with('success', 'Đặt vé thành công!');
            });
        }
    }

    public function thanks()
    {
        echo "thanh toán thành công";
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

            return redirect()->route('admin.thanks')->with('message', 'Thanh toán thành công!');
        } else {
            // Thanh toán thất bại
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->delete();
            }
            return redirect()->route('admin.thanks')->with('message', 'Thanh toán thất bại.');
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
          
            return redirect()->route('admin.thanks')->with('message', 'Thanh toán thành công!');
        } else {
            // Thanh toán thất bại
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();
            return redirect()->route('admin.thanks')->with('message', 'Thanh toán thất bại.');
        }
    }
    
    
    






    public function list()
    {
        $data = TicketBooking::with(['route', 'paymentMethod', 'trip'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function show(string $id)
    {
        $data = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod'])
            ->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketBooking $ticketBooking)
    {
        $data = TicketBooking::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketBookingRequest $request, TicketBooking $ticketBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketBooking $ticketBooking)
    {
        //
    }
}
