<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    use HasFactory;

    const PAYMENT_STATUSES = [
        'unpaid' => 'Chưa thanh toán',
        'paid' => 'Đã thanh toán',
        'failed' => 'Thất bại',
        'overdue' => 'Quá hạn',
        'refunded' => 'Hoàn tiền'
    ];


    const PAYMENT_STATUS_UNPAID = 'unpaid'; // chưa thành công
    const PAYMENT_STATUS_PAID = 'paid'; // thành công
    const PAYMENT_STATUS_FAILED = 'failed'; // Hủy lỗi
    const PAYMENT_STATUS_OVERDUE = 'overdue'; // quá hạn
    const PAYMENT_STATUS_REFUNDED = 'refunded'; // Trả vé

    protected $fillable = [
        "trip_id",
        "bus_id",
        "route_id",
        "user_id",
        "name",
        "phone",
        "email",
        "code_voucher",
        "discount",
        "payment_method_id",
        "order_code",
        "location_start",
        "id_start_stop",
        "location_end",
        "id_end_stop",
        "note",
        "time_start",
        "date",
        "status",
        "total_price",
        "total_tickets"
    ];


    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    // Định nghĩa quan hệ với Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }


    // Định nghĩa quan hệ với Route
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    // Định nghĩa quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Định nghĩa quan hệ với PaymentMethod
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function ticketDetails()
    {
        return $this->hasMany(TicketDetail::class, 'ticket_booking_id');
    }

    public function cancel()
    {
        return $this->hasOne(Cancle::class, 'ticket_booking_id');
    }
}
