<?php

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use Tests\RequestFactories\Auth\VerifyEmailRequestFactory;

/**
 * ----------------
 */
test('User can verify email successfully',
    function () {
        $verificationCode = '123456';
        $user             = createBasicUser([
            'email_verification_code' => $verificationCode,
        ]);
        VerifyEmailRequestFactory::new ([
            'email'                 => $user->email,
            'emailVerificationCode' => $verificationCode,
        ])->fake();
        $response = postJson("{$this->baseUrl}/auth/email/verify");
        $user->refresh();

        $response->assertOk();
        expect($user->hasVerifiedEmail())->toBeTrue();
        assertDatabaseHas('users', [
            'email'                   => $user->email,
            'email_verified_at'       => now(),
            'email_verification_code' => null,
        ]);
    }
);

/**
 * ----------------
 */
test('User can not verify email with invalid verification code',
    function () {
        $verificationCode = '123456';
        $user             = createBasicUser([
            'email_verification_code' => $verificationCode,
        ]);
        VerifyEmailRequestFactory::new ([
            'email'                 => $user->email,
            'emailVerificationCode' => '654321',
        ])->fake();
        $response = postJson("{$this->baseUrl}/auth/email/verify");
        $user->refresh();

        $response->assertStatus(422);
        expect($user->hasVerifiedEmail())->toBeFalse();
        assertDatabaseHas('users', [
            'email'                   => $user->email,
            'email_verified_at'       => null,
            'email_verification_code' => $verificationCode,
        ]);
    }
);

/**
 * ----------------
 */
test('User can not verify email with already verified email',
    function () {
        $emailVerification = '123456';
        $user              = createBasicUser([
            'email_verified_at'       => now(),
            'email_verification_code' => $emailVerification,
        ]);
        VerifyEmailRequestFactory::new ([
            'email'                 => $user->email,
            'emailVerificationCode' => $emailVerification,
        ])->fake();
        $response = postJson("{$this->baseUrl}/auth/email/verify");

        $response->assertStatus(400);
        expect($user->hasVerifiedEmail())->toBeTrue();
    }
);
