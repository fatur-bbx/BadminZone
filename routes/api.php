<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersediaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PendapatanController;

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