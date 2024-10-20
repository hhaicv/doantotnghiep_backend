<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketBooking>
 */
class TicketBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Tạo mới user
            'route_id' => Route::factory(), // Tạo mới tuyến đường
            'start_stop_id' => Stop::factory(), // Điểm lên xe
            'end_stop_id' => Stop::factory(), // Điểm xuống xe
            'trip_id' => Trip::factory(), // Chuyến xe
            'status' => 'Booked',
            'payment_status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
