<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class UpdateProfileRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
          // 'email' => $this->faker->email,
        ];
    }
}
