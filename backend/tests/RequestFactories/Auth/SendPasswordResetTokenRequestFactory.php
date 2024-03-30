<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class SendPasswordResetTokenRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail(),
        ];
    }
}
