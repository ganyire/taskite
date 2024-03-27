<?php

use App\Enums\RolesEnum;
use App\Notifications\Auth\AccountRegisteredNotification;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Notification;
use Tests\RequestFactories\Auth\RegisterRequestFactory;

test('User can create account successfully', function () {
    Notification::fake();
    $teamName = 'My workspace';
    RegisterRequestFactory::new (['teamName' => $teamName])
        ->passwordConfirmed()
        ->fake();
    $response = postJson("{$this->baseUrl}/auth/register");

    $response->assertCreated();
    $response->assertJsonPath(
        'payload.teamRole.name',
        RolesEnum::OWNER->value
    );
    $response->assertJsonPath(
        'payload.team.name',
        str($teamName)->replace(' ', '-')->lower()->toString()
    );
    Notification::assertSentTo(
        auth()->user(),
        AccountRegisteredNotification::class
    );
    assertAuthenticated();
    assert(is_string($response->json('payload.accessToken')));
    assertDatabaseCount('users', 1);
});

test('Throws validation errors for invalid data', function () {
    RegisterRequestFactory::new (['email' => 'invalid-email'])->fake();
    $response = postJson("{$this->baseUrl}/auth/register");

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(
        ['password', 'email'],
        $this->apiValidationErrorsKey
    );
    assertDatabaseEmpty('users');
    assertDatabaseEmpty('team_user');
    assertDatabaseEmpty('role_user');
});
