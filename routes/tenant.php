<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\UserController;
use App\Http\Controllers\Tenant\DashboardController;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

// Toutes les routes tenant sous /t/{tenant}
Route::prefix('t/{tenant}')
    ->middleware(['web', InitializeTenancyByPath::class])
    ->group(function () {

        // --- Guests (non authentifiés)
        Route::middleware('guest')->group(function () {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('tenant.login');
            Route::post('/login', [LoginController::class, 'login'])->name('tenant.login.post');

            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('tenant.register');
            Route::post('/register', [RegisterController::class, 'register'])->name('tenant.register.post');
        });

        // --- Authentifiés
        Route::middleware('auth')->group(function () {
            Route::post('/logout', [LoginController::class, 'logout'])->name('tenant.logout');

            // Dashboard (évite "/" qui entrait en conflit)
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

            // Gestion des utilisateurs
            Route::resource('/users', UserController::class);
        });
    });
