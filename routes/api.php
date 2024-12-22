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
        // download file otomatis
        Route::middleware(['role:mahasiswa'])->get('/download/{filename}', function ($filename) {
            $filePath = storage_path('app/public/task/' . $filename);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            }

            return response()->json([
                'status' => false,
                'message' => 'File tidak ditemukan'
            ], 404);
        })->name('download.task');

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
        Route::prefix('task-requests')->middleware('role:admin,dosen,tendik')->group(function () {
            Route::post('/', [TaskRequestController::class, 'submitTaskRequest']);
            Route::get('/', [TaskRequestController::class, 'getAllTaskRequests']);
        });

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
