<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default statuses
        // IMPORTANT: DON'T CHANGE THE ORDER OF THESE STATUSES
        Status::factory()->create([
            'name' => 'Not Started',
        ]);

        Status::factory()->create([
            'name' => 'In Progress',
        ]);

        Status::factory()->create([
            'name' => 'In Review',
        ]);

        Status::factory()->create([
            'name' => 'Completed',
        ]);
    }
}
