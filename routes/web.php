<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('class.index');

Route::get('classes/{classId}', [\App\Http\Controllers\ClassController::class, 'index']);

Route::get('error', [\App\Http\Controllers\ErrorController::class, 'index'])
    ->name('error');
