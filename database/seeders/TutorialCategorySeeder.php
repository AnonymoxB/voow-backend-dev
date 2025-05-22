<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TutorialCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TutorialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutorialCategory = [
            [
                'title' => 'Akun Dan Keamanan',
                'slug' => Str::slug('Akun Dan Keamanan'),
                'description' => 'Akun Dan Keamanan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Membuat Undangan',
                'slug' => Str::slug('Membuat Undangan'),
                'description' => 'Membuat Undangan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Pesanan',
                'slug' => Str::slug('Pesanan'),
                'description' => 'Pesanan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Pembayaran',
                'slug' => Str::slug('Pembayaran'),
                'description' => 'Pembayaran',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        TutorialCategory::insert($tutorialCategory);
    }
}
