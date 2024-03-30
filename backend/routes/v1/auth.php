<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SendEmailVerificationCodeController;
use App\Http\Controllers\Auth\SendPasswordResetTokenController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/email/verification-code', SendEmailVerificationCodeController::class);
    Route::post('/email/verify', VerifyEmailController::class);
    Route::post('/password/reset-token', SendPasswordResetTokenController::class);
    Route::post('/password/reset', ResetPasswordController::class);
});
