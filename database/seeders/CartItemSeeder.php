<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::orders() as $order) {
            $cart = SeederState::$carts[$order['order_number']] ?? null;

            if (! $cart) {
                continue;
            }

            foreach ($order['items'] as $item) {
                $product = SeederState::$products[$item['slug']] ?? null;
                if (! $product) {
                    continue;
                }

                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);
            }
        }
    }
}
