<?php

use App\Notifications\Auth\PasswordResetTokenNotification;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Notification;
use Tests\RequestFactories\Auth\SendPasswordResetTokenRequestFactory;

test('User can request a password reset token',
    function () {
        Notification::fake();
        $email = fake()->safeEmail();
        $user  = createBasicUser(['email' => $email]);
        SendPasswordResetTokenRequestFactory::new ([
            'email' => $email,
        ])->fake();
        $response = postJson("{$this->baseUrl}/auth/password/reset-token");
        $user->refresh();

        $response->assertOk();
        Notification::assertSentTo(
            $user,
            fn(PasswordResetTokenNotification $notification) => (
                strrev($notification->passwordResetToken) === $user->getPasswordResetToken() &&
                str($notification->passwordResetToken)->length() === tokenLength()
            )
        );
        assertDatabaseCount('password_reset_tokens', 1);
        assertDatabaseHas('password_reset_tokens', [
            'email' => $email,
            'token' => $user->getPasswordResetToken(),
        ]);
    }
);

test('Password reset token request fails when the email does not exist',
    function () {
        Notification::fake();
        $email        = fake()->safeEmail();
        $requestEmail = 'prefix' . $email;
        $user         = createBasicUser(['email' => $email]);
        SendPasswordResetTokenRequestFactory::new ([
            'email' => $requestEmail,
        ])->fake();
        $response = postJson("{$this->baseUrl}/auth/password/reset-token");
        $user->refresh();

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('email', $this->apiValidationErrorsKey);
        Notification::assertNotSentTo($user, PasswordResetTokenNotification::class);
        assertDatabaseCount('password_reset_tokens', 0);
    }
);
