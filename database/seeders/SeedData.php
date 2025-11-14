<?php

namespace Database\Seeders;

class SeedData
{
    public static function admin(): array
    {
        return [
            'name' => 'Yunus Rahadian',
            'email' => 'admin@primatechsolution.id',
            'phone' => '081211118888',
            'city' => 'Jakarta Pusat',
            'address' => 'Gedung Menara Thamrin Lt. 10, Jakarta Pusat',
            'password' => 'PrimaTech#2024',
        ];
    }

    public static function categories(): array
    {
        return [
            [
                'name' => 'Alat Diagnostik Rumah Tangga',
                'slug' => 'alat-diagnostik-rumah-tangga',
                'description' => 'Tensimeter, termometer, glukometer, dan perangkat pemantauan kesehatan lain untuk kebutuhan rumah tangga.',
            ],
            [
                'name' => 'Perawatan Pasien & Rehabilitasi',
                'slug' => 'perawatan-pasien-rehabilitasi',
                'description' => 'Fokus pada kursi roda, tempat tidur pasien, walker hingga matras perawatan luka tekan.',
            ],
            [
                'name' => 'Peralatan Laboratorium Klinik',
                'slug' => 'peralatan-laboratorium-klinik',
                'description' => 'Peralatan uji laboratorium, centrifuge, autoclave, pipet mikro, dan rapid test.',
            ],
            [
                'name' => 'Sterilisasi & Proteksi',
                'slug' => 'sterilisasi-proteksi',
                'description' => 'Masker medis, sarung tangan, disinfectant, dan perlengkapan sterilisasi lainnya.',
            ],
        ];
    }

    public static function vendors(): array
    {
        return [
            [
                'user' => [
                    'name' => 'Fajar Prasetyo',
                    'email' => 'fajar@mitraalkes.id',
                    'phone' => '081212345600',
                    'city' => 'Jakarta Selatan',
                    'address' => 'Jalan RS Fatmawati No. 15, Cilandak, Jakarta Selatan',
                ],
                'store' => [
                    'name' => 'Mitra Alkes Indonesia',
                    'slug' => 'mitra-alkes-indonesia',
                    'category_slug' => 'alat-diagnostik-rumah-tangga',
                    'city' => 'Jakarta Selatan',
                    'address' => 'Komp. Golden Plaza Blok C8, Fatmawati, Jakarta Selatan',
                    'description' => 'Authorized distributor Omron, Accu-Chek, dan berbagai perangkat home care resmi bergaransi.',
                    'contact_email' => 'cs@mitraalkes.id',
                    'contact_phone' => '021-7658890',
                ],
                'products' => [
                    [
                        'name' => 'Tensimeter Omron HEM-7156',
                        'slug' => 'tensimeter-omron-hem-7156',
                        'sku' => 'OMRON-HEM-7156',
                        'price' => 865000,
                        'stock' => 42,
                        'description' => 'Tensimeter digital Omron dengan IntelliSense dan validasi klinis resmi.',
                    ],
                    [
                        'name' => 'Thermometer Omron MC-720',
                        'slug' => 'thermometer-omron-mc-720',
                        'sku' => 'OMRON-MC-720',
                        'price' => 635000,
                        'stock' => 54,
                        'description' => 'Termometer infra merah non contact dengan memori 25 hasil pengukuran.',
                    ],
                    [
                        'name' => 'Pulse Oximeter Jumper JPD-500E',
                        'slug' => 'pulse-oximeter-jumper-jpd-500e',
                        'sku' => 'JUMPER-JPD-500E',
                        'price' => 445000,
                        'stock' => 60,
                        'description' => 'Pulse oximeter OLED dengan akurasi SpO2 ±2% dan alarm bawaan.',
                    ],
                    [
                        'name' => 'Glukometer Accu-Chek Guide',
                        'slug' => 'glukometer-accu-chek-guide',
                        'sku' => 'ACCUCHEK-GUIDE',
                        'price' => 815000,
                        'stock' => 30,
                        'description' => 'Paket starter glukometer Accu-Chek Guide resmi termasuk 25 strip uji.',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Maya Larasati',
                    'email' => 'maya@totalcarebandung.co.id',
                    'phone' => '081389920011',
                    'city' => 'Bandung',
                    'address' => 'Jalan Cihampelas No. 201, Bandung',
                ],
                'store' => [
                    'name' => 'Total Care Bandung',
                    'slug' => 'total-care-bandung',
                    'category_slug' => 'perawatan-pasien-rehabilitasi',
                    'city' => 'Bandung',
                    'address' => 'Ruko Paskal Hypersquare Blok F-10, Bandung',
                    'description' => 'Showroom alat rehabilitasi dan perawatan pasien rumah yang melayani area Jawa Barat.',
                    'contact_email' => 'sales@totalcarebandung.co.id',
                    'contact_phone' => '022-6078891',
                ],
                'products' => [
                    [
                        'name' => 'Kursi Roda Sella FS809',
                        'slug' => 'kursi-roda-sella-fs809',
                        'sku' => 'SELLA-FS809',
                        'price' => 1850000,
                        'stock' => 18,
                        'description' => 'Kursi roda rangka baja dengan sandaran lengan bisa dilepas dan footrest flip-up.',
                    ],
                    [
                        'name' => 'Walker Lipat Trekko 938L',
                        'slug' => 'walker-lipat-trekko-938l',
                        'sku' => 'TREKKO-938L',
                        'price' => 765000,
                        'stock' => 25,
                        'description' => 'Walker aluminium adjustable dengan bantalan busa anti selip.',
                    ],
                    [
                        'name' => 'Tempat Tidur Pasien Aries 3 Crank',
                        'slug' => 'tempat-tidur-pasien-aries-3-crank',
                        'sku' => 'ARIES-3CRANK',
                        'price' => 18750000,
                        'stock' => 6,
                        'description' => 'Ranjang pasien manual 3 crank lengkap dengan side rail dan matras PVC.',
                    ],
                    [
                        'name' => 'Matras Anti Dekubitus Apex Domus 2',
                        'slug' => 'matras-anti-dekubitus-apex-domus-2',
                        'sku' => 'APEX-DOMUS2',
                        'price' => 4250000,
                        'stock' => 12,
                        'description' => 'Sistem matras alternating pressure dengan pompa digital Apex Domus 2.',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Hendri Wijaya',
                    'email' => 'hendri@primamedlab.com',
                    'phone' => '081270889900',
                    'city' => 'Surabaya',
                    'address' => 'Jalan Raya Darmo Permai 2 No. 88, Surabaya',
                ],
                'store' => [
                    'name' => 'Prima MedLab Surabaya',
                    'slug' => 'prima-medlab-surabaya',
                    'category_slug' => 'peralatan-laboratorium-klinik',
                    'city' => 'Surabaya',
                    'address' => 'Pergudangan Margomulyo Permai Blok C-12, Surabaya',
                    'description' => 'Distributor resmi peralatan laboratorium klinik dan perlengkapan proteksi infeksi.',
                    'contact_email' => 'support@primamedlab.com',
                    'contact_phone' => '031-7492212',
                ],
                'products' => [
                    [
                        'name' => 'Autoclave Tuttnauer EZ9',
                        'slug' => 'autoclave-tuttnauer-ez9',
                        'sku' => 'TUTTNAUER-EZ9',
                        'price' => 48500000,
                        'stock' => 3,
                        'description' => 'Autoclave meja 23 liter dengan siklus steril otomatis standar klinik.',
                    ],
                    [
                        'name' => 'Centrifuge Hettich EBA 200',
                        'slug' => 'centrifuge-hettich-eba-200',
                        'sku' => 'HETTICH-EBA200',
                        'price' => 37500000,
                        'stock' => 4,
                        'description' => 'Centrifuge hematologi dengan rotor 8 tabung kecepatan 6000 RPM.',
                    ],
                    [
                        'name' => 'Pipet Mikro Eppendorf Research Plus 100-1000uL',
                        'slug' => 'pipet-mikro-eppendorf-research-plus',
                        'sku' => 'EPPENDORF-1000',
                        'price' => 2850000,
                        'stock' => 20,
                        'description' => 'Micropipette adjustable resmi Eppendorf dengan sertifikat kalibrasi.',
                    ],
                    [
                        'name' => 'Rapid Test Abbott Panbio COVID-19',
                        'slug' => 'rapid-test-abbott-panbio',
                        'sku' => 'ABBOTT-PANBIO',
                        'price' => 150000,
                        'stock' => 200,
                        'description' => 'Kit rapid test antigen Panbio packaging 25 test, distribusi resmi Abbott.',
                    ],
                    [
                        'name' => 'Masker Medis Sensi Earloop 3 Ply',
                        'slug' => 'masker-medis-sensi-earloop-3ply',
                        'sku' => 'SENSI-MASK-3PLY',
                        'price' => 47000,
                        'stock' => 500,
                        'description' => 'Masker medis Sensi asli isi 50 pcs dengan izin edar Kemenkes.',
                    ],
                    [
                        'name' => 'Sarung Tangan Latex Sensi Medium',
                        'slug' => 'sarung-tangan-latex-sensi-medium',
                        'sku' => 'SENSI-GLOVE-M',
                        'price' => 67000,
                        'stock' => 350,
                        'description' => 'Sarung tangan latex non-sterile ukuran medium isi 100 pcs.',
                    ],
                ],
            ],
        ];
    }

    public static function customers(): array
    {
        return [
            [
                'name' => 'Dian Anggraini',
                'email' => 'dian.anggraini82@gmail.com',
                'phone' => '081231223344',
                'city' => 'Depok',
                'address' => 'Jl. Margonda Raya No. 358, Depok',
            ],
            [
                'name' => 'Bayu Hartawan',
                'email' => 'bayu.hartawan@outlook.com',
                'phone' => '081390220876',
                'city' => 'Bandung',
                'address' => 'Perumahan Setraduta Blok G2 No. 11, Bandung',
            ],
            [
                'name' => 'Dr. Sinta Noor, Sp.A',
                'email' => 'sinta.noor@rumahsehati.id',
                'phone' => '081223775599',
                'city' => 'Surabaya',
                'address' => 'Rumah Sehat Ibu Anak, Jl. Diponegoro No. 40, Surabaya',
            ],
        ];
    }

    public static function orders(): array
    {
        return [
            [
                'order_number' => 'OSS-202411-0001',
                'customer_email' => 'dian.anggraini82@gmail.com',
                'store_slug' => 'mitra-alkes-indonesia',
                'payment_method' => 'prepaid',
                'status' => 'completed',
                'shipping_cost' => 25000,
                'city' => 'Depok',
                'shipping_address' => 'Jl. Margonda Raya No. 358, Depok',
                'notes' => 'Mohon packing dengan bubble wrap.',
                'placed_at' => '2024-11-12 09:10:00',
                'completed_at' => '2024-11-13 16:45:00',
                'items' => [
                    ['slug' => 'tensimeter-omron-hem-7156', 'quantity' => 1],
                    ['slug' => 'pulse-oximeter-jumper-jpd-500e', 'quantity' => 1],
                ],
                'payment' => [
                    'status' => 'confirmed',
                    'transaction_reference' => 'BCA-9812378123',
                    'meta' => ['channel' => 'BCA Virtual Account'],
                    'paid_at' => '2024-11-12 09:35:00',
                ],
                'report' => [
                    'path' => 'reports/OSS-202411-0001.pdf',
                    'generated_at' => '2024-11-13 17:00:00',
                    'emailed_at' => '2024-11-13 17:01:00',
                ],
            ],
            [
                'order_number' => 'OSS-202411-0002',
                'customer_email' => 'bayu.hartawan@outlook.com',
                'store_slug' => 'total-care-bandung',
                'payment_method' => 'cod',
                'status' => 'processing',
                'shipping_cost' => 45000,
                'city' => 'Bandung',
                'shipping_address' => 'Perumahan Setraduta Blok G2 No. 11, Bandung',
                'notes' => 'Pengiriman siang hari, ada perawat standby.',
                'placed_at' => '2024-11-10 14:25:00',
                'completed_at' => null,
                'items' => [
                    ['slug' => 'kursi-roda-sella-fs809', 'quantity' => 1],
                    ['slug' => 'walker-lipat-trekko-938l', 'quantity' => 1],
                ],
                'payment' => [
                    'status' => 'pending',
                    'transaction_reference' => null,
                    'meta' => ['catatan' => 'Pembayaran tunai saat diterima'],
                    'paid_at' => null,
                ],
                'report' => [
                    'path' => 'reports/OSS-202411-0002.pdf',
                    'generated_at' => '2024-11-11 08:00:00',
                    'emailed_at' => '2024-11-11 08:01:00',
                ],
            ],
            [
                'order_number' => 'OSS-202411-0003',
                'customer_email' => 'sinta.noor@rumahsehati.id',
                'store_slug' => 'prima-medlab-surabaya',
                'payment_method' => 'prepaid',
                'status' => 'paid',
                'shipping_cost' => 120000,
                'city' => 'Surabaya',
                'shipping_address' => 'Rumah Sehat Ibu Anak, Jl. Diponegoro No. 40, Surabaya',
                'notes' => 'Butuh segera untuk klinik anak.',
                'placed_at' => '2024-11-09 10:10:00',
                'completed_at' => null,
                'items' => [
                    ['slug' => 'autoclave-tuttnauer-ez9', 'quantity' => 1],
                    ['slug' => 'masker-medis-sensi-earloop-3ply', 'quantity' => 30],
                    ['slug' => 'sarung-tangan-latex-sensi-medium', 'quantity' => 25],
                ],
                'payment' => [
                    'status' => 'confirmed',
                    'transaction_reference' => 'MANDIRI-7738291172',
                    'meta' => ['channel' => 'Mandiri Virtual Account'],
                    'paid_at' => '2024-11-09 10:35:00',
                ],
                'report' => [
                    'path' => 'reports/OSS-202411-0003.pdf',
                    'generated_at' => '2024-11-09 11:00:00',
                    'emailed_at' => '2024-11-09 11:02:00',
                ],
            ],
        ];
    }
}
