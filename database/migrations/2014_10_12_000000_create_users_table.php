<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default(value: User::TYPE_USER); // Vai trò (mặc định user )
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(true); // Trạng thái tài khoản
            $table->rememberToken();
            $table->softDeletes(); // Xóa mềm
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};



