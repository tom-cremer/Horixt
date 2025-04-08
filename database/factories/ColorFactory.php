<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'alias' => $this->faker->word(),
            'light_color' => $this->faker->hexColor(),
            'dark_color' => $this->faker->hexColor(),
            'text_light_color' => $this->faker->hexColor(),
            'text_dark_color' => $this->faker->hexColor(),
        ];
    }
}
