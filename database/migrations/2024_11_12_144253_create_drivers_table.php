<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Tên tài xế
            $table->date('date_of_birth');              // Ngày tháng năm sinh
            $table->string('email')->unique();          // Email
            $table->string('password');                 // Mật khẩu
            $table->string('phone')->nullable();        // Số điện thoại
            $table->string('license_number')->nullable(); // Số bằng lái xe
            $table->string('address')->nullable();      // Địa chỉ
            $table->string('profile_image')->nullable(); // Đường dẫn ảnh đại diện
            $table->boolean('is_active')->default(0); //trạng thái
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
