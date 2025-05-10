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
        User::factory()->create([
            'name' => 'Tom Cremer',
            'email' => 'tomcremer2903@gmail.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        User::factory()->create([
            'name' => 'Leo Cat',
            'email' => 'leothecat04@gmail.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        User::factory()->create([
            'name' => 'Geoffrey Touette',
            'email' => 'geoffrey@test.com',
            'password' => bcrypt('azertyuiop$')
        ]);
        User::factory()->create([
            'name' => 'Robin Thijisen',
            'email' => 'robin@test.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        User::factory()->create([
            'name' => 'Lucas Gava',
            'email' => 'lucas@test.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        User::factory()->create([
            'name' => 'Anthony De Sousa',
            'email' => 'anthony@test.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        $this->call([
            ColorSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            AdministratorSeeder::class,
        ]);





    }
}
