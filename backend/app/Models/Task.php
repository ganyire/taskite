<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     * ------------
     */
    protected function casts(): array
    {
        return [
            'status' => TaskStatusEnum::class,
            'due_date' => 'datetime',
        ];
    }

    /**
     * @relation
     * The project that owns the task.
     * ------------
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @relation
     * The todos that belong to the task.
     * ------------
     */
    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }
}
