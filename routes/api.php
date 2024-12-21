<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskSubmissionController;
use App\Http\Controllers\Api\TaskRequestController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CompensationController;
use App\Http\Controllers\Api\ProdiController;
use App\Http\Controllers\Api\TypeTaskController;
use App\Http\Controllers\Api\CompetenceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Authentication Routes
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['authentication:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'userProfile']);

        // Dashboard Routes
        Route::get('/dashboard-students', [DashboardController::class, 'StudentDashboard'])
            ->middleware('role:mahasiswa');
        Route::get('/dashboard-sdm', [DashboardController::class, 'SdmDashboard'])
            ->middleware('role:admin,dosen,tendik');

        // Task Routes
        Route::prefix('tasks')->group(function () {
            Route::post('/store', [TaskController::class, 'store'])
                ->middleware('role:admin,dosen,tendik');
            Route::get('/student', [TaskController::class, 'getTasksForStudent'])
                ->middleware('role:mahasiswa');
            Route::get('/sdm', [TaskController::class, 'getTasksForSdm'])
                ->middleware('role:admin,dosen,tendik');
            Route::post('/update', [TaskController::class, 'update'])
                ->middleware('role:admin,dosen,tendik');
            Route::get('/{id}', [TaskController::class, 'getTaskById'])
                ->middleware('role:admin,dosen,tendik,mahasiswa');
        });

        // Task Request Routes
        Route::prefix('task-requests')->group(function () {
            Route::post('/', [TaskRequestController::class, 'submitTaskRequest'])
                ->middleware('role:admin,dosen,tendik');
            Route::get('/', [TaskRequestController::class, 'getAllTaskRequests'])
                ->middleware('role:admin,dosen,tendik');
        });

        // Task Submission Routes
        Route::prefix('submissions')->group(function () {
            Route::get('/task/{id}', [TaskSubmissionController::class, 'getSubmissionsByTaskId']);
            Route::get('/sdm', [TaskSubmissionController::class, 'getSubmissionsForSdm']);
            Route::post('/', [TaskSubmissionController::class, 'store']);
            Route::post('/{id}', [TaskSubmissionController::class, 'reviewSubmission'])
                ->middleware('role:admin,dosen,tendik');
            Route::get('/{id}', [TaskSubmissionController::class, 'getSubmissionById']);
            Route::get('/task-request/{id}', [TaskSubmissionController::class, 'requestTask']);
        });

        // Compensation Routes
        Route::prefix('compensations')->group(function () {
            Route::get('/', [CompensationController::class, 'index']);
            Route::get('/{id}', [CompensationController::class, 'show']);
        });

        // Competence Routes
        Route::get('/competences', [CompetenceController::class, 'index']);

        // Prodi Routes
        Route::get('/prodi', [ProdiController::class, 'index']);

        // Type Task Routes
        Route::get('/type-tasks', [TypeTaskController::class, 'index']);
    });
});
