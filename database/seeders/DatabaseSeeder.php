<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаём 20 статей
        Article::factory(20)->create()->each(function ($article) {
            // Для каждой статьи создаём от 0 до 5 комментариев
            Comment::factory(rand(0, 5))->create([
                'article_id' => $article->id
            ]);
        });
    }
}