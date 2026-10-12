<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\UserController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}/print', [ReportController::class, 'print'])->name('reports.print');

    // 1. Taruh Rute Khusus Superadmin SEBELUM Rute Wildcard {id}
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('outlets', OutletController::class);
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
Route::resource('users', UserController::class);    
        });

    // 2. Rute Wildcard {id} Ditaruh di Bagian Bawah
    Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{id}/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('/api/outlets/{id}', [OutletController::class, 'getOutletDetails'])->name('api.outlets.show');
});