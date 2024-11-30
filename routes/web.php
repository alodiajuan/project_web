<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\SdmController;
use App\Http\Controllers\KompetensiController;
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
    Route::get('/create', [LevelController::class, 'create']);  // Menampilkan halaman form tambah level
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/', [LevelController::class, 'store']);  // Menyimpan data level baru
    Route::post('/ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::get('/{id}', [LevelController::class, 'show']);  // Menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  // Menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);  // Menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']);  // Menghapus data level
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
Route::prefix('mahasiswa')->group(function () {
    Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::post('/list', [MahasiswaController::class, 'list'])->name('mahasiswa.list');
    Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::post('/store-ajax', [MahasiswaController::class, 'store_ajax'])->name('mahasiswa.store_ajax');
    Route::get('/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::put('/{id}/update-ajax', [MahasiswaController::class, 'update_ajax'])->name('mahasiswa.update_ajax');
    Route::delete('/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    Route::get('/{id}/confirm', [MahasiswaController::class, 'confirm_ajax'])->name('mahasiswa.confirm');
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
    Route::get('/{id}/delete_ajax', [SdmController::class, 'confirm_ajax']);  // Menampilkan halaman konfirmasi hapus
    Route::delete('/{id}', [SdmController::class, 'destroy']);  // Menghapus data sdm
    Route::get('/{id}', [SdmController::class, 'show']);  // Menampilkan detail sdm
    Route::get('/{id}/edit', [SdmController::class, 'edit']);  // Menampilkan halaman form edit sdm
    Route::put('/{id}', [SdmController::class, 'update']);  // Menyimpan perubahan data sdm
});

Route::prefix('kompetensi')->group(function () {
    Route::get('/', [KompetensiController::class, 'index'])->name('kompetensi.index');
    Route::get('/create', [KompetensiController::class, 'create'])->name('kompetensi.create');
    Route::post('/', [KompetensiController::class, 'store'])->name('kompetensi.store');
    Route::post('/ajax', [KompetensiController::class, 'store_ajax'])->name('kompetensi.store_ajax');
    Route::get('/{id}', [KompetensiController::class, 'show'])->name('kompetensi.show');
    Route::get('/{id}/edit', [KompetensiController::class, 'edit'])->name('kompetensi.edit');
    Route::put('/{id}', [KompetensiController::class, 'update'])->name('kompetensi.update');
    Route::put('/{id}/edit_ajax', [KompetensiController::class, 'update_ajax'])->name('kompetensi.update_ajax');
    Route::delete('/{id}', [KompetensiController::class, 'destroy'])->name('kompetensi.destroy');
    Route::get('/{id}/delete_ajax', [KompetensiController::class, 'confirm_ajax'])->name('kompetensi.confirm_ajax');
    Route::post('/import_ajax', [KompetensiController::class, 'import_ajax'])->name('kompetensi.import_ajax');
 });

