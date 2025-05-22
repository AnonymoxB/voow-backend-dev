<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $listPackage = [
            [
                'icon' => "checklist",
                'description' => "Masa aktif 1 minggu"
            ],
            [
                'icon' => "checklist",
                'description' => "Semua fitur tersedia"
            ],
            [
                'icon' => "checklist",
                'description' => "Tamu undangan unlimited"
            ],
            [
                'icon' => "checklist",
                'description' => "Buat undangan berkali-kali"
            ],
            [
                'icon' => "checklist",
                'description' => "Export video"
            ],
            [
                'icon' => "checklist",
                'description' => "Tanpa watermark"
            ],
        ];

        $packages = [
            [
                'name' => 'Gratis',
                'name_desc' => 'Lorem ipsum dolor sit amet consecteur elit',
                'slug' => 'gratis',
                'price' => 0,
                'promo_price' => 0,
                'description' => json_encode($listPackage),
                'icon' => '',
                'admin_price' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Silver',
                'name_desc' => 'Lorem ipsum dolor sit amet consecteur elit',
                'slug' => 'silver',
                'price' => 100000,
                'promo_price' => 90000,
                'description' => json_encode($listPackage),
                'icon' => '',
                'admin_price' => 5000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gold',
                'name_desc' => 'Lorem ipsum dolor sit amet consecteur elit',
                'slug' => 'gold',
                'price' => 150000,
                'promo_price' => 100000,
                'description' => json_encode($listPackage),
                'icon' => '',
                'admin_price' => 5000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Platinum',
                'name_desc' => 'Lorem ipsum dolor sit amet consecteur elit',
                'slug' => 'platinum',
                'price' => 300000,
                'promo_price' => 250000,
                'description' => json_encode($listPackage),
                'icon' => '',
                'admin_price' => 5000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Package::insert($packages);
    }
}
