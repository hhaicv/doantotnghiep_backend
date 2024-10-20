<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_bus' => $this->faker->company, // Tên xe
            'model' => $this->faker->word, // Mẫu xe
            'fare_multiplier' => $this->faker->randomFloat(2, 1, 2), // Hệ số giá vé từ 1 đến 2
            'license_plate' => strtoupper($this->faker->bothify('??-####')), // Biển số ngẫu nhiên
            'total_seats' => $this->faker->numberBetween(20, 50), // Số ghế từ 20-50
            'image' => $this->faker->imageUrl(640, 480, 'transport'), // Ảnh xe
            'phone' => $this->faker->numerify('0#########'), // Bắt đầu bằng 0 và theo sau là 9 chữ số ngẫu nhiên
            'description' => $this->faker->paragraph, // Mô tả
            'is_active' => $this->faker->boolean, // Trạng thái hoạt động
            'created_at' => now(), // Thời gian tạo
            'updated_at' => now(), // Thời gian cập nhật
        ];
    }
}
