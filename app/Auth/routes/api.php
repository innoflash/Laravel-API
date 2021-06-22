<?php

use Illuminate\Support\Facades\Route;
use App\Auth\Controllers\LoginController;
use App\Auth\Controllers\UserCreateController;
use App\Auth\Controllers\ForgotPasswordController;

Route::post('login', LoginController::class)
     ->withoutMiddleware(['auth:api'])
     ->name('login');
Route::post('register', UserCreateController::class)
     ->withoutMiddleware(['auth:api'])
     ->name('register');
Route::post('forgot-password', ForgotPasswordController::class)
     ->withoutMiddleware(['auth:api'])
     ->name('forgot-password');
