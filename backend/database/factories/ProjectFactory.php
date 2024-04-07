<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     * ------------
     */
    public function definition(): array
    {
        return [
            'name'        => fake()->word(),
            'description' => fake()->sentence(),
            'user_id'     => fake()->uuid(),
            'team_id'     => null,
        ];
    }

}
