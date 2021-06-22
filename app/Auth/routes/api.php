<?php

use Illuminate\Support\Facades\Route;
use App\Auth\Controllers\LoginController;

Route::post('login', LoginController::class)
     ->withoutMiddleware(['auth:api'])
     ->name('login');
