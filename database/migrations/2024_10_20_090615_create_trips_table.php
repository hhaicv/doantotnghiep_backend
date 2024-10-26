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
<<<<<<< HEAD
            $table->date('trip_date');
=======
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
            $table->time('departure_time');
            $table->enum('direction', ['outbound', 'return']); // Thêm cột direction
            $table->timestamps();
            $table->softDeletes();
<<<<<<< HEAD
            $table->boolean('is_active')->default(true);
=======
            $table->boolean('is_active')->default(false);
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
        });
    }

<<<<<<< HEAD

    /**
     * Reverse the migrations.
     */
=======
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
