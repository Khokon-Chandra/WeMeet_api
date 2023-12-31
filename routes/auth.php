<?php

use App\Http\Controllers\Auth\AuthenticatedTokenController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedTokenController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth:user', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:user', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedTokenController::class, 'destroy'])
    ->middleware('auth:user')
    ->name('logout');




/**
 * Admin Auth
 */
Route::post('admin/login', [AuthenticatedTokenController::class, 'store'])
    ->middleware('guest','admin.guard')
    ->name('admin.login');
    Route::post('admin/logout', [AuthenticatedTokenController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('admin.logout');