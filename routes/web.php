<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PersediaanController;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\Persediaan;
use App\Http\Controllers\UserController;
use Carbon\Carbon;

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
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Route::get('/dashboard', function () {
    $totalStock = Persediaan::sum('jumlah_persediaan');
    $lowStockProducts = Persediaan::select('nama_barang', 'jumlah_persediaan')
        ->orderBy('jumlah_persediaan')
        ->take(4)
        ->get();

    $topProducts = Pendapatan::with('persediaan')
        ->select('barang', 'deskripsi', DB::raw('SUM(jumlah) as total_jumlah'))
        ->groupBy('barang', 'deskripsi')
        ->orderByDesc('total_jumlah')
        ->take(4)
        ->get();

    $totalPenjualan = $topProducts->sum('total_jumlah');

    $currentMonth = Carbon::now()->month;
    $lastMonth = Carbon::now()->subMonth()->month;

    $pendapatanBulanIni = Pendapatan::whereMonth('created_at', $currentMonth)
        ->select(DB::raw('WEEK(created_at) as week'), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('week')
        ->orderBy('week')
        ->pluck('total');

    $pendapatanBulanLalu = Pendapatan::whereMonth('created_at', $lastMonth)
        ->select(DB::raw('WEEK(created_at) as week'), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('week')
        ->orderBy('week')
        ->pluck('total');

    $pengeluaranBulanIni = Pengeluaran::whereMonth('created_at', $currentMonth)
        ->select(DB::raw('WEEK(created_at) as week'), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('week')
        ->orderBy('week')
        ->pluck('total');

    $pengeluaranBulanLalu = Pengeluaran::whereMonth('created_at', $lastMonth)
        ->select(DB::raw('WEEK(created_at) as week'), DB::raw('SUM(harga * jumlah) as total'))
        ->groupBy('week')
        ->orderBy('week')
        ->pluck('total');

    $currentYear = Carbon::now()->year;

    $pendapatanPerBulan = Pendapatan::selectRaw('MONTH(tanggal_pendapatan) as month, COUNT(*) as count')
        ->whereYear('tanggal_pendapatan', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count')
        ->toArray();

    $pengeluaranPerBulan = Pengeluaran::selectRaw('MONTH(tanggal_pengeluaran) as month, COUNT(*) as count')
        ->whereYear('tanggal_pengeluaran', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count')
        ->toArray();

    $fieldVisits = DB::table('pendapatan')
        ->select(DB::raw('DAYNAME(created_at) as day'), 'deskripsi', DB::raw('count(*) as count'))
        ->where('jenis_pendapatan', 2)
        ->groupBy('day', 'deskripsi')
        ->get();

    $totalJumlahPersediaan = Persediaan::sum('jumlah_persediaan');

    $totalPendapatan = Pendapatan::whereMonth('created_at', Carbon::now()->month)
        ->sum(DB::raw('harga * jumlah'));
    $totalPengeluaran = Pengeluaran::whereMonth('created_at', Carbon::now()->month)
        ->sum(DB::raw('harga * jumlah'));
    $labaBersih = $totalPendapatan - $totalPengeluaran;
    $lastWeekPendapatan = Pendapatan::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
        ->sum(DB::raw('harga * jumlah'));

    $lastWeekPengeluaran = Pengeluaran::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
        ->sum(DB::raw('harga * jumlah'));

    $pendapatanPerubahan = $lastWeekPendapatan ? (($totalPendapatan - $lastWeekPendapatan) / $lastWeekPendapatan) * 100 : 0;
    $pengeluaranPerubahan = $lastWeekPengeluaran ? (($totalPengeluaran - $lastWeekPengeluaran) / $lastWeekPengeluaran) * 100 : 0;
    $labaPerubahan = $lastWeekPendapatan - $lastWeekPengeluaran ? (($labaBersih - ($lastWeekPendapatan - $lastWeekPengeluaran)) / ($lastWeekPendapatan - $lastWeekPengeluaran)) * 100 : 0;

    return view('dashboard/index', compact('lowStockProducts', 'totalStock', 'topProducts', 'totalPenjualan', 'fieldVisits', 'totalPendapatan', 'totalPengeluaran', 'labaBersih', 'pendapatanPerubahan', 'pengeluaranPerubahan', 'labaPerubahan', 'pendapatanBulanIni', 'pendapatanBulanLalu', 'pengeluaranBulanIni', 'pengeluaranBulanLalu', 'totalJumlahPersediaan', 'pendapatanPerBulan', 'pengeluaranPerBulan'));
})->middleware('auth')->name('dashboard');

// PENDAPATAN
Route::resource('pendapatan', PendapatanController::class)->middleware('auth');
Route::get('/pendapatan', [PendapatanController::class, 'index'])->middleware('auth')->name('pendapatan');
Route::get('/pendapatan/export', [PendapatanController::class, 'export'])->name('pendapatan.export');
Route::post('/pendapatan/import', [PendapatanController::class, 'import'])->name('pendapatan.import');

// PENGELUARAN
Route::resource('pengeluaran', PengeluaranController::class)->middleware('auth');
Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->middleware('auth')->name('pengeluaran');
Route::get('/pengeluaran/export', [PengeluaranController::class, 'export'])->name('pengeluaran.export');
Route::post('/pengeluaran/import', [PengeluaranController::class, 'import'])->name('pengeluaran.import');

// PERSEDIAAN
Route::resource('persediaan', PersediaanController::class)->middleware('auth');
Route::get('/persediaan', [PersediaanController::class, 'index'])->middleware('auth')->name('persediaan');
Route::get('/persediaan/export', [PersediaanController::class, 'export'])->name('persediaan.export');
Route::post('/persediaan/import', [PersediaanController::class, 'import'])->name('persediaan.import');

Route::middleware(['auth', 'checkadmin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');