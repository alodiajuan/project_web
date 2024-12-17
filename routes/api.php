<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskSubmissionController;
use App\Http\Controllers\Api\TaskRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // auth
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/userProfile', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum'])->group(function () {
        // task
        Route::post('/tasks', [TaskController::class, 'store'])
            ->middleware('role:admin,dosen,tendik');

        Route::get('/tasks', [TaskController::class, 'index']);

        // taskRequest
        Route::post('/task-requests', [TaskRequestController::class, 'submitTaskRequest']); // Submit task request (by mahasiswa)
        Route::post('/task-requests/process', [TaskRequestController::class, 'processTaskRequest'])  // Process task request (by admin, dosen, tendik)
            ->middleware('role:admin,dosen,tendik');
        Route::get('/task-requests', [TaskRequestController::class, 'getAllTaskRequests'])
            ->middleware('role:admin,dosen,tendik'); // Get all task requests from mahasiswa (for admin, dosen, tendik)


        // taskSubmissions
        Route::post('/task-submissions', [TaskSubmissionController::class, 'store'])
            ->middleware('role:admin,dosen,tendik,mahasiswa');
    });
});
