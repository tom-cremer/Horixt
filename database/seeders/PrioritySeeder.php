<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating defaults Priorities
        // IMPORTANT: DON'T CHANGE THE ORDER OF THE PRIORITIES
        Priority::factory()->create([
            'name' => 'Low',
        ]);
        Priority::factory()->create([
            'name' => 'Medium',
        ]);
        Priority::factory()->create([
            'name' => 'High',
        ]);
        Priority::factory()->create([
            'name' => 'Urgent',
        ]);
    }
}
