<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Thêm để sử dụng DB

return new class extends Migration
{
    /**
     * Chạy migration để tạo bảng roles.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name_role');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        // Chèn dữ liệu vào bảng roles
        DB::table('roles')->insert([
            ['name_role' => 'admin', 'description' => 'Quản trị viên', 'created_at' => now()],
            ['name_role' => 'user', 'description' => 'Người dùng', 'created_at' => now()],
        ]);
    }

    /**
     * Phục hồi lại migration, xóa bảng roles.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
