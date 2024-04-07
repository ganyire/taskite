<?php

use App\Http\Controllers\Project\CreateProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('projects')->group(function () {
    Route::post('/', CreateProjectController::class);
});
