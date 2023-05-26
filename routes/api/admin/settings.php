<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('settings/{setting}', [SettingController::class, 'show']);
Route::put('settings/{setting}', [SettingController::class, 'update']);