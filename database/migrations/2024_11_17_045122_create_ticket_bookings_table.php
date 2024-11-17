<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_bookings', function (Blueprint $table) {
            $table->id(); // ID của vé (primary key)
            $table->unsignedBigInteger('trip_id'); // ID của chuyến đi
            $table->unsignedBigInteger('bus_id'); // ID của xe bus
            $table->unsignedBigInteger('route_id'); // ID của lộ trình
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('payment_method_id');
            $table->string('order_code', 10)->unique();
            $table->string('location_start'); // Địa điểm bắt đầu
            $table->string('id_start_stop'); // ID của điểm dừng bắt đầu
            $table->string('location_end'); // Địa điểm kết thúc
            $table->string('id_end_stop'); // ID của điểm dừng kết thúc
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('note')->nullable(); // Ghi chú, có thể null
            $table->time('time_start');
            $table->date('date'); // Ngày đặt vé
            $table->decimal('total_price', 10, 2); // Tổng giá tiền cho tất cả các ghế
            $table->integer('total_tickets');

            $table->string('status')->default(\App\Models\TicketBooking::PAYMENT_STATUS_UNPAID);

            $table->timestamps(); // Thời gian tạo và cập nhật

            // Khóa ngoại
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_bookings');
    }
};
