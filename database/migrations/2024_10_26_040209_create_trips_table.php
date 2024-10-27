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
     Schema::create('trips', function (Blueprint $table) {
         $table->id();
         $table->unsignedBigInteger('route_id');
         $table->unsignedBigInteger('bus_id');
         $table->time('departure_time');
         $table->enum('direction', ['outbound', 'return']); // Thêm cột direction
         $table->timestamps();
         $table->softDeletes();
         $table->boolean('is_active')->default(false);
         $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
         $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
     });
 }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
