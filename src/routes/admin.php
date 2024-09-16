<?php

use Illuminate\Support\Facades\Route;
use DK\QuickCms\Controllers\DashboardController;
use DK\QuickCms\Controllers\Auth\LoginController;

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('quick-cms.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('quick-cms.login');
Route::post('admin/logout', [LoginController::class, 'logout'])->name('quick-cms.logout');

// Protect admin routes with middleware
Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('quick-cms.dashboard');
});
