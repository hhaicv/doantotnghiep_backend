<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BookedSeat;
use App\Models\Bus as ModelsBus;
use App\Models\BusSeat;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Stage;
use App\Models\Stop;
use App\Models\TicketBooking;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::factory(10)->create();
        ModelsBus::factory()->count(10)->create(); // Sử dụng alias để tạo bus
        $buses = ModelsBus::factory()->count(10)->create();
        // Tạo ghế cho mỗi xe bus
        foreach ($buses as $bus) {
            BusSeat::factory()->count($bus->total_seats)->create(['bus_id' => $bus->id]);
        }
        Stop::factory(10)->create();
        Stage::factory(10)->create();
        Trip::factory(10)->create();
        TicketBooking::factory(10)->create();
        BookedSeat::factory(10)->create();
        PaymentMethod::factory(2)->create();
        Payment::factory(10)->create();
    }
}
