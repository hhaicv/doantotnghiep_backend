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
        Schema::create('seat_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->string('status')->default('available');
            $table->timestamps();
        
            $table->foreign('bus_id')->references('id')->on('bus_seat')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_status');
    }
};
