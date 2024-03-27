<?php

namespace Tests\RequestFactories\Auth;

use Worksome\RequestFactories\RequestFactory;

class RegisterRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name'                  => fake()->name('male'),
            'email'                 => fake()->unique()->safeEmail(),
            'password'              => fake()->password() . '01',
            'password_confirmation' => fake()->password() . '02',
            'teamName'              => fake()->word(),
        ];
    }

    public function passwordConfirmed(string $password = 'Taskite10')
    {
        return $this->state([
            'password'              => $password,
            'password_confirmation' => $password,
        ]);
    }
}
