<?php

use Illuminate\Support\Facades\Route;

Route::get('employees/{employeeId}/lessons', [\App\Http\Controllers\Api\LessonController::class, 'index'])
    ->name('api.lessons.index');

Route::get('classes/{classId}', [\App\Http\Controllers\Api\ClassController::class, 'show'])
    ->name('api.classes.show');
