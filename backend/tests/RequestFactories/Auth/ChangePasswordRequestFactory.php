<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class ChangePasswordRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'old_password' => fake()->password(),
            'password'     => fake()->password(),
        ];
    }
}
