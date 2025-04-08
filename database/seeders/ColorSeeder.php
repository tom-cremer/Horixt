<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create default colors
        // IMPORTANT: DON'T CHANGE THE ORDER OF THESE COLORS
        Color::factory()->create([
            'name' => 'Gray',
            'alias' => 'zinc',
            'light_color' => 'bg-zinc-300',
            'dark_color' => 'bg-zinc-700',
            'text_light_color' => 'text-gray-800',
            'text_dark_color' => 'text-zinc-200',
        ]);
        Color::factory()->create([
            'name' => 'Red',
            'alias' => 'red',
            'light_color' => 'bg-red-400',
            'dark_color' => 'bg-red-800',
            'text_light_color' => 'text-red-800',
            'text_dark_color' => 'text-red-200',
        ]);
        Color::factory()->create([
            'name' => 'Orange',
            'alias' => 'orange',
            'light_color' => 'bg-orange-400',
            'dark_color' => 'bg-orange-800',
            'text_light_color' => 'text-orange-800',
            'text_dark_color' => 'text-orange-200',
        ]);
        Color::factory()->create([
            'name' => 'Amber',
            'alias' => 'amber',
            'light_color' => 'bg-amber-400',
            'dark_color' => 'bg-amber-800',
            'text_light_color' => 'text-amber-800',
            'text_dark_color' => 'text-amber-200',
        ]);
        Color::factory()->create([
            'name' => 'Yellow',
            'alias' => 'yellow',
            'light_color' => 'bg-yellow-400',
            'dark_color' => 'bg-yellow-800',
            'text_light_color' => 'text-yellow-800',
            'text_dark_color' => 'text-yellow-200',
        ]);
        Color::factory()->create([
            'name' => 'Lime',
            'alias' => 'lime',
            'light_color' => 'bg-lime-400',
            'dark_color' => 'bg-lime-800',
            'text_light_color' => 'text-lime-800',
            'text_dark_color' => 'text-lime-200',
        ]);
        Color::factory()->create([
            'name' => 'Green',
            'alias' => 'green',
            'light_color' => 'bg-green-400',
            'dark_color' => 'bg-green-800',
            'text_light_color' => 'text-green-800',
            'text_dark_color' => 'text-green-200',
        ]);
        Color::factory()->create([
            'name' => 'Emerald',
            'alias' => 'emerald',
            'light_color' => 'bg-emerald-400',
            'dark_color' => 'bg-emerald-800',
            'text_light_color' => 'text-emerald-800',
            'text_dark_color' => 'text-emerald-200',
        ]);
        Color::factory()->create([
            'name' => 'Teal',
            'alias' => 'teal',
            'light_color' => 'bg-teal-400',
            'dark_color' => 'bg-teal-800',
            'text_light_color' => 'text-teal-800',
            'text_dark_color' => 'text-teal-200',
        ]);
        Color::factory()->create([
            'name' => 'Cyan',
            'alias' => 'cyan',
            'light_color' => 'bg-cyan-400',
            'dark_color' => 'bg-cyan-800',
            'text_light_color' => 'text-cyan-800',
            'text_dark_color' => 'text-cyan-200',
        ]);
        Color::factory()->create([
            'name' => 'Sky',
            'alias' => 'sky',
            'light_color' => 'bg-sky-400',
            'dark_color' => 'bg-sky-800',
            'text_light_color' => 'text-sky-800',
            'text_dark_color' => 'text-sky-200',
        ]);
        Color::factory()->create([
            'name' => 'Blue',
            'alias' => 'blue',
            'light_color' => 'bg-blue-400',
            'dark_color' => 'bg-blue-800',
            'text_light_color' => 'text-blue-800',
            'text_dark_color' => 'text-blue-200',
        ]);
        Color::factory()->create([
            'name' => 'Indigo',
            'alias' => 'indigo',
            'light_color' => 'bg-indigo-400',
            'dark_color' => 'bg-indigo-800',
            'text_light_color' => 'text-indigo-800',
            'text_dark_color' => 'text-indigo-200',
        ]);
        Color::factory()->create([
            'name' => 'Violet',
            'alias' => 'violet',
            'light_color' => 'bg-violet-400',
            'dark_color' => 'bg-violet-800',
            'text_light_color' => 'text-violet-800',
            'text_dark_color' => 'text-violet-200',
        ]);
        Color::factory()->create([
            'name' => 'Purple',
            'alias' => 'purple',
            'light_color' => 'bg-purple-400',
            'dark_color' => 'bg-purple-800',
            'text_light_color' => 'text-purple-800',
            'text_dark_color' => 'text-purple-200',
        ]);
        Color::factory()->create([
            'name' => 'Fuchsia',
            'alias' => 'fuchsia',
            'light_color' => 'bg-fuchsia-400',
            'dark_color' => 'bg-fuchsia-800',
            'text_light_color' => 'text-fuchsia-800',
            'text_dark_color' => 'text-fuchsia-200',
        ]);
        Color::factory()->create([
            'name' => 'Pink',
            'alias' => 'pink',
            'light_color' => 'bg-pink-400',
            'dark_color' => 'bg-pink-800',
            'text_light_color' => 'text-pink-800',
            'text_dark_color' => 'text-pink-200',
        ]);
        Color::factory()->create([
            'name' => 'Rose',
            'alias' => 'rose',
            'light_color' => 'bg-rose-400',
            'dark_color' => 'bg-rose-800',
            'text_light_color' => 'text-rose-800',
            'text_dark_color' => 'text-rose-200',
        ]);

    }
}


