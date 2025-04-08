<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            ColorSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Tom Cremer',
            'email' => 'tomcremer2903@gmail.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        Track::factory(10)->create();
    }
}
