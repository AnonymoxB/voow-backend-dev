<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'user_id' => 1,
            'blog_category_id' => 1,
            'title' => $title,
            'image' => "https://muhammadiyah.or.id/wp-content/uploads/2021/12/WhatsApp-Image-2021-12-22-at-12.29.28.jpeg",
            'slug' => Str::slug($title." ".str::random(4)),
            'content' => fake()->text(),
            'status' => "Publish"
        ];
    }
}
