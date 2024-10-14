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
        Schema::create('information_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('information_id')->constrained('information')->onDelete('cascade');
            $table->string('image_url'); // Đường dẫn hình ảnh
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_images');
    }
};
