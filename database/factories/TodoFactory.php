<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'is_trackable' => $this->faker->boolean(90),
            'status_id' => $this->faker->numberBetween(1, 4),
            'priority_id' => $this->faker->numberBetween(1, 4),
            'user_id' => $this->faker->numberBetween(1, 10),
            'project_id' => $this->faker->numberBetween(1, 5),
            'organization_id' => $this->faker->numberBetween(1, 3),
            'parent_id' => $this->faker->optional()->numberBetween(1, 10),
        ];
    }
}
