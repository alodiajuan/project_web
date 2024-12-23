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
        Route::middleware('role:admin,dosen,tendik')->group(function () {
            Route::post('/tasks/store', [TaskController::class, 'store']);
            Route::post('/tasks/update', [TaskController::class, 'update']);
            Route::get('/tasks-sdm', [TaskController::class, 'getTasksForSdm']);
        });
        Route::get('/tasks-student', [TaskController::class, 'getTasksForStudent'])
            ->middleware('role:mahasiswa');
        Route::get('/tasks/{id}', [TaskController::class, 'getTaskById'])->middleware('role:mahasiswa,admin,dosen,tendik');

        // Task Request Routes
        Route::post('/task-requests', [TaskRequestController::class, 'submitTaskRequest'])->middleware('role:mahasiswa'); // meminta request tugas dari daftar tugas
        Route::get('/AllTaskRequests', [TaskRequestController::class, 'getAllTaskRequests'])->middleware('role:mahasiswa,admin,dosen,tendik'); // menampilkan semua request tugas

        // Task Submission Routes
        Route::get('/task/{id}/submissions', [TaskSubmissionController::class, 'getSubmissionsByTaskId'])
            ->middleware('role:mahasiswa,admin,tendik,dosen');
        Route::get('/submissions-sdm', [TaskSubmissionController::class, 'getSubmissionsForSdm'])
            ->middleware('role:admin,dosen,tendik');
        Route::post('/submissions', [TaskSubmissionController::class, 'store'])
            ->middleware('role:mahasiswa');
        Route::post('/submissions/{id}', [TaskSubmissionController::class, 'reviewSubmission'])
            ->middleware('role:admin,dosen,tendik');
        Route::get('/submission/{id}', [TaskSubmissionController::class, 'getSubmissionById'])
            ->middleware('role:admin,dosen,tendik,mahasiswa');

        // Compensation Routes
        Route::prefix('compensations')->middleware('role:admin,dosen,tendik')->group(function () {
            Route::get('/', [CompensationController::class, 'index']);
            Route::get('/{id}', [CompensationController::class, 'show']);
        });

        // Competence Routes
        Route::get('/competences', [CompetenceController::class, 'index'])
            ->middleware('role:admin,dosen,tendik');

        // Prodi Routes
        Route::get('/prodi', [ProdiController::class, 'index'])
            ->middleware('role:admin,dosen,tendik');

        // Type Task Routes
        Route::get('/type-tasks', [TypeTaskController::class, 'index'])
            ->middleware('role:admin,dosen,tendik');
    });
});
