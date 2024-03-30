<?php

if (!function_exists('tokenLength')) {
    /**
     * Get the token length from the config file
     */
    function tokenLength(): int
    {
        return (int) config('app.token_length', 6);
    }
}

if (!function_exists('passwordTokenExpiration')) {
    /**
     * Get the password token expiration time from the config file
     */
    function passwordTokenExpiration(): int
    {
        return (int) config("auth.passwords.users.expire", 30);
    }
}

if (!function_exists('getTimeToExpireToken')) {
    /**
     * Create a time in minutes to expire the token
     */
    function getTimeToExpireToken(): int
    {
        return (int) config('auth.passwords.users.expire', 30) + 1;
    }
}
