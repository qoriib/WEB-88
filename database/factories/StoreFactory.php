<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        $faker = fake('id_ID');
        $storeNames = [
            'Mitra Alkes Indonesia',
            'Haniva Medik Sejahtera',
            'Prima Lab Diagnostik',
            'Total Care Bandung',
            'Borneo Mandiri Medika',
        ];

        $name = $faker->randomElement($storeNames);
        $city = $faker->city();

        return [
            'user_id' => User::factory()->vendor(),
            'store_category_id' => StoreCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(11, 999),
            'description' => 'Gerai resmi ' . $name . ' yang fokus menyediakan alat kesehatan terverifikasi Kemenkes.',
            'status' => 'approved',
            'city' => $city,
            'address' => $faker->streetAddress() . ', ' . $city,
            'contact_email' => Str::slug($name, '.') . '@' . fake()->randomElement(['mitraalkes.id', 'hanivamedik.com', 'totalcare.co.id']),
            'contact_phone' => '0' . $faker->numerify('812########'),
            'bank_name' => $faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI']),
            'bank_account_name' => $name,
            'bank_account_number' => $faker->numerify('0##########'),
            'logo_path' => null,
            'approved_at' => now()->subDays(fake()->numberBetween(2, 20)),
        ];
    }
}
