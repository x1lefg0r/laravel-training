<?php

namespace Database\Seeders;

use App\Models\User;
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
        
        // Затем создаём пользователей с ролями (модератор и читатель)
        $this->call(UserSeeder::class);
        
        // Создаём дополнительных читателей
        $readers = User::factory(5)->create();
        $readerRole = \App\Models\Role::where('name', 'reader')->first();
        foreach ($readers as $reader) {
            $reader->roles()->attach($readerRole);
        }
        
        // Получаем всех пользователей
        $allUsers = User::all();
        
        // Создаём статьи
        Article::factory(20)->create()->each(function ($article) use ($allUsers) {
            // Для каждой статьи создаём от 0 до 8 комментариев
            $commentCount = rand(0, 8);
            
            for ($i = 0; $i < $commentCount; $i++) {
                $user = $allUsers->random(); // Случайный пользователь
                
                Comment::create([
                    'article_id' => $article->id,
                    'user_id' => $user->id,
                    'author' => $user->name,
                    'content' => fake()->paragraph(rand(1, 3)),
                ]);
            }
        });
    }
}