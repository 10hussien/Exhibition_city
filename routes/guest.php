<?php

use App\Http\Controllers\Api\AuthenticatedSessionController;
use App\Http\Controllers\Api\EmailVerificationNotificationController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\PasswordResetLinkController;
use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('api.register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('api.login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.reset');

    Route::post('checkNumber', [NewPasswordController::class, 'checkNumber'])
        ->name('checkNumber');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('api.password.store');
});
Route::middleware(['auth:sanctum', 'setapplang', 'throttle:6,1'])->group(function () {
    Route::get('/verify-email/{id}', [VerifyEmailController::class, 'store'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('api.verification.send');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('api.logout');
