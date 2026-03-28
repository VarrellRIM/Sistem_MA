<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

// ── Auth Routes ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated Routes ──
// Dashboard - accessible to all authenticated users
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Admin routes - only admin can access CRUD devices and spareparts
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('devices', DeviceController::class);
    Route::resource('spareparts', SparepartController::class);
});

// Technician routes - technician and admin can manage transactions and maintenance
Route::middleware(['auth', 'role:technician,admin'])->group(function () {
    Route::prefix('transactions')->name('transactions.')->controller(TransactionController::class)->group(function () {
        Route::get('/',            'index')->name('index');
        Route::get('/in/create',   'createIn')->name('createIn');
        Route::post('/in',         'storeIn')->name('storeIn');
        Route::get('/out/create',  'createOut')->name('createOut');
        Route::post('/out',        'storeOut')->name('storeOut');
    });

    Route::get('maintenance/device/{device}', [MaintenanceController::class, 'byDevice'])
        ->name('maintenance.byDevice');

    Route::resource('maintenance', MaintenanceController::class)
        ->except(['edit', 'update', 'destroy']);
});

// Viewer routes - read-only access to devices and spareparts (everyone can read)
Route::middleware(['auth', 'role:viewer,technician,admin'])->group(function () {
    // Viewers can only view devices and spareparts (show already included in admin routes above)
    Route::get('devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
    Route::get('spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
    Route::get('spareparts/{sparepart}', [SparepartController::class, 'show'])->name('spareparts.show');
});
