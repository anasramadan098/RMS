<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 200);
        $taxAmount = $subtotal * 0.15; // 15% tax
        $deliveryFee = fake()->randomElement([0, 5, 10, 15]);
        $discountAmount = fake()->randomFloat(2, 0, $subtotal * 0.2);
        $totalAmount = $subtotal + $taxAmount + $deliveryFee - $discountAmount;

        return [
            'user_id' => User::factory(),
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->phoneNumber(),
            'customer_address' => fake()->address(),
            'status' => fake()->randomElement(['pending', 'preparing', 'ready', 'delivered', 'cancelled']),
            'order_type' => fake()->randomElement(['dine_in', 'takeaway', 'delivery']),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'delivery_fee' => $deliveryFee,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'notes' => fake()->optional()->sentence(),
            'prepared_at' => fake()->optional()->dateTimeBetween('-1 week', 'now'),
            'delivered_at' => fake()->optional()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
