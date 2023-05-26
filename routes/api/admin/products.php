<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::DELETE('products/{id}', [ProductController::class, 'destroy']);
Route::get('search-products/{search}', [ProductController::class, 'search']);