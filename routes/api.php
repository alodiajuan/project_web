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
        Route::post('/update-profile', [AuthController::class, 'update']);
        Route::get('/profile', [AuthController::class, 'userProfile']);
        Route::get('/me', [AuthController::class, 'me']);

        // Compensation Routes
        Route::middleware('role:mahasiswa')->group(function () {
            Route::get('/compensations', [CompensationController::class, 'index']);
            Route::get('/compensations/{id}', [CompensationController::class, 'show']);
        });

        Route::middleware('role:mahasiswa')->group(function () {
            Route::get('/tasks/student', [TaskController::class, 'getTasksForStudent']);
            Route::get('/tasks/student/{id}', [TaskController::class, 'getTaskStudentById']);
            Route::get('/tasks/request/{id}', [TaskController::class, 'requestTask']);
            Route::get('/tasks/student/{id}/submissions', [TaskController::class, 'getTaskSubmissions']);
            Route::post('/tasks/submit', [TaskController::class, 'submitTask']);
        });


        Route::middleware('role:admin,dosen,tendik')->group(function () {
            Route::get('/task-submissions', [TaskSubmissionController::class, 'taskSubmissions']);
            Route::put('/task-submissions/{id}/approve', [TaskSubmissionController::class, 'approveSubmission']);
            Route::put('/task-submissions/{id}/decline', [TaskSubmissionController::class, 'declineSubmission']);
            Route::get('/tasks', [TaskController::class, 'index']);
            Route::post('/tasks/store', [TaskController::class, 'store']);
            Route::post('/tasks/{id}/update', [TaskController::class, 'update']);
            Route::delete('/tasks/{id}', [TaskController::class, 'delete']);
            Route::get('/tasks/sdm', [TaskController::class, 'getTasksForSdm']);
            Route::get('/tasks/sdm/{id}', [TaskController::class, 'getTaskById']);
        });

        // Competence Routes
        Route::get('/competences', [CompetenceController::class, 'index']);

        // Prodi Routes
        Route::get('/prodi', [ProdiController::class, 'index']);

        // Type Task Routes
        Route::get('/type-tasks', [TypeTaskController::class, 'index']);

        // Dashboard Routes
        Route::get('/dashboard-students', [DashboardController::class, 'StudentDashboard'])
            ->middleware('role:mahasiswa');
        // download file otomatis
        Route::middleware(['role:mahasiswa'])->get('/compensations/download/{id}', [CompensationController::class, 'download']);

        Route::get('/dashboard-sdm', [DashboardController::class, 'SdmDashboard'])
            ->middleware('role:admin,dosen,tendik');

        Route::get('/tasks-student', [TaskController::class, 'getTasksForStudent'])
            ->middleware('role:mahasiswa');
        Route::get('/tasks/{id}', [TaskController::class, 'getTaskById'])->middleware('role:mahasiswa,admin,dosen,tendik');

        // // Task Request Routes
        // Route::prefix('task-requests')->middleware('role:admin,dosen,tendik')->group(function () {
        //     Route::post('/', [TaskRequestController::class, 'submitTaskRequest']);
        //     Route::get('/', [TaskRequestController::class, 'getAllTaskRequests']);
        // });

        // Task Submission Routes
        Route::get('/task/{id}', [TaskSubmissionController::class, 'getSubmissionsByTaskId'])
            ->middleware('role:mahasiswa');
        Route::get('/sdm', [TaskSubmissionController::class, 'getSubmissionsForSdm'])
            ->middleware('role:admin,dosen,tendik');
        Route::post('/submissions', [TaskSubmissionController::class, 'store'])
            ->middleware('role:mahasiswa');
        Route::post('/{id}', [TaskSubmissionController::class, 'reviewSubmission'])
            ->middleware('role:admin,dosen,tendik');
        Route::get('/{id}', [TaskSubmissionController::class, 'getSubmissionById'])
            ->middleware('role:admin,dosen,tendik,mahasiswa');

        Route::get('/task-request/{id}', [TaskSubmissionController::class, 'requestTask'])
            ->middleware('role:admin,dosen,tendik');
        Route::get('/task-request/{id}/approve', [TaskSubmissionController::class, 'approveRequest'])
            ->middleware('role:admin,dosen,tendik');
        Route::get('/task-request/{id}/decline', [TaskSubmissionController::class, 'declineRequest'])
            ->middleware('role:admin,dosen,tendik');
    });
});
