<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')
     ->name('auth.')
     ->group(function () {
         Route::view('reset-password', 'auth.reset-password')
              ->middleware(['auth:web'])
              ->name('reset-password');
     });
