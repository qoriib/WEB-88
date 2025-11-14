<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::vendors() as $vendor) {
            $storeSlug = $vendor['store']['slug'];
            $store = SeederState::$stores[$storeSlug] ?? null;

            if (! $store) {
                continue;
            }

            foreach ($vendor['products'] as $product) {
                $model = Product::updateOrCreate(
                    ['slug' => $product['slug'], 'store_id' => $store->id],
                    [
                        'name' => $product['name'],
                        'sku' => $product['sku'],
                        'description' => $product['description'],
                        'price' => $product['price'],
                        'stock' => $product['stock'],
                        'is_active' => true,
                    ],
                );

                SeederState::$products[$model->slug] = $model;
            }
        }
    }
}
