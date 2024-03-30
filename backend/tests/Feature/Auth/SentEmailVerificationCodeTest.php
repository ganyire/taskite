<?php

use App\Notifications\Auth\EmailVerificationCodeNotification;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Notification;
use Tests\RequestFactories\Auth\SentEmailVerificationCodeRequestFactory;

/**
 * ----------------
 */
test('Sent Email Verification Code', function () {
    Notification::fake();
    $email = fake()->safeEmail();
    $user  = createBasicUser(['email' => $email]);
    SentEmailVerificationCodeRequestFactory::new ([
        'email' => $email,
    ])->fake();
    $response = postJson("{$this->baseUrl}/auth/email/verification-code");
    $user->refresh();

    $response->assertOk();
    Notification::assertSentTo(
        $user,
        fn(EmailVerificationCodeNotification $notification) => (
            $notification->verificationCode === $user->email_verification_code
        )
    );
    assertDatabaseHas('users', [
        'email'                   => $email,
        'email_verification_code' => $user->email_verification_code,
    ]);
});

/**
 * ----------------
 */
test('Validation error if the email given does not exist, invalid, or empty', function () {
    Notification::fake();
    $email        = fake()->safeEmail();
    $requestEmail = 'prefix' . $email;
    $user         = createBasicUser(['email' => $email]);
    SentEmailVerificationCodeRequestFactory::new ([
        'email' => $requestEmail,
    ])->fake();
    $response = postJson("{$this->baseUrl}/auth/email/verification-code");
    $user->refresh();

    $response->assertUnprocessable();
    $response->assertJsonValidationErrorFor('email', $this->apiValidationErrorsKey);
    Notification::assertNotSentTo($user, EmailVerificationCodeNotification::class);
    assertDatabaseMissing('users', [
        'email'                   => $requestEmail,
        'email_verification_code' => $user->email_verification_code,
    ]);

});
