<?php

namespace App\Enums;

enum ProjectStatus: string {

    case Pending = 'pending';
    case Completed = 'completed';

    /**
     * Get human readable representation of the status enum value.
     * ------------
     */
    public function label(): string
    {
        return match ($this) {
            static::Pending => 'Pending',
            static::Completed => 'Completed',
        };
    }

    /**
     * Get human readable label from status.
     * ------------
     */
    public static function getLabelFromStatus(string $status): string
    {
        return match ($status) {
            static::Pending->value => static::Pending->label(),
            static::Completed->value => static::Completed->label(),
        };
    }

    /**
     * Get list of statuses.
     * ------------
     */
    public static function list(bool $humanReadable = false): array
    {
        if ($humanReadable) {
            return [
                static::Pending->label(),
                static::Completed->label(),
            ];
        }
        return [
            static::Pending->value,
            static::Completed->value,
        ];
    }
}
