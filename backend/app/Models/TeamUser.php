<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{
    use HasUuids;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'team_user';

    /**
     * Get attributes that should be casts
     *
     * @return array
     */
    protected function casts()
    {
        return [
            'is_owner' => "boolean",
        ];
    }

}
