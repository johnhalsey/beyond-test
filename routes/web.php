<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('class.index');

Route::get('employees/{employeeId}/classes/{classId}/lessons', [\App\Http\Controllers\LessonController::class, 'index']);

Route::get('error', [\App\Http\Controllers\ErrorController::class, 'index'])
    ->name('error');
