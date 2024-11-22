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
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('code');
            $table->integer('discount');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->string('count');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('user_id');
            // $table->boolean('new_customer_only')->default(0);
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
