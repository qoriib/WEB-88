<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        $itemCount = fake()->numberBetween(1, 4);
        $amount = fake()->randomFloat(2, 200000, 4500000);

        return [
            'user_id' => User::factory()->customer(),
            'status' => fake()->randomElement(['active', 'checked_out']),
            'total_items' => $itemCount,
            'total_amount' => $amount,
        ];
    }
}
