<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MaintenanceController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('devices', DeviceController::class);

Route::resource('spareparts', SparepartController::class);

Route::prefix('transactions')->name('transactions.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/in/create', [TransactionController::class, 'createIn'])->name('createIn');
    Route::post('/in', [TransactionController::class, 'storeIn'])->name('storeIn');
    Route::get('/out/create', [TransactionController::class, 'createOut'])->name('createOut');
    Route::post('/out', [TransactionController::class, 'storeOut'])->name('storeOut');
});

Route::get('maintenance/device/{device}', [MaintenanceController::class, 'byDevice'])->name('maintenance.byDevice');
Route::resource('maintenance', MaintenanceController::class)->except(['edit', 'update', 'destroy']);
