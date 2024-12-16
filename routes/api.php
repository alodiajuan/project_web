<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // auth 
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/userProfile', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');

    // task
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/tasks', [TaskController::class, 'store'])
             ->name('api.tasks.store')
             ->middleware('role:admin,dosen,tendik');

             Route::get('/tasks', [TaskController::class, 'index']);
    });

    // competence

    // prodi

    // taskRequest

    // taskSubmissions
});