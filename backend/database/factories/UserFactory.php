<?php

namespace Database\Factories;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'password'       => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function verify(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the user's account should be locked
     */
    public function lock(): static
    {
        return $this->state(fn() => [
            'locked' => true,
        ]);
    }

    public function assignRole(?string $role = null): static
    {
        $roleName = $role ?: fake()
            ->randomElement(RolesEnum::class)->value;
        return $this->afterCreating(fn(User $user) => (
            $user->addRole($roleName)
        ));
    }

}
