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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->string('stop_name');
            $table->unsignedBigInteger('parent_id')->nullable(); // Cho phép giá trị NULL
            $table->decimal('longitude', 10, 2);
            $table->decimal('latitude', 10, 2);
            $table->string('image');
            $table->foreign('parent_id')->references('id')->on('stops')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};