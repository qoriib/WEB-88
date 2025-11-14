<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'confirmed', 'failed']);
        $method = fake()->randomElement(['prepaid', 'cod']);
        $paidAt = $status === 'confirmed' ? now()->subDays(fake()->numberBetween(0, 5)) : null;

        return [
            'order_id' => Order::factory(),
            'amount' => fake()->randomFloat(2, 200000, 20000000),
            'method' => $method,
            'status' => $status,
            'transaction_reference' => $method === 'prepaid' ? 'INV-' . fake()->unique()->numberBetween(100000, 999999) : null,
            'meta' => $method === 'prepaid' ? ['channel' => fake()->randomElement(['BCA Virtual Account', 'Mandiri Virtual Account', 'OVO'])] : null,
            'paid_at' => $paidAt,
        ];
    }
}
