<?php

use App\Enums\RolesEnum;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\postJson;
use Tests\RequestFactories\Auth\LoginRequestFactory;

test('User can login to the app', function () {
    $teamName = 'my-team';
    $password = fake()->password();
    /**
     * @var \App\Models\User|Illuminate\Contracts\Auth\Authenticatable $user
     */
    $user = registerUser(teamName: $teamName, password: $password);
    LoginRequestFactory::new ([
        'email' => $user->email,
        'password' => $password,
    ])->fake();
    $response = postJson("{$this->baseUrl}/auth/login");

    $response->assertOk();
    $response->assertJsonPath(
        'payload.teamRole.name',
        RolesEnum::Owner->value
    );
    $response->assertJsonPath(
        'payload.team.name',
        str($teamName)->replace(' ', '-')->lower()->toString()
    );
    assertAuthenticatedAs($user);
    assert(is_string($response->json('payload.accessToken')));
});

test('Login fails when supplied wrong credentials', function () {
    $password = fake()->password();
    $user = registerUser(teamName: 'my-team', password: $password);
    LoginRequestFactory::new ([
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->fake();
    $response = postJson("{$this->baseUrl}/auth/login");

    $response->assertUnauthorized();
    assert($user->isNot(auth()->user()));
    $response->assertJson(['status' => 'error']);
});

test('Get validation error if email provided does not exist', function () {
    $password = fake()->password();
    registerUser(teamName: 'my-team', password: $password);
    LoginRequestFactory::new ([
        'email' => 'mymail@fake.com',
        'password' => $password,
    ])->fake();
    $response = postJson("{$this->baseUrl}/auth/login");

    $response->assertUnprocessable();
    $response->assertJsonValidationErrorFor('email', $this->apiValidationErrorsKey);
});
