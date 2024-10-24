<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\TicketBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'payment_method_id' => PaymentMethod::factory(), // Tạo mới phương thức thanh toán
            'amount' => $this->faker->randomFloat(2, 100, 1000), // Số tiền thanh toán từ 100 đến 1000
            'payment_status' => $this->faker->randomElement(['Success', 'Failed']), // Trạng thái thanh toán
            'transaction_id' => $this->faker->uuid, // ID giao dịch ngẫu nhiên
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
