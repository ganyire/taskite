<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Traits\Models\TeamTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    use TeamTrait;

    /**
     * The attributes that are mass assignable.
     * ------------
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
        'team_id',
    ];

    /**
     * The attributes that should be cast.
     * ------------
     */
    public function casts()
    {
        return [
            'status' => ProjectStatus::class,
        ];
    }

    /**
     * @relation
     * The owner of the project.
     * ------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @relation
     * The team that owns the project.
     * ------------
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @relation
     * Tasks that belong to the project.
     * ------------
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
