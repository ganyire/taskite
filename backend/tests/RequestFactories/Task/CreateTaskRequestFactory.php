<?php

namespace Tests\RequestFactories\Task;

use Worksome\RequestFactories\RequestFactory;

class CreateTaskRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'due_date' => fake()->date(),
            'project_id' => fake()->uuid(),
        ];
    }
}
