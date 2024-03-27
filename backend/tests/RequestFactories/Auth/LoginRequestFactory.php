<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class LoginRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email'    => fake()->email(),
            'password' => fake()->password(),
        ];
    }

}
