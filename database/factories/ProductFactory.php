<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $products = [
            [
                'name' => 'Tensimeter Omron HEM-7156',
                'sku' => 'OMRON-HEM-7156',
                'description' => 'Tensimeter digital Omron resmi bergaransi 5 tahun untuk pemantauan tekanan darah.',
                'price' => 865000,
            ],
            [
                'name' => 'Pulse Oximeter Jumper JPD-500E',
                'sku' => 'JUMPER-JPD-500E',
                'description' => 'Pulse oximeter klinis dengan display OLED akurasi tinggi.',
                'price' => 465000,
            ],
            [
                'name' => 'Nebulizer Omron NE-C803',
                'sku' => 'OMRON-NE-C803',
                'description' => 'Nebulizer portable Omron resmi dengan teknologi virtual valve.',
                'price' => 795000,
            ],
            [
                'name' => 'Kursi Roda Sella FS809',
                'sku' => 'SELLA-FS809',
                'description' => 'Kursi roda lipat rangka baja tahan lama dengan sabuk pengaman.',
                'price' => 1875000,
            ],
            [
                'name' => 'Paramount Bed 3 Crank',
                'sku' => 'PARAMOUNT-3CRANK',
                'description' => 'Ranjang pasien hospital grade dengan matras anti decubitus.',
                'price' => 21500000,
            ],
        ];

        $entry = fake()->randomElement($products);
        $stock = fake()->numberBetween(5, 60);

        return [
            'store_id' => Store::factory(),
            'name' => $entry['name'],
            'slug' => Str::slug($entry['name']),
            'sku' => $entry['sku'],
            'description' => $entry['description'],
            'price' => $entry['price'],
            'stock' => $stock,
            'is_active' => true,
            'thumbnail_path' => null,
        ];
    }
}
