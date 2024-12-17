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
        Schema::create('cancles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_booking_id');
            $table->string('order_code', 15);
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('account_number', '50');
            $table->string('bank');
            $table->text('reason');
            $table->foreign('ticket_booking_id')->references('id')->on('ticket_bookings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancles');
    }
};
