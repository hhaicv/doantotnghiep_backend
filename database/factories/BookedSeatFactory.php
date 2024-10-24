<?php

namespace Database\Factories;

use App\Models\Bus as ModelsBus;
use App\Models\TicketBooking;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Bus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookedSeat>
 */
class BookedSeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => TicketBooking::factory(), // Tạo mới booking
            'bus_id' => ModelsBus::factory(), // Tạo mới bus
            'trip_id' => Trip::factory(), // Tạo mới chuyến đi
            'seat_name' => $this->faker->randomElement(range('A', 'Z')), // Ghế từ A-Z
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
