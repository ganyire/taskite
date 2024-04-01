<?php

use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertTrue;
use Laravel\Sanctum\Sanctum;
use Tests\RequestFactories\Auth\ChangePasswordRequestFactory;

test('User can change their password', function () {
    $oldPassword = 'OldPassword123!';
    $newPassword = 'NewPassword123!';
    /**
     * @var \App\Models\User|Illuminate\Contracts\Auth\Authenticatable $user
     */
    $user = createBasicUser(['password' => $oldPassword]);
    ChangePasswordRequestFactory::new ([
        'old_password' => $oldPassword,
        'password'     => $newPassword,
    ])->fake();
    Sanctum::actingAs($user);
    $response = postJson("{$this->baseUrl}/auth/password/change");

    $response->assertCreated();
    $response->assertJson(['message' => __('passwords.changed')]);
    assertTrue(password_verify($newPassword, $user->fresh()->password));
});

/**
 * ----------------
 */
test('Password change fails if old password given is wrong', function () {
    $oldPassword = 'OldPassword123!';
    $newPassword = 'NewPassword123!';
    /**
     * @var \App\Models\User|Illuminate\Contracts\Auth\Authenticatable $user
     */
    $user = createBasicUser(['password' => $oldPassword]);
    ChangePasswordRequestFactory::new ([
        'old_password' => 'WrongOldPassword123!',
        'password'     => $newPassword,
    ])->fake();
    Sanctum::actingAs($user);
    $response = postJson("{$this->baseUrl}/auth/password/change");

    $response->assertUnprocessable();
    $response->assertJsonValidationErrorFor('old_password', $this->apiValidationErrorsKey);
    assertTrue(password_verify($oldPassword, $user->fresh()->password));

});
