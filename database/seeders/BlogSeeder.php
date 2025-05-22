<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $blogData = [
            [
                'user_id' => 1,
                'blog_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://muhammadiyah.or.id/wp-content/uploads/2021/12/WhatsApp-Image-2021-12-22-at-12.29.28.jpeg",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish"
            ],
            [
                'user_id' => 1,
                'blog_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://awsimages.detik.net.id/community/media/visual/2021/11/25/pernikahan-adat-palembang-7_169.png?w=1200",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish"
            ],
            [
                'user_id' => 1,
                'blog_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://img.iproperty.com.my/angel-legacy/1110x624-crop/static/2020/10/Biaya-Pernikahan-1.jpg",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish"
            ],
            [
                'user_id' => 1,
                'blog_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://alexandra.bridestory.com/images/dpr_1.0,f_auto,fl_progressive,q_80,c_fill,g_faces,w_600/blogs/mindfolks-betawi-wedding-H1zVoSFg_/calon-pengantin-berikut-peraturan-baru-terkait-pelaksanaan-pernikahan-di-tengah-pandemi-covid-19-1.jpg",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish"
            ],
            [
                'user_id' => 1,
                'blog_category_id' => 1,
                'title' => fake()->sentence(),
                'image' => "https://mommiesdaily.com/wp-content/uploads/2023/07/pexels-trung-nguyen-2959192-1-scaled.jpg",
                'slug' => Str::slug(fake()->sentence() . " " . str::random(4)),
                'content' => fake()->text(),
                'status' => "Publish"
            ],
        ];

        Blog::insert($blogData);
    }
}
