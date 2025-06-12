<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ColorSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Tom Cremer',
            'email' => 'tomcremer2903@gmail.com',
            'password' => bcrypt('azertyuiop$')
        ]);

        $this->call([
            AdministratorSeeder::class,
        ]);
    }
}
