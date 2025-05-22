<?php

namespace Database\Seeders;

use App\Models\TemplateCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templateCategory = [
            [
                'title' => 'Wedding & Engagement',
                'slug' => Str::slug('Wedding & Engagement'),
                'description' => 'Wedding & Engagement',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Kids & Birthday',
                'slug' => Str::slug('Kids & Birthday'),
                'description' => 'Kids & Birthday',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Aqiqah & Tamsiyah',
                'slug' => Str::slug('Aqiqah & Tamsiyah'),
                'description' => 'Aqiqah & Tamsiyah',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Graduation',
                'slug' => Str::slug('Graduation'),
                'description' => 'Graduation',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        TemplateCategory::insert($templateCategory);
    }
}
