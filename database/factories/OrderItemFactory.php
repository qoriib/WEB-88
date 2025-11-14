<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 3);
        $unitPrice = fake()->randomFloat(2, 200000, 3000000);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'product_name' => fake()->randomElement([
                'Tensimeter Omron HEM-7156',
                'Pulse Oximeter Beurer PO30',
                'Nebulizer Omron NE-C101',
                'Kursi Roda GEA FS852',
            ]),
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'subtotal' => $quantity * $unitPrice,
        ];
    }
}
