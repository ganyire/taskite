<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    use HasUuids, SoftDeletes, HasFactory;

    public $guarded = ['id'];
}
