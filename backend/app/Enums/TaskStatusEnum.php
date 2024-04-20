<?php

namespace App\Enums;

enum TaskStatusEnum: string {
    case Waiting = 'waiting';
    case InProgress = 'in_progress';
    case OnHold = 'on_hold';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    /**
     * Get human readable representation of the status enum value.
     * ------------
     */
    public function label(): string
    {
        return match ($this) {
            self::Waiting => 'Waiting',
            self::InProgress => 'In Progress',
            self::OnHold => 'On Hold',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    /**
     * Get human readable label from status.
     * ------------
     */
    public static function getLabelFromStatus(string $status): string
    {
        return match ($status) {
            self::Waiting->value => self::Waiting->label(),
            self::InProgress->value => self::InProgress->label(),
            self::OnHold->value => self::OnHold->label(),
            self::Completed->value => self::Completed->label(),
            self::Cancelled->value => self::Cancelled->label(),
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
                self::Waiting->label(),
                self::InProgress->label(),
                self::OnHold->label(),
                self::Completed->label(),
                self::Cancelled->label(),
            ];
        }
        return [
            self::Waiting->value,
            self::InProgress->value,
            self::OnHold->value,
            self::Completed->value,
            self::Cancelled->value,
        ];
    }

}
