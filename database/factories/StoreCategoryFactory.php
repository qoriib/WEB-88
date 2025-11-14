<?php

namespace Database\Factories;

use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<StoreCategory>
 */
class StoreCategoryFactory extends Factory
{
    protected $model = StoreCategory::class;

    public function definition(): array
    {
        $categories = [
            [
                'name' => 'Alat Diagnostik Rumah Tangga',
                'description' => 'Kategori untuk tensimeter, termometer, pulse oximeter, dan alat diagnostik rumahan lainnya.',
            ],
            [
                'name' => 'Perawatan Pasien & Rehabilitasi',
                'description' => 'Produk kursi roda, bed pasien, walker, serta perlengkapan rehabilitasi.',
            ],
            [
                'name' => 'Peralatan Laboratorium Klinik',
                'description' => 'Peralatan laboratorim seperti centrifuge, autoclave, mikroskop dan alat uji cepat.',
            ],
            [
                'name' => 'Sterilisasi & Proteksi',
                'description' => 'Produk sterilisasi, disinfectant, masker medis, dan sarung tangan.',
            ],
            [
                'name' => 'Kesehatan Ibu & Anak',
                'description' => 'Kategori perlengkapan perawatan ibu hamil, bayi, dan anak.',
            ],
        ];

        $entry = fake()->randomElement($categories);

        return [
            'name' => $entry['name'],
            'slug' => Str::slug($entry['name'] . '-' . fake()->unique()->numberBetween(10, 999)),
            'description' => $entry['description'],
            'is_active' => true,
        ];
    }
}
