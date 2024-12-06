<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;


Route::post('/login', LoginController::class);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});