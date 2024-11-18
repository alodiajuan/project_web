<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [WelcomeController::class,'index']);         // menampilkan halaman awal level

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
    Route::post('/list', [KategoriController::class, 'list']);  // Menampilkan data kategori dalam bentuk JSON untuk datatables
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

