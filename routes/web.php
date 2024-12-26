<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompensationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;

Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/verification-compensation/{id}', [RiwayatController::class, 'verification']);
Route::get('/compensations/download/{id}', [RiwayatController::class, 'download']);

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin,dosen,tendik,mahasiswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/profile', [UserController::class, 'me']);
        Route::put('/profile/update', [UserController::class, 'updateProfile']);
    });

    Route::middleware('role:admin,dosen,tendik')->group(function () {
        Route::get('/tugas', [TugasController::class, 'index']);
        Route::get('/tugas/create', [TugasController::class, 'create']);
        Route::get('/tugas/show/{id}', [TugasController::class, 'show']);
        Route::get('/tugas/request/{id}/approve', [TugasController::class, 'approvedRequest']);
        Route::get('/tugas/request/{id}/decline', [TugasController::class, 'declineRequest']);
        Route::post('/tugas', [TugasController::class, 'store']);
        Route::get('/tugas/edit/{id}', [TugasController::class, 'edit']);
        Route::put('/tugas/{id}', [TugasController::class, 'update']);
        Route::delete('/tugas/delete/{id}', [TugasController::class, 'destroy']);

        Route::get('/pengajuan', [PengajuanController::class, 'index']);
        Route::get('/pengajuan/{id}', [PengajuanController::class, 'show']);
        Route::post('/pengajuan/{id}/terima', [PengajuanController::class, 'approve']);
        Route::post('/pengajuan/{id}/tolak', [PengajuanController::class, 'decline']);
    });


    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/requests', [TasksController::class, 'index']);
        Route::get('/requests/{id}', [TasksController::class, 'show']);
        Route::post('/requests', [TasksController::class, 'store']);

        Route::get('/tasks', [TasksController::class, 'tugas']);
        Route::get('/tasks/{id}', [TasksController::class, 'detail']);
        Route::get('/tasks/request/{id}', [TasksController::class, 'request']);

        Route::get('/kompensasi', [CompensationController::class, 'index']);
        Route::get('/kompensasi/{id}', [CompensationController::class, 'show']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/mahasiswa', [UserController::class, 'mahasiswa']);
        Route::post('/mahasiswa', [UserController::class, 'mahasiswaStore']);
        Route::get('/mahasiswa/edit/{id}', [UserController::class, 'mahasiswaEdit']);
        Route::get('/mahasiswa/create', [UserController::class, 'mahasiswaCreate']);
        Route::put('/mahasiswa/update/{id}', [UserController::class, 'mahasiswaUpdate']);
        Route::delete('/mahasiswa/delete/{id}', [UserController::class, 'mahasiswaDestroy']);

        Route::post('/users/import', [AuthController::class, 'import']);
        Route::get('/users/export', [AuthController::class, 'export']);

        Route::get('/sdm', [UserController::class, 'sdm']);
        Route::post('/sdm', [UserController::class, 'sdmStore']);
        Route::get('/sdm/edit/{id}', [UserController::class, 'sdmEdit']);
        Route::get('/sdm/create', [UserController::class, 'sdmCreate']);
        Route::put('/sdm/update/{id}', [UserController::class, 'sdmUpdate']);
        Route::delete('/sdm/delete/{id}', [UserController::class, 'sdmDestroy']);

        Route::get('/kompetensi', [KompetensiController::class, 'index']);
        Route::get('/kompetensi/create', [KompetensiController::class, 'create']);
        Route::post('/kompetensi', [KompetensiController::class, 'store']);
        Route::get('/kompetensi/edit/{id}', [KompetensiController::class, 'edit']);
        Route::put('/kompetensi/update/{id}', [KompetensiController::class, 'update']);
        Route::delete('/kompetensi/delete/{id}', [KompetensiController::class, 'destroy']);

        Route::get('/prodi', [ProdiController::class, 'index']);
        Route::get('/prodi/create', [ProdiController::class, 'create']);
        Route::post('/prodi', [ProdiController::class, 'store']);
        Route::get('/prodi/edit/{id}', [ProdiController::class, 'edit']);
        Route::put('/prodi/update/{id}', [ProdiController::class, 'update']);
        Route::delete('/prodi/delete/{id}', [ProdiController::class, 'destroy']);

        Route::get('/kategori-tugas', [KategoriController::class, 'index']);
        Route::get('/kategori-tugas/create', [KategoriController::class, 'create']);
        Route::post('/kategori-tugas', [KategoriController::class, 'store']);
        Route::get('/kategori-tugas/edit/{id}', [KategoriController::class, 'edit']);
        Route::put('/kategori-tugas/update/{id}', [KategoriController::class, 'update']);
        Route::delete('/kategori-tugas/delete/{id}', [KategoriController::class, 'destroy']);

        Route::get('/periode', [PeriodeController::class, 'index']);
        Route::get('/periode/create', [PeriodeController::class, 'create']);
        Route::post('/periode/store', [PeriodeController::class, 'store']);
        Route::get('/periode/edit/{id}', [PeriodeController::class, 'edit']);
        Route::put('/periode/update/{id}', [PeriodeController::class, 'update']);
        Route::delete('/periode/delete/{id}', [PeriodeController::class, 'destroy']);

        Route::get('/riwayat', [RiwayatController::class, 'index']);
        Route::get('/riwayat/{id}', [RiwayatController::class, 'show']);
    });

    Route::get('logout', [AuthController::class, 'logout']);
});
