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
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id(); // ID của bản ghi (primary key)
            $table->string('ticket_code', 8)->unique(); // Mã vé ngẫu nhiên 8 ký tự
            $table->unsignedBigInteger('ticket_booking_id'); // ID của vé (foreign key từ ticket_bookings)
            $table->string('name_seat'); // Số ghế được đặt
            $table->decimal('price', 10, 2); // Giá vé cho ghế
            $table->enum('status', ['available', 'selected','booked', 'lock'])->default('available');
            $table->boolean('is_active')->default(false);
            $table->timestamps(); // Thời gian tạo và cập nhật

            // Khóa ngoại
            $table->foreign('ticket_booking_id')->references('id')->on('ticket_bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_details');
    }
};
