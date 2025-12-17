<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Создаём модератора
        $moderator = User::create([
            'name' => 'Модератор',
            'email' => 'ebalynin@mail.ru',
            'password' => Hash::make('password123'),
        ]);

        // Присваиваем роль модератора
        $moderatorRole = Role::where('name', 'moderator')->first();
        $moderator->roles()->attach($moderatorRole);

        // Создаём обычного читателя
        $reader = User::create([
            'name' => 'Читатель',
            'email' => 'reader@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Присваиваем роль читателя
        $readerRole = Role::where('name', 'reader')->first();
        $reader->roles()->attach($readerRole);
    }
}