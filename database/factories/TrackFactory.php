<?php

namespace Database\Factories;

use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackFactory extends Factory
{
    protected $model = Track::class;

    public function definition(): array
    {
        $startedAt = $this->faker->dateTimeBetween('-6 hours', 'now');
        $endedAt = $this->faker->dateTimeBetween($startedAt, '+4 hours');

        $start = strtotime($startedAt->format('Y-m-d H:i:s')); // Convert to timestamp
        $end = strtotime($endedAt->format('Y-m-d H:i:s')); // Convert to timestamp

        $duration = max(0, $end - $start);

        return [
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
            'user_id' => $this->faker->numberBetween(1, 10),
            'todo_id' => $this->faker->numberBetween(1, 10),
            'durations' => $duration,
        ];

    }
}
