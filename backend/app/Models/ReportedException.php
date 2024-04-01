<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedException extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'exception_message',
        'file',
        'line',
        'exception_trace',
        'exception_class',
    ];
}