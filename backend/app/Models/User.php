<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Contracts\User\PasswordResetContract;
use App\Traits\Auth\PasswordResetTrait;
use App\Traits\Models\UserTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements LaratrustUser, PasswordResetContract
{
    use HasFactory, Notifiable, HasUuids, HasApiTokens, SoftDeletes;
    use HasRolesAndPermissions, UserTrait;
    use PasswordResetTrait;
    // use PasswordsCanResetPassword;

    /**
     * The attributes that are mass assignable.
     * ------------
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * ------------
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * ------------
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'locked' => 'boolean',
        ];
    }

    /**
     * @attribute
     * The team that the user owns
     * ------------
     */
    public function ownedTeam(): Attribute
    {
        return Attribute::get(
            fn() => $this->teams()
                ->wherePivot(
                    column: 'is_owner',
                    operator: '=',
                    value: true
                )->first()
        );
    }

    /**
     * @relation
     * Teams that belong to this user
     * ------------
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->using(TeamUser::class)
            ->withPivot([
                'is_owner',
            ]);
    }

    /**
     * @relation
     * Projects that belong to this user
     * ------------
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

}
