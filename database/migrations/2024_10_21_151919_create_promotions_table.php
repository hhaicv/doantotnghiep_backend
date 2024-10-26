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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('description');
            $table->decimal('discount', 8, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('new_customer_only')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade'); 
            $table->foreignId('bus_type_id')->constrained('buses')->onDelete('cascade'); 
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
