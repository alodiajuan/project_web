<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SdmController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', [WelcomeController::class,'index']);         // menampilkan halaman awal level
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::middleware(['auth'])->group(function(){ // artinya semua route di dalam group ini harus login dulu
   // masukkan semua route yg perlu autentikasi di sini
});


Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);  // Menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']);  // Menampilkan data level dalam bentuk JSON untuk datatables
    Route::get('/{id}', [LevelController::class, 'show']);  // Menampilkan detail level
});
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);  // Menampilkan halaman awal kategori
    Route::get('/list', [KategoriController::class, 'list']);  // Menampilkan data kategori dalam bentuk JSON untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);  // Menampilkan halaman form tambah kategori
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/', [KategoriController::class, 'store']);  // Menyimpan data kategori baru
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);  // Menghapus data kategori dengan AJAX
    Route::get('/{id}', [KategoriController::class, 'show']);  // Menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // Menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);  // Menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);  // Menghapus data kategori
});
Route::group(['prefix' => 'tugas'], function () {
    Route::get('/', [TugasController::class, 'index']);  // Menampilkan halaman awal kategori
    Route::post('/list', [TugasController::class, 'list']);  // Menampilkan data kategori dalam bentuk JSON untuk datatables
    Route::get('/create', [TugasController::class, 'create']);  // Menampilkan halaman form tambah kategori
    Route::get('/create_ajax', [TugasController::class, 'create_ajax']);
    Route::post('/', [TugasController::class, 'store']);  // Menyimpan data kategori baru
    Route::post('/ajax', [TugasController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [TugasController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TugasController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TugasController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
    Route::delete('/{id}/delete_ajax', [TugasController::class, 'delete_ajax']);  // Menghapus data kategori dengan AJAX
    Route::get('/{id}', [TugasController::class, 'show']);  // Menampilkan detail kategori
    Route::get('/{id}/edit', [TugasController::class, 'edit']);  // Menampilkan halaman form edit kategori
    Route::put('/{id}', [TugasController::class, 'update']);  // Menyimpan perubahan data kategori
    Route::delete('/{id}', [TugasController::class, 'destroy']);  // Menghapus data kategori
});
Route::group(['prefix' => 'mahasiswa'], function () {
    Route::get('/', [MahasiswaController::class, 'index']);  // Menampilkan halaman awal mahasiswa
    Route::post('/list', [MahasiswaController::class, 'list']);  // Menampilkan data mahasiswa dalam bentuk JSON untuk datatables
    Route::get('/{id}', [MahasiswaController::class, 'show']);  // Menampilkan detail mahasiswa
    Route::get('/create_ajax', [MahasiswaController::class, 'create_ajax']); // Rute untuk menampilkan form create
    Route::post('/', [MahasiswaController::class, 'store']);
    Route::post('/ajax', [MahasiswaController::class, 'store_ajax']);  // Rute untuk menerima POST request dari form
});
Route::group(['prefix' => 'sdm'], function () {
    Route::get('/', [SdmController::class, 'index']);  // Menampilkan halaman awal sdm
    Route::post('/list', [SdmController::class, 'list']);  // Menampilkan data sdm dalam bentuk JSON untuk datatables
    Route::get('/create', [SdmController::class, 'create']);  // Menampilkan halaman form tambah sdm
    Route::get('/create_ajax', [SdmController::class, 'create_ajax']);
    Route::post('/', [SdmController::class, 'store']);  // Menyimpan data sdm baru
    Route::post('/ajax', [SdmController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [SdmController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [SdmController::class, 'update_ajax']);
    Route::get('/import', [SdmController::class, 'import']);  // Menampilkan form import
    Route::post('/import_ajax', [SdmController::class, 'import_ajax']);  // Proses import data
    Route::get('/export_pdf', [SdmController::class, 'export_pdf']);  // Export ke PDF
    Route::get('/export_excel', [SdmController::class, 'export_excel']);  // Export ke Excel
    Route::get('/{id}/delete_ajax', [SdmController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
    Route::delete('/{id}', [SdmController::class, 'destroy']);  // Menghapus data sdm
    Route::get('/{id}', [SdmController::class, 'show']);  // Menampilkan detail sdm
    Route::get('/{id}/edit', [SdmController::class, 'edit']);  // Menampilkan halaman form edit sdm
    Route::put('/{id}', [SdmController::class, 'update']);  // Menyimpan perubahan data sdm
});

Route::group(['prefix' => 'prodi'], function () {
    Route::get('/', [ProdiController::class, 'index']);  // Menampilkan halaman awal prodi
    Route::post('/list', [ProdiController::class, 'list']);  // Menampilkan data prodi dalam bentuk JSON untuk datatables
    Route::get('/{id}', [ProdiController::class, 'show']);  // Menampilkan detail prodi
});

