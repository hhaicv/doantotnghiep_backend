<?php

namespace App\Http\Controllers\API;

use App\Events\OrderTicket;
use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Stop;
use App\Models\TicketDetail;
use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Str;

class StopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
        return response()->json([
            'methods' => $methods,
            'seatsStatus' => $seatsStatus,
            'seatCount' => $seatCount,
        ]);
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
            $redirectUrl = route('momo_return');
            $ipnUrl = route('momo_return');
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
            return response()->json([
                'payUrl' => $jsonResult['payUrl']
            ]);
        } else if ($request->has('payment_method_id') && $request->payment_method_id == 3) {
            // VNPAY payment logic
            $endpoint = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";  // URL thanh toán VNPay
            $vnp_TmnCode = '6H9JFR7W';  // Mã Merchant của bạn
            $vnp_HashSecret = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  // Mã bí mật của bạn

            // Các tham số thanh toán
            $vnp_Amount = $request->total_price * 100;  // Số tiền thanh toán (VND, nhân với 100)
            $vnp_OrderInfo = "Thanh toán qua VNpay";
            $vnp_OrderType = 'billpayment';
            $vnp_ReturnUrl = route('vnpay_return');  // URL trả về sau khi thanh toán
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
                if ($value != "") {
                    $hashString .= urlencode($key) . "=" . urlencode($value) . "&";
                }
            }
            // Loại bỏ dấu "&" cuối chuỗi
            $hashString = rtrim($hashString, '&');

            // Tạo chữ ký bảo mật (HMAC SHA512)
            $vnp_SecureHash = hash_hmac('sha512', $hashString, $vnp_HashSecret);

            $vnp_Data['vnp_SecureHash'] = $vnp_SecureHash;  // Thêm chữ ký vào tham số

            // Lưu thông tin đơn hàng vào cơ sở dữ liệu
            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = $vnp_TxnRef;
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;

            // Thiết lập status của TicketBooking dựa trên payment_method_id
            $ticketBookingData['status'] = TicketBooking::PAYMENT_STATUS_UNPAID;

            $ticketBooking = TicketBooking::create($ticketBookingData);

            // Lưu thông tin chi tiết vé
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

            return response()->json([
                'status' => 'success',
                'redirect_url' => $vnp_Url
            ]);
        }
    }
    public function bill(Request $request)
    {
        // Lấy ID đơn hàng từ query string
        $orderId = $request->query('order_id');

        // Tìm đơn hàng dựa vào ID
        $ticketBooking = TicketBooking::with(['trip', 'bus.driver', 'route', 'user', 'paymentMethod', 'ticketDetails'])
            ->find($orderId);

        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$ticketBooking) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng.'], 404);
        }

        // Lấy tên điểm bắt đầu và điểm kết thúc từ bảng stops
        $startStop = Stop::find($ticketBooking->id_start_stop);
        $endStop = Stop::find($ticketBooking->id_end_stop);

        // Chuẩn bị dữ liệu cần trả về
        $driver = $ticketBooking->bus->driver;
        $ticketData = [
            'name' => $ticketBooking->name,
            'phone' => $ticketBooking->phone,
            'email' => $ticketBooking->email,
            'driver_name' => $driver->name ?? null,
            'driver_phone' => $driver->phone ?? null,
            'license_plate' => $ticketBooking->bus->license_plate,
            'route_name' => $ticketBooking->route->route_name,
            'start_point' => $startStop->stop_name ?? $ticketBooking->location_start, // Tên điểm bắt đầu
            'end_point' => $endStop->stop_name ?? $ticketBooking->location_end,       // Tên điểm kết thúc
            'time_start' => $ticketBooking->trip->time_start ?? null,            // Thời gian khởi hành
            'point_up' => $ticketBooking->location_start,
            'point_down' => $ticketBooking->location_end,
            'date_start' => $ticketBooking->date,
            'booking_date' => $ticketBooking->created_at->format('Y-m-d'),
            'name_seat' => $ticketBooking->ticketDetails->pluck('name_seat')->toArray(),
            'note' => $ticketBooking->note,
            'ticket_price' => $ticketBooking->total_price,
            'total_price' => $ticketBooking->total_price,
            'status' => $ticketBooking->status,
            'order_code' => $ticketBooking->order_code,
            'ticket_codes' => $ticketBooking->ticketDetails->pluck('ticket_code')->toArray(),
        ];

        // Trả về dữ liệu đơn hàng
        return response()->json([
            'status' => 'success',
            'message' => 'Dữ liệu đơn hàng đã được tải.',
            'data' => $ticketData,
        ]);
    }
    public function faile()
    {
        echo "thanh toán thất bại";
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
        $resultCode = $request->input('resultCode');  // Mã phản hồi của MoMo

        // Tìm đơn hàng theo order ID
        $ticketBooking = TicketBooking::where('order_code', $orderId)->first();

        if (!$ticketBooking) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
        }
        // Cập nhật trạng thái thanh toán dựa trên resultCode từ MoMo
        if ($resultCode == 0) {
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID; // Thanh toán thành công
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

            // Cập nhật trạng thái ghế từ 'lock' thành 'booked'
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'booked';
                $ticketDetail->save();
            }
            event(new OrderTicket($ticketBooking));
            return redirect()->to(env('FRONTEND_URL') . '/bill?' . http_build_query([
                'order_id' => $ticketBooking->id,
                'status' => 'success',
                'response_code' => $request->resultCode,
                'message' => 'Thanh toán thành công'
            ]));
        } else {
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED; // Thanh toán thất bại
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->delete();
            }
            return redirect()->route('faile')->with('message', 'Thanh toán thất bại.');
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
            // Loại bỏ các giá trị rỗng và tham số không phải là phần của chữ ký (ví dụ: vnp_SecureHash)
            if ($value != "" && $key != "vnp_SecureHash") {
                $hashString .= urlencode($key) . "=" . urlencode($value) . "&";
            }
        }

        // Loại bỏ dấu "&" cuối chuỗi
        $hashString = rtrim($hashString, '&');

        // Tính toán lại chữ ký HMAC SHA512
        $secretKey = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  // Mã bí mật của bạn
        $calculatedHash = hash_hmac('sha512', $hashString, $secretKey);

        // Kiểm tra tính hợp lệ của chữ ký
        if ($calculatedHash !== $vnpaySecureHash) {
            return response()->json(['status' => 'error', 'message' => 'Chữ ký không hợp lệ.'], 400);
        }

        // Lấy mã đơn hàng từ VNPay
        $orderId = trim($vnpayResponse['vnp_TxnRef']);  // Loại bỏ khoảng trắng

        // Tìm kiếm đơn hàng từ cơ sở dữ liệu
        $ticketBooking = TicketBooking::where('order_code', $orderId)->first();

        // Nếu không tìm thấy đơn hàng, trả về thông báo lỗi
        if (!$ticketBooking) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng. Vui lòng kiểm tra lại hoặc liên hệ hỗ trợ.'], 404);
        }

        // Kiểm tra trạng thái thanh toán
        $paymentStatus = $vnpayResponse['vnp_ResponseCode'];  // Mã phản hồi của VNPay

        if ($paymentStatus == '00') {
            // Thanh toán thành công
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID;
            $ticketBooking->save();
            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();

            // Cập nhật trạng thái ghế từ 'lock' thành 'booked'
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->status = 'booked';
                $ticketDetail->save();
            }
            event(new OrderTicket($ticketBooking));
            return redirect()->to(env('FRONTEND_URL') . '/bill?' . http_build_query([
                'order_id' => $ticketBooking->id,
                'status' => 'success',
                'response_code' => $request->vnp_ResponseCode,
                'message' => 'Thanh toán thành công'
            ]));
        } else {
            // Thanh toán thất bại
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED;
            $ticketBooking->save();

            $ticketDetails = TicketDetail::where('ticket_booking_id', $ticketBooking->id)->get();
            // Xóa các bản ghi tương ứng
            foreach ($ticketDetails as $ticketDetail) {
                $ticketDetail->delete();
            }
        }
    }
    public function show($order_code)
    {
        // Lấy đơn hàng theo mã order_code
        $ticketBooking = TicketBooking::with(['trip', 'bus.driver', 'route', 'user', 'paymentMethod', 'ticketDetails'])
            ->where('order_code', $order_code)
            ->first();

        // Kiểm tra nếu không tìm thấy
        if (!$ticketBooking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy đơn hàng với mã: ' . $order_code,
            ], 404);
        }
        // Chuẩn bị dữ liệu trả về
        $data = [
            'id' => $ticketBooking->id,
            'name' => $ticketBooking->name,
            'phone' => $ticketBooking->phone,
            'email' => $ticketBooking->email,
            'driver_name' => $ticketBooking->bus->driver->name ?? null,
            'driver_phone' => $ticketBooking->bus->driver->phone ?? null,
            'license_plate' => $ticketBooking->bus->license_plate ?? null,
            'route_name' => $ticketBooking->route->route_name ?? null,
            'start_point' => $ticketBooking->location_start,
            'end_point' => $ticketBooking->location_end,
            'time_start' => $ticketBooking->trip->time_start ?? null,
            'date_start' => $ticketBooking->date ?? null,
            'ticket_details' => $ticketBooking->ticketDetails->map(function ($detail) {
                return [
                    'ticket_code' => $detail->ticket_code,
                    'name_seat' => $detail->name_seat,
                ];
            }),
            'total_price' => $ticketBooking->total_price,
            'status' => $ticketBooking->status,
            'order_code' => $ticketBooking->order_code,
            'created_at' => $ticketBooking->created_at->format('Y-m-d H:i:s'),
        ];

        // Trả về response
        return response()->json([
            'status' => 'success',
            'message' => 'Dữ liệu đơn hàng đã được tải.',
            'data' => $data,
        ]);
    }



    public function check(Request $request)
    {
        // Validate yêu cầu đầu vào
        $request->validate([
            'ticket_code' => 'required|string',
        ]);

        // Lấy thông tin TicketDetail dựa vào ticket_code
        $ticketDetail = TicketDetail::where('ticket_code', $request->ticket_code)->first();

        // Kiểm tra nếu không tìm thấy TicketDetail
        if (!$ticketDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy vé với mã: ' . $request->ticket_code,
            ], 404);
        }

        // Lấy thông tin TicketBooking liên quan
        $ticketBooking = TicketBooking::with(['trip', 'bus.driver', 'route', 'user', 'paymentMethod'])
            ->find($ticketDetail->ticket_booking_id);

        // Kiểm tra nếu không tìm thấy TicketBooking
        if (!$ticketBooking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy đơn hàng liên quan đến vé này.',
            ], 404);
        }

        $startStop = Stop::find($ticketBooking->id_start_stop);
        $endStop = Stop::find($ticketBooking->id_end_stop);

        // Chuẩn bị dữ liệu trả về
        $data = [
            'phone' => $ticketBooking->phone,
            'name' => $ticketBooking->name,
            'email' => $ticketBooking->email,
            'route_name' => $ticketBooking->route->route_name ?? null,
            'start_point' => $startStop->stop_name ?? $ticketBooking->location_start, // Tên điểm bắt đầu
            'end_point' => $endStop->stop_name ?? $ticketBooking->location_end,       // Tên điểm kết thúc
            'time_start' => $ticketBooking->trip->time_start ?? null,
            'date_start' => $ticketBooking->date,
            'total_price' => $ticketBooking->total_price,
            'status' => $ticketBooking->status,
            'ticket_code' => $ticketDetail->ticket_code,
            'seat' => $ticketDetail->name_seat,

        ];
        // Trả về response
        return response()->json([
            'status' => 'success',
            'message' => 'Dữ liệu đơn hàng đã được tải.',
            'data' => $data,
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
