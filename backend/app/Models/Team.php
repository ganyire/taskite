<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laratrust\Models\Team as LaratrustTeam;

class Team extends LaratrustTeam
{
    use HasUuids, SoftDeletes, HasFactory;

    public $guarded = ['id'];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => (
                str($value)->replace(' ', '-')->lower()->toString()
            )
        );
    }

    protected function displayName(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value = null, array $attributes) => (
                $value ?: str($attributes['name'])->replace('-', ' ')
                    ->lower()->ucfirst()->toString()
            )
        );
    }

    /**
     * @relation - Users that belong to this team
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TeamUser::class);
    }
}
