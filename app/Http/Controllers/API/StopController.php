<?php

namespace App\Http\Controllers\API;

use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\UpdateTicketBookingRequest;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\TicketDetail;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
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

        // Get all available payment methods
        $methods = PaymentMethod::query()->get();

        // Retrieve the trip and its bus information
        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        // Get booked seats for the specified trip and date
        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        // Build seats status array
        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }

        // Prepare data for JSON response
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
            return redirect($jsonResult['payUrl']);
        } else if ($request->has('payment_method_id') && $request->payment_method_id == 3) { // VNPay payment method ID là 3
            $vnp_TmnCode = '6H9JFR7W';  // Mã Merchant của bạn
            $vnp_HashSecret = 'WIGT3LVWWHQZVTK33YR4OHCG5CWPK8R0';  
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL thanh toán VNPay (có thể thay đổi nếu VNPay thay đổi sandbox)

            $orderInfo = "Thanh toán qua VNPay";
            $amount = $request->total_price * 100; // VNPay yêu cầu giá trị thanh toán phải nhân với 100 (đơn vị đồng)
            $orderId = time();
            $orderType = 'billpayment';
            $locale = 'vn';  // hoặc 'en' tùy thuộc vào ngôn ngữ bạn muốn
            $returnUrl = route('vnpay_return');  // URL trả về sau khi thanh toán

            // Cấu hình các tham số cần thiết
            $vnp_Params = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_Currency" => "VND",
                "vnp_OrderInfo" => $orderInfo,
                "vnp_OrderType" => $orderType,
                "vnp_Locale" => $locale,
                "vnp_ReturnUrl" => $returnUrl,
                "vnp_TxnRef" => $orderId,  // Mã giao dịch duy nhất
            ];

            // Tạo chữ ký (signature)
            ksort($vnp_Params);
            $query = "";
            foreach ($vnp_Params as $key => $value) {
                $query .= $key . "=" . $value . "&";
            }
            $query = rtrim($query, "&");

            $vnp_SecureHash = hash_hmac('sha256', $query, $vnp_HashSecret);
            $vnp_Params['vnp_SecureHash'] = $vnp_SecureHash;

            // Chuyển tham số thành chuỗi truy vấn URL
            $vnp_Url .= "?" . http_build_query($vnp_Params);

            // Lưu thông tin đơn hàng và trả về URL VNPay
            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = $orderId;
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;
            $ticketBookingData['status'] = TicketBooking::PAYMENT_STATUS_UNPAID;  // Trạng thái thanh toán chưa hoàn tất

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

            return redirect($vnp_Url);  // Chuyển hướng người dùng tới VNPay để thanh toánelse {
            $response = DB::transaction(function () use ($request) {
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
            });

            return response()->json([
                'status' => 'success',
                'data' => $response
            ], 201);
        }
    }

    public function thanks()
    {
        echo "thanh toán thành công";
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
            return redirect()->route('thanks')->with('message', 'Thanh toán thành công!');
        } else {
            $ticketBooking->status = TicketBooking::PAYMENT_STATUS_FAILED; // Thanh toán thất bại
            $ticketBooking->save();
            return redirect()->route('faile')->with('message', 'Thanh toán thất bại.');
        }
    }
    public function vnpay_return(Request $request)
    {
        $vnp_TmnCode = 'YOUR_VNP_TMN_CODE';  // TmnCode từ VNPay
        $vnp_HashSecret = 'YOUR_VNP_HASH_SECRET'; // Secret Key từ VNPay

        $vnp_ResponseCode = $request->input('vnp_ResponseCode');  // Mã phản hồi từ VNPay
        $vnp_TxnRef = $request->input('vnp_TxnRef');  // Mã giao dịch
        $vnp_SecureHash = $request->input('vnp_SecureHash');  // Chữ ký bảo mật

        // Kiểm tra tính hợp lệ của chữ ký
        $vnp_Params = $request->except('vnp_SecureHash');
        ksort($vnp_Params);
        $query = "";
        foreach ($vnp_Params as $key => $value) {
            $query .= $key . "=" . $value . "&";
        }
        $query = rtrim($query, "&");

        // Tạo chữ ký so với chữ ký trả về
        $secureHash = hash_hmac('sha256', $query, $vnp_HashSecret);

        // Kiểm tra kết quả thanh toán
        if ($secureHash == $vnp_SecureHash && $vnp_ResponseCode == '00') {
            $ticketBooking = TicketBooking::where('order_code', $vnp_TxnRef)->first();
            if ($ticketBooking) {
                $ticketBooking->status = TicketBooking::PAYMENT_STATUS_PAID;
                $ticketBooking->save();
                return redirect()->route('thanks')->with('message', 'Thanh toán thành công!');
            }
        }

        return redirect()->route('fail')->with('message', 'Thanh toán thất bại!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
