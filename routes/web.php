<?php

use App\Http\Controllers\ConnectionsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('connections', ConnectionsController::class)
    ->only(['index', 'store', 'update']);

require __DIR__ . '/auth.php';
