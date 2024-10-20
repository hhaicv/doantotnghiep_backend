<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_name' => $this->faker->city . ' - ' . $this->faker->city,
            'start_route' => $this->faker->city,
            'end_route' => $this->faker->city,
            'execution_time' => $this->faker->time,
            'base_fare_per_km' => $this->faker->randomFloat(2, 10, 100), // Giá từ 10-100
            'distance_km' => $this->faker->randomFloat(2, 50, 500), // Khoảng cách từ 50-500 km
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
