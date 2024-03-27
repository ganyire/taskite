<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class SentEmailVerificationCodeRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
        ];
    }
}
