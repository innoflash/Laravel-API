<?php

use Illuminate\Support\Facades\Route;
use App\Auth\Controllers\PasswordResetController;

Route::prefix('auth')
     ->name('auth.')
     ->middleware('auth:web')
     ->group(function () {
         Route::view('reset-password', 'auth.reset-password')
              ->name('reset-password');
         Route::post('reset-password', PasswordResetController::class)
              ->name('post.reset-password');
     });

Route::view('success-response', 'success')
     ->name('response.success');
