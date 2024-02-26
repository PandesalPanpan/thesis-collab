<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testing_users = ['student','professor','visitor','moderator','admin'];
        $count = 1;
        foreach ($testing_users as $user){
            \App\Models\User::factory()->create([
                'name' => $user,
                'email' => $user . '@test.com',
                'role_id' => $count,
            ]);
        $count += 1;
        }
        $roles = ['Student', 'Faculty', 'Visitor'];
        foreach ($roles as $role) {
        \App\Models\Role::factory()->create([
            'name' => $role,
        ]);
        }
        \App\Models\Role::factory()->create([
            'name' => 'Moderator',
            'permission_level' => 2,
        ]);
        \App\Models\Role::factory()->create([
            'name' => 'Admin',
            'permission_level' => 3,
        ]);
    }
}
