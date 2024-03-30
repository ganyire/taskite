<?php

namespace Tests\RequestFactories\Auth;

use Nette\Utils\Random;
use Worksome\RequestFactories\RequestFactory;

class ResetPasswordRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email'                 => fake()->safeEmail(),
            'password'              => fake()->password(),
            'password_confirmation' => 'password',
            'token'                 => Random::generate(tokenLength()),
        ];
    }
}
