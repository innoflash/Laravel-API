<?php

use Illuminate\Support\Facades\Route;
use App\Auth\Controllers\LoginController;
use App\Auth\Controllers\UserCreateController;

Route::post('login', LoginController::class)
     ->withoutMiddleware(['auth:api'])
     ->name('login');
Route::post('register', UserCreateController::class)
     ->withoutMiddleware(['auth:api'])
     ->name('register');
