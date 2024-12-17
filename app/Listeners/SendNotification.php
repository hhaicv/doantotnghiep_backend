<?php

namespace App\Listeners;


use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Events\OrderTicket;
use App\Models\Stop;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }
    public function handle(OrderTicket $event): void
    {
        $ticketBooking = $event->ticket;
        $startStop = Stop::find($ticketBooking->id_start_stop);
        $endStop = Stop::find($ticketBooking->id_end_stop);

        $driver = $ticketBooking->bus->driver;

        // Dữ liệu chung
        $data = [
            'name' => $ticketBooking->name,
            'phone' => $ticketBooking->phone,
            'email' => $ticketBooking->email,
            'driver_name' => $driver->name ?? null,
            'driver_phone' => $driver->phone ?? null,
            'license_plate' => $ticketBooking->bus->license_plate,
            'route_name' => $ticketBooking->route->route_name,
            'start_point' => $startStop->stop_name ?? $ticketBooking->location_start,
            'end_point' => $endStop->stop_name ?? $ticketBooking->location_end,
            'time_start' => $ticketBooking->trip->time_start ?? null,
            'point_up' => $ticketBooking->location_start,
            'point_down' => $ticketBooking->location_end,
            'date_start' => $ticketBooking->date,
            'payment_method' => $ticketBooking->paymentMethod->name,
            'booking_date' => $ticketBooking->created_at->format('Y-m-d'),
            'note' => $ticketBooking->note,
            'ticket_price' => $ticketBooking->total_price,
            'total_price' => $ticketBooking->total_price,
            'status' => $ticketBooking->status,
            'order_code' => $ticketBooking->order_code,
        ];

        // Sử dụng map() để tạo một collection mới với qr_code_path
        $ticketDetails = $ticketBooking->ticketDetails->map(function ($ticketDetail) use ($ticketBooking, $startStop, $endStop, &$qrPaths) {
            // Dữ liệu cho mã QR
            $qrData = "Mã đơn hàng: {$ticketBooking->order_code}, Mã vé: {$ticketDetail['ticket_code']}, Vị trí ghế: {$ticketDetail['name_seat']},
        Tuyến đường: {$ticketDetail['route_name']}, Chặng: {$ticketDetail['start_point']} - {$ticketDetail['end_point']}";

            $qrCode = new QrCode($qrData);
            $writer = new PngWriter();
            $fileName = "qr_code_{$ticketDetail['ticket_code']}.png";
            $path = storage_path("app/public/qr_codes/{$fileName}");

            // Lưu mã QR vào file
            $writer->write($qrCode)->saveToFile($path);

            // Thêm qr_code_path vào phần tử ticketDetail và trả lại phần tử đã thay đổi
            $ticketDetail['qr_code_path'] = $path;

            // Thêm vào danh sách qrPaths
            $qrPaths[] = $path;

            return $ticketDetail;
        });

        // Gửi email với thông tin và mã QR
        try {
            Mail::send('mail', ['data' => $data, 'ticketDetails' => $ticketDetails], function ($message) use ($data, $qrPaths) {
                $message->to($data['email'], $data['name'])
                    ->subject('Thông tin đơn hàng');
                // Đính kèm mã QR vào email
                foreach ($qrPaths as $qrPath) {
                    $message->attach($qrPath, [
                        'as' => basename($qrPath),
                        'mime' => 'image/png',
                    ]);
                }
            });

            // Log khi gửi email thành công
            Log::info("Email đã được gửi đến: {$data['email']}.");
        } catch (\Exception $e) {
            Log::error("Lỗi khi gửi email: " . $e->getMessage(), [
                'exception' => $e,
                'data' => $data,
                'ticketDetails' => $ticketDetails,
            ]);
        }
    }
}
