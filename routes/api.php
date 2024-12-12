<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Http\Request;


Route::post('/login', LoginController::class);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tugas', [TugasController::class, 'index']);
Route::post('tugas', [TugasController::class, 'store']);
Route::get('tugas/{tugas}', [TugasController::class, 'show']);
Route::put('tugas/{tugas}', [TugasController::class, 'update']);
Route::delete('tugas/{tugas}', [TugasController::class, 'destroy']);
// Route::middleware('auth:sanctum')->get('/tugas/beranda', [TugasController::class, 'beranda']);
