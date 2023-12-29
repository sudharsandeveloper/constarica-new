<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'area_name' => $this->faker->city,
            'status' => $this->faker->numberBetween($min = 0, $max = 1),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
