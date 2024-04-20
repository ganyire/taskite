<?php

namespace App\Enums;

enum RolesEnum: string {
    case Owner = 'owner';
    case SuperAdmin = 'super-admin';
    case Writer = 'writer';
    case Editor = 'editor';
    case Reviewer = 'reviewer';

    /**
     * Get human readable representation of the role enum value.
     * ------------
     */
    public function label(): string
    {
        return match ($this) {
            static::Writer => 'Writer',
            static::Editor => 'Editor',
            static::Owner => 'Workspace owner',
            static::SuperAdmin => 'System administrator',
            static::Reviewer => 'Reviewer',
        };
    }

    /**
     * Get human readable label from role.
     * ------------
     */
    public static function getLabelFromRole(string $role): string
    {
        return match ($role) {
            static::Writer->value => static::Writer->label(),
            static::Editor->value => static::Editor->label(),
            static::Owner->value => static::Owner->label(),
            static::SuperAdmin->value => static::SuperAdmin->label(),
            static::Reviewer->value => static::Reviewer->label(),
        };
    }

    /**
     * Get list of roles.
     * ------------
     */
    public static function list(bool $humanReadable = false): array
    {
        if ($humanReadable) {
            return [
                static::Writer->label(),
                static::Editor->label(),
                static::Owner->label(),
                static::SuperAdmin->label(),
                static::Reviewer->label(),
            ];
        }
        return [
            static::Writer->value,
            static::Editor->value,
            static::Owner->value,
            static::SuperAdmin->value,
            static::Reviewer->value,
        ];
    }
}
