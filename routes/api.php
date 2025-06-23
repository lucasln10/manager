<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login-jwt', [AuthController::class,'login'])->name('login.jwt');

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
