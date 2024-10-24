<?php

namespace Database\Factories;

use App\Models\Bus; // Import model Bus
use App\Models\BusSeat; // Import model BusSeat
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusSeat>
 */
class BusSeatFactory extends Factory
{
    protected $model = BusSeat::class; // Đặt model liên quan ở đây

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bus_id' => Bus::factory(), // Tạo mới xe bus
            'seat_name' => $this->faker->randomElement(range('A', 'Z')), // Ghế từ A-Z
            'is_available' => true, // Mặc định ghế có sẵn
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

