<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\PengeluaranController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    if (Auth::check() && session('access_token')) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard/index');
})->middleware('auth')->name('dashboard');

Route::get('/pendapatan', function () {
    return view('dashboard/pendapatan');
})->middleware('auth')->name('pendapatan');

// PENDAPATAN
Route::resource('pendapatan', PendapatanController::class)->middleware('auth');
Route::get('/pendapatan', [PendapatanController::class, 'index'])->name('pendapatan');

// PENGELUARAN
Route::resource('pengeluaran', PengeluaranController::class)->middleware('auth');
Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');