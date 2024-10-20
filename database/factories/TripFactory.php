<?php

namespace Database\Factories;

use App\Models\Bus as ModelsBus;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Bus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_id' => Route::factory(), // Tạo mới tuyến đường
            'bus_id' => ModelsBus::factory(), // Tạo mới xe bus
            'trip_date' => $this->faker->date,
            'departure_time' => $this->faker->time,
            'direction' => $this->faker->randomElement(['outbound', 'return']),
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
