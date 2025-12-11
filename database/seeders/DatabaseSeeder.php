<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Сначала создаём роли
        $this->call(RoleSeeder::class);
        
        // Затем создаём пользователей с ролями
        $this->call(UserSeeder::class);
        
        // Создаём статьи с комментариями
        Article::factory(20)->create()->each(function ($article) {
            Comment::factory(rand(0, 5))->create([
                'article_id' => $article->id
            ]);
        });
    }
}