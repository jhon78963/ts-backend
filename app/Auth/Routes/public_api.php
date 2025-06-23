<?php

use App\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/refresh-token', [AuthController::class, 'refreshToken'])->name('auth.refresh');
Route::post('auth/logout', [AuthController::class,'logout'])->name('auth.logout');
