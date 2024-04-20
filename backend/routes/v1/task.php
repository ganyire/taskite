<?php

use App\Http\Controllers\Task\CreateTaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('tasks')->group(function () {
    Route::post('/', CreateTaskController::class);
});
