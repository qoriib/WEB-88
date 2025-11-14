<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::orders() as $entry) {
            $order = SeederState::$orders[$entry['order_number']] ?? null;

            if (! $order) {
                continue;
            }

            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'method' => $entry['payment_method'],
                'status' => $entry['payment']['status'],
                'transaction_reference' => $entry['payment']['transaction_reference'],
                'meta' => $entry['payment']['meta'],
                'paid_at' => $entry['payment']['paid_at'] ? Carbon::parse($entry['payment']['paid_at']) : null,
            ]);
        }
    }
}
