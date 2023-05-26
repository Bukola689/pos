<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;


Route::post('categories', [CategoryController::class, 'store']);
Route::put('products/categories/{id}', [CategoryController::class, 'update']);
Route::DELETE('categories/{id}', [CategoryController::class, 'destroy']);
Route::get('search-categories/{search}', [CategoryController::class, 'searchUser']);