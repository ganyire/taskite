<?php

namespace App\Traits\Auth;

use App\Exceptions\ExpiredPasswordTokenException;
use App\Exceptions\InvalidPasswordTokenException;
use App\Models\PasswordResetToken;
use App\Notifications\Auth\PasswordResetTokenNotification;
use Nette\Utils\Random;

trait PasswordResetTrait
{
    /**
     * Send password reset token to the user
     * ------------
     */
    public function sendPasswordResetToken(): void
    {
        /**
         * @var \App\Models\User $this
         */
        $token      = Random::generate(6);
        $storeToken = PasswordResetToken::query()->updateOrCreate(
            ['email' => $this->email],
            [
                'token'      => $token,
                'created_at' => now(),
            ]
        );

        if (!$storeToken) {
            throw new \Exception(__('passwords.sent_failed'));
        }
        $reversedToken = strrev($token);
        $this->notify(new PasswordResetTokenNotification($reversedToken));
        return;
    }

    /**
     * Reset user password
     * ------------
     */
    public function resetPassword(
        string $password,
        string $passwordResetToken
    ): void {
        if ($this->passwordResetTokenIsExpired($passwordResetToken)) {
            throw new ExpiredPasswordTokenException();
        }
        if (!$this->passwordResetTokenIsValid($passwordResetToken)) {
            throw new InvalidPasswordTokenException();
        }
        /**
         * @var \App\Models\User $this
         */
        $saved = $this->forceFill([
            'password' => $password,
        ])->save();
        if (!$saved) {
            throw new \Exception(__('passwords.reset_failed'));
        }
        $this->removePasswordResetToken();
        return;
    }

    /**
     * Remove password reset token
     * ------------
     */
    public function removePasswordResetToken(): void
    {
        PasswordResetToken::query()
            ->where('email', $this->email)
            ->delete();
        return;
    }

    /**
     * Check if password reset token is expired
     * ------------
     */
    public function passwordResetTokenIsExpired(
        string $passwordResetToken
    ): bool {
        $reversedToken       = strrev($passwordResetToken);
        $tokenExpirationTime = config("auth.passwords.users.expire", 30);
        return PasswordResetToken::query()
            ->where('email', $this->email)
            ->where('token', $reversedToken)
            ->where(
                'created_at',
                '<',
                now()->subMinutes($tokenExpirationTime)
            )->count() > 0;
    }

    /**
     * Check if password reset token is valid
     * ------------
     */
    public function passwordResetTokenIsValid(
        string $passwordResetToken
    ): bool {
        $reversedToken = strrev($passwordResetToken);
        return PasswordResetToken::query()
            ->where('email', $this->email)
            ->where('token', $reversedToken)
            ->count() > 0;
    }

    /**
     * Get the password reset token
     * ------------
     */
    public function getPasswordResetToken(): string
    {
        $token = PasswordResetToken::query()
            ->firstWhere('email', $this->email);
        return $token->token;
    }
}
