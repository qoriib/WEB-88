<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::orders() as $entry) {
            $customer = SeederState::$customers[$entry['customer_email']] ?? null;
            $store = SeederState::$stores[$entry['store_slug']] ?? null;
            $cart = SeederState::$carts[$entry['order_number']] ?? null;

            if (! $customer || ! $store || ! $cart) {
                continue;
            }

            $subtotal = $this->calculateSubtotal($entry['items']);
            $order = Order::create([
                'order_number' => $entry['order_number'],
                'user_id' => $customer->id,
                'store_id' => $store->id,
                'cart_id' => $cart->id,
                'status' => $entry['status'],
                'payment_method' => $entry['payment_method'],
                'subtotal' => $subtotal,
                'shipping_cost' => $entry['shipping_cost'],
                'total_amount' => $subtotal + $entry['shipping_cost'],
                'city' => $entry['city'],
                'shipping_address' => $entry['shipping_address'],
                'notes' => $entry['notes'],
                'placed_at' => Carbon::parse($entry['placed_at']),
                'completed_at' => $entry['completed_at'] ? Carbon::parse($entry['completed_at']) : null,
            ]);

            SeederState::$orders[$entry['order_number']] = $order;
        }
    }

    private function calculateSubtotal(array $items): float
    {
        $subtotal = 0;

        foreach ($items as $item) {
            $product = SeederState::$products[$item['slug']] ?? null;
            if (! $product) {
                continue;
            }

            $subtotal += (float) $product->price * $item['quantity'];
        }

        return $subtotal;
    }
}
