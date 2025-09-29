<?php

use App\Http\Controllers\Tenant\Auth\LoginController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

// Routes pour l'application centrale
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification pour l'application centrale
    // Gestion des tenants
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');

Route::prefix('t/{tenant}')
    ->middleware(['web', InitializeTenancyByPath::class])
    ->group(function () {

        // --- Visiteurs (non authentifiés)
        Route::middleware('guest')->group(function () {
            Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('tenant.login');
            Route::post('/login',   [LoginController::class, 'login'])->name('tenant.login.post');

            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('tenant.register');
            Route::post('/register',[RegisterController::class, 'register'])->name('tenant.register.post');
        });

        // --- Authentifiés
        Route::middleware('auth')->group(function () {
            Route::post('/logout', [LoginController::class, 'logout'])->name('tenant.logout');

            // IMPORTANT : utiliser /dashboard (et non "/") pour éviter les conflits
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

            Route::resource('/users', UserController::class);
        });
    });
