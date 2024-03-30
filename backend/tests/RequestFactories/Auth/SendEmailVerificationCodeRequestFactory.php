<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class SendEmailVerificationCodeRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
        ];
    }
}
