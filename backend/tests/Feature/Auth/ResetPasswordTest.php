<?php

use App\Models\PasswordResetToken;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;
use Tests\RequestFactories\Auth\ResetPasswordRequestFactory;

test('User can reset their password',
    function () {
        $oldPassword        = 'oldPassword123';
        $newPassword        = "NewPassword123";
        $user               = createBasicUser(['password' => $oldPassword]);
        $passwordResetToken = $user->generatePasswordResetToken();
        ResetPasswordRequestFactory::new ([
            'email'                 => $user->email,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
            'token'                 => strrev($passwordResetToken),
        ])->fake();

        $response = postJson("{$this->baseUrl}/auth/password/reset");

        $response->assertOk();
        $response->assertJson(['message' => __('passwords.reset')]);
        $oldCredentials = ['email' => $user->email, 'password' => $oldPassword];
        $newCredentials = ['email' => $user->email, 'password' => $newPassword];
        assertFalse(auth()->attempt($oldCredentials));
        assertTrue(auth()->attempt($newCredentials));
        assertDatabaseCount('password_reset_tokens', 0);
    }
);

/**
 * ----------------
 */
test('Password reset fails with expired reset token',
    function () {
        $oldPassword        = 'oldPassword123';
        $newPassword        = "NewPassword123";
        $user               = createBasicUser(['password' => $oldPassword]);
        $passwordResetToken = $user->generatePasswordResetToken();
        $expireToken        = getTimeToExpireToken();
        PasswordResetToken::query()->where('email', $user->email)
            ->update(['created_at' => now()->subMinutes($expireToken)]);
        ResetPasswordRequestFactory::new ([
            'email'                 => $user->email,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
            'token'                 => strrev($passwordResetToken),
        ])->fake();

        $response = postJson("{$this->baseUrl}/auth/password/reset");

        $response->assertUnprocessable();
        $response->assertJson(['payload' => __('passwords.token_expired')]);
        $oldCredentials = ['email' => $user->email, 'password' => $oldPassword];
        $newCredentials = ['email' => $user->email, 'password' => $newPassword];
        assertTrue(auth()->attempt($oldCredentials));
        assertFalse(auth()->attempt($newCredentials));
        assertDatabaseCount('password_reset_tokens', 1);
    }
);

/**
 * ----------------
 */
test('Password reset fails with invalid reset token',
    function () {
        $oldPassword        = 'oldPassword123';
        $newPassword        = "NewPassword123";
        $user               = createBasicUser(['password' => $oldPassword]);
        $passwordResetToken = $user->generatePasswordResetToken();
        ResetPasswordRequestFactory::new ([
            'email'                 => $user->email,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
            'token'                 => strrev($passwordResetToken) . 'invalid',
        ])->fake();

        $response = postJson("{$this->baseUrl}/auth/password/reset");

        $response->assertUnprocessable();
        $response->assertJson(['payload' => __('passwords.token_invalid')]);
        $oldCredentials = ['email' => $user->email, 'password' => $oldPassword];
        $newCredentials = ['email' => $user->email, 'password' => $newPassword];
        assertTrue(auth()->attempt($oldCredentials));
        assertFalse(auth()->attempt($newCredentials));
        assertDatabaseCount('password_reset_tokens', 1);
    }
);
