<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testing_users = ['student','faculty','visitor','studentassistant', 'moderator','admin'];
        $count = 1;
        foreach ($testing_users as $user){
            \App\Models\User::factory()->create([
                'name' => $user,
                'email' => $user . '@test.com',
                'role_id' => $count,
            ]);
            print($user . ' created' . PHP_EOL);
        $count += 1;
        }
        $roles = ['Student', 'Faculty', 'Visitor'];
        foreach ($roles as $role) {
        \App\Models\Role::factory()->create([
            'name' => $role,
        ]);
        }
        $moderators = ['Student Assistant', 'Moderator'];
        foreach ($moderators as $moderator){
            \App\Models\Role::factory()->create([
                'name' => $moderator,
                'permission_level' => 2,
            ]);
        }
        \App\Models\Role::factory()->create([
            'name' => 'Laboratory Head',
            'permission_level' => 3,
        ]);

        // Equipments
        $equipments = ['VOM', 'Pliers', "Key #103", "Key #104"];
        foreach ($equipments as $equipment){
            \App\Models\Equipment::factory()->create([
                    'name' => $equipment,
                    'barcode' => Str::random(15),
                    'rfid' => Str::random(15),
            ]);
        }

    }
}
