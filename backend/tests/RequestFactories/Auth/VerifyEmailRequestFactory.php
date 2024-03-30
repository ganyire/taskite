<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class VerifyEmailRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email'                  => fake()->safeEmail(),
            'emailVerificationCode ' => fake()->numberBetween(100000, 999999),
        ];
    }
}
