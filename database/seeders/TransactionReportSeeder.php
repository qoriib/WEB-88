<?php

namespace Database\Seeders;

use App\Models\TransactionReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransactionReportSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::orders() as $entry) {
            $order = SeederState::$orders[$entry['order_number']] ?? null;
            $customer = SeederState::$customers[$entry['customer_email']] ?? null;

            if (! $order || ! $customer) {
                continue;
            }

            TransactionReport::create([
                'order_id' => $order->id,
                'report_path' => $entry['report']['path'],
                'emailed_to' => $customer->email,
                'emailed_at' => Carbon::parse($entry['report']['emailed_at']),
                'generated_at' => Carbon::parse($entry['report']['generated_at']),
                'meta' => [
                    'period' => 'November 2024',
                    'generated_by' => SeederState::$admin?->name,
                ],
            ]);
        }
    }
}
