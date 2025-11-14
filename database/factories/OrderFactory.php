<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 250000, 15000000);
        $shipping = fake()->randomFloat(2, 15000, 75000);
        $total = $subtotal + $shipping;
        $orderNumber = 'OSS-' . now()->format('Ymd') . '-' . fake()->unique()->numberBetween(101, 999);

        return [
            'order_number' => $orderNumber,
            'user_id' => User::factory()->customer(),
            'store_id' => Store::factory(),
            'cart_id' => Cart::factory(),
            'status' => fake()->randomElement(['pending', 'paid', 'processing', 'completed']),
            'payment_method' => fake()->randomElement(['prepaid', 'cod']),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total_amount' => $total,
            'city' => fake('id_ID')->city(),
            'shipping_address' => fake('id_ID')->streetAddress(),
            'notes' => fake()->optional()->sentence(),
            'placed_at' => now()->subDays(fake()->numberBetween(1, 20)),
            'completed_at' => now()->subDays(fake()->numberBetween(0, 5)),
        ];
    }
}
