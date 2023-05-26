<?php

use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('suppliers', [SupplierController::class, 'index']);
Route::post('suppliers', [SupplierController::class, 'store']);
Route::get('suppliers/{supplier}', [SupplierController::class, 'show']);
Route::put('suppliers/{supplier}', [SupplierController::class, 'update']);
Route::DELETE('suppliers/{supplier}', [SupplierController::class, 'destroy']);
Route::get('search-suppliers/{search}', [SupplierController::class, 'search']);