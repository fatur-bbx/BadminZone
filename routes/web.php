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
    if (Auth::check() && session('access_token')) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Route::get('/dashboard', function () {
    // Mengambil total ketersediaan semua barang
    $totalStock = Persediaan::sum('jumlah_persediaan');

    // Mengambil 4 barang dengan ketersediaan paling sedikit
    $lowStockProducts = Persediaan::select('nama_barang', 'jumlah_persediaan')
        ->orderBy('jumlah_persediaan')
        ->take(4)
        ->get();

    // Mendapatkan top 4 produk berdasarkan total jumlah
    $topProducts = Pendapatan::with('persediaan')
        ->select('barang', 'deskripsi', DB::raw('SUM(jumlah) as total_jumlah'))
        ->groupBy('barang', 'deskripsi')
        ->orderByDesc('total_jumlah')
        ->take(4)
        ->get();

    // Menghitung total penjualan keseluruhan
    $totalPenjualan = $topProducts->sum('total_jumlah');

    // Menghitung pendapatan per minggu berdasarkan harga * jumlah
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

    // Mengambil jumlah pendapatan dan pengeluaran per bulan di tahun ini
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

    return view('dashboard/index', compact('lowStockProducts', 'totalStock', 'topProducts', 'totalPenjualan', 'fieldVisits', 'pendapatanBulanIni', 'pendapatanBulanLalu', 'pengeluaranBulanIni', 'pengeluaranBulanLalu', 'totalJumlahPersediaan', 'pendapatanPerBulan', 'pengeluaranPerBulan'));
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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');