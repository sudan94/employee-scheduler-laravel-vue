<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduledChangeController;

// Employee API (CRUD)
Route::apiResource('employees', EmployeeController::class);

// Scheduled Changes API (Only Store)
Route::post('/scheduled-changes', [ScheduledChangeController::class, 'store']);
Route::get('/scheduled-changes', [ScheduledChangeController::class, 'index']);

