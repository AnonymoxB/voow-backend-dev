<?php

namespace Database\Seeders;

use App\Models\Tutorial;
use App\Models\TutorialCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tutorials = [

            [
                'user_id' => 1,
                'tutorial_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://cdn.pixabay.com/photo/2020/04/03/19/02/virus-4999857_1280.png",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish",
                'link_youtube' => 'https://www.youtube.com/watch?v=UzKdy75GqXQ&list=RD6Q5xqNkCk7w&index=7&ab_channel=GANGGA'
            ],
            [
                'user_id' => 1,
                'tutorial_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://cdn.pixabay.com/photo/2023/08/16/18/05/homes-8194751_1280.png",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish",
                'link_youtube' => 'https://www.youtube.com/watch?v=UzKdy75GqXQ&list=RD6Q5xqNkCk7w&index=7&ab_channel=GANGGA'
            ],
            [
                'user_id' => 1,
                'tutorial_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://cdn.pixabay.com/photo/2018/02/22/13/08/illustration-3172985_1280.png",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish",
                'link_youtube' => 'https://www.youtube.com/watch?v=UzKdy75GqXQ&list=RD6Q5xqNkCk7w&index=7&ab_channel=GANGGA'
            ],
            [
                'user_id' => 1,
                'tutorial_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://cdn.pixabay.com/photo/2018/02/24/07/17/pattern-3177414_1280.png",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish",
                'link_youtube' => 'https://www.youtube.com/watch?v=UzKdy75GqXQ&list=RD6Q5xqNkCk7w&index=7&ab_channel=GANGGA'
            ],
            [
                'user_id' => 1,
                'tutorial_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://cdn.pixabay.com/photo/2017/05/15/15/37/polaroid-2315182_1280.png",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish",
                'link_youtube' => 'https://www.youtube.com/watch?v=UzKdy75GqXQ&list=RD6Q5xqNkCk7w&index=7&ab_channel=GANGGA'
            ]
        ];

        Tutorial::insert($tutorials);
    }
}
