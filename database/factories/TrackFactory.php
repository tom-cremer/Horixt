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
            'started_at' => $this->faker->dateTime(),
            'ended_at' => $this->faker->dateTime(),
            'user_id' => $this->faker->numberBetween(1, 10),
            'todo_id' => $this->faker->numberBetween(1, 10),
            'durations' => $this->faker->numberBetween(0, 10000),
        ];
    }
}
