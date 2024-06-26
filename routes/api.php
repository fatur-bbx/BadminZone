<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersediaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('persediaan', PersediaanController::class);
Route::apiResource('pengeluaran', PengeluaranController::class);
Route::apiResource('pendapatan', PendapatanController::class);
Route::apiResource('users', UserController::class);

// Autentikasi
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user-profile', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');