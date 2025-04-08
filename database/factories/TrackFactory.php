<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackFactory extends Factory
{
    protected $model = Track::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'started_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'ended_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'description' => $this->faker->paragraph,
            'user_id' => 1,
            'color_id' => Color::DEFAULT,
            'project_id' => null,
        ];
    }
}
