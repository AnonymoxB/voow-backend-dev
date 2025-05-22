<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'template_category_id' => 1,
                'title' => "Template 1",
                'image' => "https://cdn.pixabay.com/photo/2023/08/16/18/05/homes-8194751_1280.png",
                'type' => "Free",
                'status' => 'Publish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'template_category_id' => 2,
                'title' => "Template 2",
                'image' => "https://cdn.pixabay.com/photo/2020/09/14/15/10/birch-tree-5571242_1280.png",
                'type' => "Premium",
                'status' => 'Publish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'template_category_id' => 1,
                'title' => "Template 3",
                'image' => "https://cdn.pixabay.com/photo/2018/05/21/14/46/autumn-3418440_1280.png",
                'type' => "Premium",
                'status' => 'Publish',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'template_category_id' => 2,
                'title' => "Template 4",
                'image' => "https://cdn.pixabay.com/photo/2013/07/13/01/12/witch-155291_1280.png",
                'type' => "Premium",
                'status' => 'Draft',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'template_category_id' => 3,
                'title' => "Template 5",
                'image' => "https://cdn.pixabay.com/photo/2018/01/10/23/53/rabbit-3075088_1280.png",
                'type' => "Premium",
                'status' => 'Draft',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Template::insert($templates);
    }
}
