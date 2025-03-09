<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Tom Cremer',
            'email' => 'tomcremer2903@gmail.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        Track::factory(10)->create();
    }
}
