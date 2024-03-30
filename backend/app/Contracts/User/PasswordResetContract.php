<?php

namespace App\Contracts\User;

interface PasswordResetContract
{

    /**
     * Generate password reset token
     */
    public function generatePasswordResetToken(): string;

    /**
     * Send password reset token to the user
     * ------------
     */
    public function sendPasswordResetToken(): void;

    /**
     * Reset user password
     * ------------
     */
    public function resetPassword(
        string $password,
        string $passwordResetToken
    ): void;

    /**
     * Remove password reset token
     * ------------
     */
    public function removePasswordResetToken(): void;

    /**
     * Check if password reset token is valid
     * ------------
     */
    public function passwordResetTokenIsValid(
        string $passwordResetToken
    ): bool;

    /**
     * Check if password reset token is expired
     */
    public function passwordResetTokenIsExpired(
        string $passwordResetToken
    ): bool;

    /**
     * Get the password reset token
     */
    public function getPasswordResetToken(): string;

}
