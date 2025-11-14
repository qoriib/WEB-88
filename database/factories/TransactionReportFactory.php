<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\TransactionReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransactionReport>
 */
class TransactionReportFactory extends Factory
{
    protected $model = TransactionReport::class;

    public function definition(): array
    {
        $generatedAt = now()->subDays(fake()->numberBetween(0, 2));

        return [
            'order_id' => Order::factory(),
            'report_path' => 'reports/oss-' . fake()->unique()->numberBetween(1000, 9999) . '.pdf',
            'emailed_to' => fake()->unique()->safeEmail(),
            'emailed_at' => $generatedAt,
            'generated_at' => $generatedAt,
            'meta' => [
                'generated_by' => fake()->randomElement(['system', 'finance-team']),
            ],
        ];
    }
}
