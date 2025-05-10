<?php

namespace Database\Seeders;

use App\Models\Administrators;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create default administrators
        Administrators::factory()->create([
            'user_id' => 1,
        ]);

    }
}
