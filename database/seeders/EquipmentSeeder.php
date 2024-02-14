<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            Equipment::create([
                'name' => $faker->name,
                'user_id' => $faker->numberBetween(1, 10),
                'status' => $faker->boolean,
            ]);
        }

    }
}
