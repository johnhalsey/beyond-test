<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('employees/{employeeId}/classes', [\App\Http\Controllers\Api\ClassesController::class, 'index'])
    ->name('api.classes.index');
