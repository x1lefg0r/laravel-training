<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'moderator',
                'display_name' => 'Модератор',
            ],
            [
                'name' => 'reader',
                'display_name' => 'Читатель',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}