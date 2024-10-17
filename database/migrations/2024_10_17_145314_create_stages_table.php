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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('start_stop_id');
            $table->unsignedBigInteger('end_stop_id');
            $table->integer('stage_order');
            $table->decimal('fare', 10, 2);
            $table->decimal('distance_km', 10, 2);
            $table->timestamps();
            $table->boolean('is_active')->default(true);
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('start_stop_id')->references('id')->on('stops')->onDelete('cascade');
            $table->foreign('end_stop_id')->references('id')->on('stops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
