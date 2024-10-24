<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stage>
 */
class StageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_id' => Route::factory(), // Tạo mới Route khi chạy factory
            'start_stop_id' => Stop::factory(), // Tạo mới điểm dừng bắt đầu
            'end_stop_id' => Stop::factory(), // Tạo mới điểm dừng kết thúc
            'stage_order' => $this->faker->numberBetween(1, 10), // Thứ tự chặng
            'fare' => $this->faker->randomFloat(2, 10, 200), // Giá vé cho chặng
            'distance_km' => $this->faker->randomFloat(2, 10, 50), // Khoảng cách của chặng
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
