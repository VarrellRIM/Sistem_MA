<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('devices', DeviceController::class);
Route::resource('spareparts', SparepartController::class);

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
