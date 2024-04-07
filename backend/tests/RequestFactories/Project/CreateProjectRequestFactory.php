<?php

namespace Tests\RequestFactories\Project;

use Worksome\RequestFactories\RequestFactory;

class CreateProjectRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->word(),
            'description' => fake()->sentence(),
            'team'        => fake()->uuid(),
        ];
    }
}
