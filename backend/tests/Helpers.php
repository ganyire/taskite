<?php

use App\Enums\RolesEnum;
use App\Models\User;

/**
 * Register a new user with a team and role
 * ----------------
 */
if (!function_exists('registerUser')) {
    function registerUser(string $teamName, string $password): User
    {
        /**
         * @var User $user
         */
        $user = User::factory()
            ->create([
                'password' => $password,
            ]);
        $user->teams()->create(
            ['name' => $teamName],
            ['is_owner' => true],
        );
        $user->addRole(RolesEnum::OWNER, $user->ownedTeam);
        return $user;
    }
}

/**
 * Create a basic user profile
 * ----------------
 */
if (!function_exists('createBasicUser')) {
    function createBasicUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }
}
