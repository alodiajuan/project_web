<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\AuthController;

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
    Route::get('/list', [TugasController::class, 'list']);  // Menampilkan data kategori dalam bentuk JSON untuk datatables
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
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/list', [AdminController::class, 'list'])->name('admin.list');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/', [AdminController::class, 'store'])->name('admin.store');
    Route::post('/store-ajax', [AdminController::class, 'store_ajax'])->name('admin.store_ajax');
    Route::get('/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::put('/{id}/update-ajax', [AdminController::class, 'update_ajax'])->name('admin.update_ajax');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/{id}/confirm', [AdminController::class, 'confirm_ajax'])->name('admin.confirm');
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

