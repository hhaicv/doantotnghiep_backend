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
            'route_name' => $this->faker->text(20), 
            'start_route' => $this->faker->text(20),
            'end_route' => $this->faker->text(20), 
            'execution_time' => $this->faker->numberBetween(1, 200), 
            'base_fare_per_km' => $this->faker->randomFloat(2, 10, 100), 
            'distance_km' => $this->faker->randomFloat(2, 1, 100), 
        ];
    }
}
