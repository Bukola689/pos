<?php

use App\Http\Controllers\Admin\CompanyController;
use Illuminate\Support\Facades\Route;


Route::post('companies', [CompanyController::class, 'store']);

Route::put('companies/{company}', [CompanyController::class, 'update']);
Route::DELETE('companies/{company}', [CompanyController::class, 'destroy']);
Route::get('search-companies/{search}', [CompanyController::class, 'search']);