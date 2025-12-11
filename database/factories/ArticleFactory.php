<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),   
            'content' => fake()->paragraphs(5, true), 
            'author' => fake()->name(), 
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'image' => fake()->imageUrl(640, 480, 'articles', true),
            'views' => fake()->numberBetween(0, 10000),
        ];
    }
}