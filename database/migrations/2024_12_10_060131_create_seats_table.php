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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->foreign('trip_id')->references('id')->on('trip')->onDelete('cascade');
            $table->string('seat_name'); // Tên ghế (ví dụ: A1, B2, ...)
            $table->string('status')->default('available'); // Trạng thái ghế
            $table->date('date'); // Ngày (để mỗi ngày ghế được làm mới)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
