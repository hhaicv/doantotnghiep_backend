<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('ticket_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('start_stop_id');
            $table->unsignedBigInteger('end_stop_id');
            $table->unsignedBigInteger('trip_id');
            $table->enum('status', ['Booked', 'Cancelled']);
            $table->enum('payment_status', ['Pending', 'Paid', 'Failed']);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('start_stop_id')->references('id')->on('stops')->onDelete('cascade');
            $table->foreign('end_stop_id')->references('id')->on('stops')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_bookings');
    }
};
