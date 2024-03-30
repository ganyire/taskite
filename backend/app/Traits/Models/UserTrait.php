<?php

namespace App\Traits\Models;

use App\Models\Role;
use App\Notifications\Auth\EmailVerificationCodeNotification;
use Nette\Utils\Random;

trait UserTrait
{

    /**
     * Create sanctum access token
     * ------------
     */
    public function createAccessToken(): string
    {
        /**
         * @var \App\Models\User $this
         */
        $derivedToken = str($this->email)->replace(['.', '@'], '')
            ->lower()->toString();
        return $this->createToken("token-{$derivedToken}")->plainTextToken;
    }

    /**
     * Get the user's role for the given team
     * ------------
     */
    public function getCurrentTeamRole(string $teamId): Role
    {
        /**
         * @var \App\Models\User $this
         */
        return $this->roles()
            ->wherePivot('team_id', $teamId)
            ->first(['id', 'name', 'display_name']);
    }

    /**
     * Determine if the user as verified their email address
     * ------------
     */
    public function hasVerifiedEmail(): bool
    {
        /**
         * @var \App\Models\User $this
         */
        return !is_null($this->email_verified_at);
    }

    /**
     * Verify the user's email address
     * ------------
     */
    public function markEmailAsVerified(): bool
    {
        /**
         * @var \App\Models\User $this
         */
        return $this->forceFill([
            'email_verified_at'       => $this->freshTimestamp(),
            'email_verification_code' => null,
        ])->save();
    }

    /**
     * Send email verification code
     * ------------
     */
    public function sendEmailVerificationCode(): void
    {
        /**
         * @var \App\Models\User $this
         */
        $code = Random::generate(6);
        $this->forceFill([
            'email_verification_code' => $code,
        ])->save();
        $this->notify(new EmailVerificationCodeNotification($code));
    }

    /**
     * Determine if the user is locked
     * ------------
     */
    public function isLocked(): bool
    {
        /**
         * @var \App\Models\User $this
         */
        return $this->locked;
    }

    /**
     * Lock the user
     * ------------
     */
    public function lock(): bool
    {
        /**
         * @var \App\Models\User $this
         */
        return $this->forceFill([
            'locked' => true,
        ])->save();
    }

    /**
     * Unlock the user
     * ------------
     */
    public function unlock(): bool
    {
        /**
         * @var \App\Models\User $this
         */
        return $this->forceFill([
            'locked' => false,
        ])->save();
    }

    /**
     * Sent password reset code
     */

}
