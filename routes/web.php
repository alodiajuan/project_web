<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SdmController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UserController;

Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'postlogin']);

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin,dosen,tendik,mahasiswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/mahasiswa', [UserController::class, 'mahasiswa']);
        Route::post('/mahasiswa', [UserController::class, 'mahasiswaStore']);
        Route::get('/mahasiswa/edit/{id}', [UserController::class, 'mahasiswaEdit']);
        Route::get('/mahasiswa/create', [UserController::class, 'mahasiswaCreate']);
        Route::put('/mahasiswa/update/{id}', [UserController::class, 'mahasiswaUpdate']);
        Route::delete('/mahasiswa/delete/{id}', [UserController::class, 'mahasiswaDestroy']);

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
    });

    Route::get('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:mahasiswa,sdm')->group(function () {
//     Route::get('/', [WelcomeController::class, 'index']);
//     Route::get('logout', [AuthController::class, 'logout'])->name('logout');

//     Route::group(['prefix' => 'level'], function () {
//         Route::get('/', [LevelController::class, 'index']);  // Menampilkan halaman awal level
//         Route::post('/list', [LevelController::class, 'list']);  // Menampilkan data level dalam bentuk JSON untuk datatables
//         Route::get('/{id}', [LevelController::class, 'show']);  // Menampilkan detail level
//     });
//     Route::group(['prefix' => 'kategori'], function () {
//         Route::get('/', [KategoriController::class, 'index']);  // Menampilkan halaman awal kategori
//         Route::get('/list', [KategoriController::class, 'list']);  // Menampilkan data kategori dalam bentuk JSON untuk datatables
//         Route::get('/create', [KategoriController::class, 'create']);  // Menampilkan halaman form tambah kategori
//         Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
//         Route::post('/', [KategoriController::class, 'store']);  // Menyimpan data kategori baru
//         Route::post('/ajax', [KategoriController::class, 'store_ajax']);
//         Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
//         Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  // Menghapus data kategori dengan AJAX
//         Route::get('/{id}', [KategoriController::class, 'show']);  // Menampilkan detail kategori
//         Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // Menampilkan halaman form edit kategori
//         Route::put('/{id}', [KategoriController::class, 'update']);  // Menyimpan perubahan data kategori
//         Route::delete('/{id}', [KategoriController::class, 'destroy']);  // Menghapus data kategori
//     });
//     Route::group(['prefix' => 'tugas'], function () {
//         Route::get('/', [TugasController::class, 'index']);  // Menampilkan halaman awal kategori
//         Route::post('/list', [TugasController::class, 'list']);  // Menampilkan data kategori dalam bentuk JSON untuk datatables
//         Route::get('/create_ajax', [TugasController::class, 'create_ajax']);
//         Route::post('/ajax', [TugasController::class, 'store_ajax']);
//         Route::get('/get-last-kode', [TugasController::class, 'getLastKode']);
//         Route::get('/{id}/edit_ajax', [TugasController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [TugasController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [TugasController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
//         Route::delete('/{id}/delete_ajax', [TugasController::class, 'delete_ajax']);  // Menghapus data kategori dengan AJAX
//         Route::get('/{id}/detail_ajax', [TugasController::class, 'detail_ajax']);
//         Route::get('/{id}/show_ajax', [TugasController::class, 'show_ajax']);
//         Route::get('/{id}/pengajuan_ajax', [TugasController::class, 'pengajuan_ajax']);
//         Route::get('/{id}/request_ajax', [TugasController::class, 'request_ajax']);
//         Route::delete('/{id}', [TugasController::class, 'destroy']);  // Menghapus data kategori
//     });
//     Route::group(['prefix' => 'mahasiswa'], function () {
//         Route::get('/', [MahasiswaController::class, 'index']);  // Menampilkan halaman awal mahasiswa
//         Route::post('/list', [MahasiswaController::class, 'list'])->name('mahasiswa.list');
//         Route::get('/create_ajax', [MahasiswaController::class, 'create_ajax']); // Pindahkan sebelum /{id}
//         Route::post('/store_ajax', [MahasiswaController::class, 'store_ajax']);
//         Route::get('/{id}/edit_ajax', [MahasiswaController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [MahasiswaController::class, 'update_ajax']);
//         Route::get('/{id}/confirm_ajax', [MahasiswaController::class, 'confirm_ajax']); // Ubah ini
//         Route::get('/export_excel', [MahasiswaController::class, 'export_excel']); // Pindah ke sini
//         Route::get('/export_pdf', [MahasiswaController::class, 'export_pdf']); // Pindah ke sini
//         Route::post('/store_ajax', [MahasiswaController::class, 'store_ajax']);
//         Route::get('/import', [MahasiswaController::class, 'import']);
//         Route::post('/import_ajax', [MahasiswaController::class, 'import_ajax']);
//         Route::delete('/{id}', [MahasiswaController::class, 'destroy']);
//         Route::post('/', [MahasiswaController::class, 'store']);
//         Route::get('/{id}', [MahasiswaController::class, 'show']);  // Parameter {id} di akhir
//     });
//     Route::group(['prefix' => 'sdm'], function () {
//         Route::get('/', [SdmController::class, 'index']);  // Menampilkan halaman awal sdm
//         Route::post('/list', [SdmController::class, 'list']);  // Menampilkan data sdm dalam bentuk JSON untuk datatables
//         Route::get('/create', [SdmController::class, 'create']);  // Menampilkan halaman form tambah sdm
//         Route::get('/create_ajax', [SdmController::class, 'create_ajax']);
//         Route::post('/', [SdmController::class, 'store']);  // Menyimpan data sdm baru
//         Route::post('/ajax', [SdmController::class, 'store_ajax']);
//         Route::get('/{id}/edit_ajax', [SdmController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [SdmController::class, 'update_ajax']);
//         Route::get('/import', [SdmController::class, 'import']);  // Menampilkan form import
//         Route::post('/import_ajax', [SdmController::class, 'import_ajax']);  // Proses import data
//         Route::get('/export_pdf', [SdmController::class, 'export_pdf']);  // Export ke PDF
//         Route::get('/export_excel', [SdmController::class, 'export_excel']);  // Export ke Excel
//         Route::get('/{id}/delete_ajax', [SdmController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
//         Route::delete('/{id}', [SdmController::class, 'destroy']);  // Menghapus data sdm
//         Route::get('/{id}', [SdmController::class, 'show']);  // Menampilkan detail sdm
//         Route::get('/{id}/edit', [SdmController::class, 'edit']);  // Menampilkan halaman form edit sdm
//         Route::put('/{id}', [SdmController::class, 'update']);  // Menyimpan perubahan data sdm
//     });

//     Route::group(['prefix' => 'prodi'], function () {
//         Route::get('/', [ProdiController::class, 'index']);  // Menampilkan halaman awal prodi
//         Route::post('/list', [ProdiController::class, 'list']);  // Menampilkan data prodi dalam bentuk JSON untuk datatables
//         Route::get('/{id}', [ProdiController::class, 'show']);  // Menampilkan detail prodi
//     });
// });
