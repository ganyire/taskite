<?php

namespace App\Enums;

enum RolesEnum: string {
    case OWNER       = 'owner';
    case SUPER_ADMIN = 'super-admin';
    case WRITER      = 'writer';
    case EDITOR      = 'editor';
    case REVIEWER    = 'reviewer';

    public function label(): ?string
    {
        return match ($this) {
            static::WRITER => 'Writer',
            static::EDITOR => 'Editor',
            static::OWNER => 'Workspace owner',
            static::SUPER_ADMIN => 'System administrator',
            static::REVIEWER => 'Reviewer',
            default => null,
        };
    }
}
