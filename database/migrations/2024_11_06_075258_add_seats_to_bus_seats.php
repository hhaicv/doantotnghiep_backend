<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bus_seats', function (Blueprint $table) {
            DB::table('bus_seats')->insert([
                ['bus_id' => 1, 'seat_name' => 'A7'],
                ['bus_id' => 1, 'seat_name' => 'A8'],
                ['bus_id' => 1, 'seat_name' => 'A9'],
                ['bus_id' => 1, 'seat_name' => 'A10'],
                // thêm các ghế khác tại đây
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bus_seats', function (Blueprint $table) {
            DB::table('bus_seats')->where('bus_id', 1)->whereIn('seat_name', ['A7', 'A8', 'A9', 'A10'])->delete();
        });
    }
};
