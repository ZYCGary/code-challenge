<?php

use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')
    ->namespace('Api')
    ->group(function () {
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    });
