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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->unsignedBigInteger('start_route_id');
            $table->unsignedBigInteger('end_route_id');
            $table->integer('cycle');
            $table->decimal('route_price', 10, 2);
            $table->decimal('length', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('start_route_id')->references('id')->on('stops')->onDelete('cascade');
            $table->foreign('end_route_id')->references('id')->on('stops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
