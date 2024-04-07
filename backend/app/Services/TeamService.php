<?php

namespace App\Services;

use App\Exceptions\ModelMissingException;
use App\Models\Team;
use Exception;

class TeamService
{

    /**
     * Get team by unique keys - id or name
     * ------------
     */
    public static function getTeamByUniqueKeys(string $search): ?Team
    {
        try {
            $team = Team::query()->where('id', $search)->orWhere('name', $search)->firstOrFail();
            return $team;
        } catch (Exception $e) {
            throw new ModelMissingException(
                httpCode: 422,
                model: 'Team'
            );
        }

    }
}
