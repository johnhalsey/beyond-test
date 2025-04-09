<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('employees/{employeeId}/classes', [\App\Http\Controllers\Api\ClassesController::class, 'index'])
    ->name('api.classes.index');

Route::get('employees/{employeeId}/lessons', [\App\Http\Controllers\Api\LessonController::class, 'index'])
    ->name('api.lessons.index');
