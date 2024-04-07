<?php

namespace App\Enums;

enum ProjectStatus: string {
    case Pending   = 'pending';
    case Completed = 'completed';
}
