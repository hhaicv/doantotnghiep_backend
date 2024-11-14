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
        } else {
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
