<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::orders() as $order) {
            $customer = SeederState::$customers[$order['customer_email']] ?? null;
            if (! $customer) {
                continue;
            }

            $totals = $this->calculateTotals($order['items']);

            $cart = Cart::create([
                'user_id' => $customer->id,
                'status' => 'checked_out',
                'total_items' => $totals['items'],
                'total_amount' => $totals['subtotal'],
            ]);

            SeederState::$carts[$order['order_number']] = $cart;
        }
    }

    private function calculateTotals(array $items): array
    {
        $subtotal = 0;
        $count = 0;

        foreach ($items as $item) {
            $product = SeederState::$products[$item['slug']] ?? null;
            if (! $product) {
                continue;
            }

            $subtotal += (float) $product->price * $item['quantity'];
            $count += $item['quantity'];
        }

        return [
            'items' => $count,
            'subtotal' => $subtotal,
        ];
    }
}
