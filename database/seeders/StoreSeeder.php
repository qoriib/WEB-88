<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::vendors() as $vendor) {
            $userEmail = $vendor['user']['email'];
            $categorySlug = $vendor['store']['category_slug'];

            $owner = SeederState::$vendors[$userEmail] ?? null;
            $category = SeederState::$categories[$categorySlug] ?? null;

            if (! $owner || ! $category) {
                continue;
            }

            $storeData = $vendor['store'];
            $store = Store::updateOrCreate(
                ['slug' => $storeData['slug']],
                [
                    'user_id' => $owner->id,
                    'store_category_id' => $category->id,
                    'name' => $storeData['name'],
                    'description' => $storeData['description'],
                    'status' => 'approved',
                    'city' => $storeData['city'],
                    'address' => $storeData['address'],
                    'contact_email' => $storeData['contact_email'],
                    'contact_phone' => $storeData['contact_phone'],
                    'bank_name' => $storeData['bank_name'] ?? null,
                    'bank_account_name' => $storeData['bank_account_name'] ?? null,
                    'bank_account_number' => $storeData['bank_account_number'] ?? null,
                    'logo_path' => null,
                    'approved_at' => now()->subDays(5),
                ],
            );

            SeederState::$stores[$store->slug] = $store;
        }
    }
}
