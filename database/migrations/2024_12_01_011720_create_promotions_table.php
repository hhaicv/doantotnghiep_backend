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
            $table->decimal('discount', 8, 2); // Giảm giá
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->integer('count'); // Số lượng
            $table->string('status')->default('open'); // Trạng thái mặc định là 'open'
            $table->unsignedBigInteger('route_id'); // Khóa ngoại đến bảng routes
            $table->unsignedBigInteger('user_id'); // Khóa ngoại đến bảng users
            $table->unsignedBigInteger('promotion_category_id'); // Khóa ngoại đến bảng promotion_categories
            
            // Khai báo khóa ngoại
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('promotion_category_id')->references('id')->on('promotion_categories')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes(); 
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
