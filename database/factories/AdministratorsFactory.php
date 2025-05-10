<?php

namespace Database\Factories;

use App\Models\Administrators;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministratorsFactory extends Factory
{
    protected $model = Administrators::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween(1, 100),
        ];
    }
}
