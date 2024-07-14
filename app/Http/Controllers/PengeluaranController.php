<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Persediaan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengeluaranExport;
use App\Imports\PengeluaranImport;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::with('persediaan')->get();
        $persediaan = Persediaan::orderBy('updated_at', 'desc')->get();
        $title = "Pengeluaran";
        $subtitle = "Halaman ini menampilkan daftar semua pengeluaran yang telah dicatat dalam sistem. Setiap entri pengeluaran mencakup informasi detail seperti jenis pengeluaran, barang terkait, harga, jumlah, deskripsi, dan tanggal pengeluaran.";
        return view('dashboard.pengeluaran', compact('pengeluaran', 'persediaan', 'title', 'subtitle'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_pengeluaran_tambah' => 'required|integer',
            'barang' => 'nullable|uuid|exists:persediaan,id_persediaan',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'deskripsi_tambah' => 'required|string',
            'tanggal_pengeluaran' => 'required|date',
        ]);
        try {
            $dataToInsert = [
                'jenis_pengeluaran' => $validatedData['jenis_pengeluaran_tambah'],
                'barang' => $validatedData['barang'],
                'harga' => $validatedData['harga'],
                'jumlah' => $validatedData['jumlah'],
                'deskripsi' => $validatedData['deskripsi_tambah'],
                'tanggal_pengeluaran' => $validatedData['tanggal_pengeluaran'],
            ];

            Pengeluaran::create($dataToInsert);

            if ($validatedData['barang']) {
                $persediaan = Persediaan::find($validatedData['barang']);
                if ($persediaan) {
                    $persediaan->jumlah_persediaan += $validatedData['jumlah'];
                    $persediaan->save();
                }
            }
            return redirect()->route('pengeluaran')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('pengeluaran')->with('error','Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        $nomor = $request->input('nomor');
        $validatedData = $request->validate([
            'jenis_pengeluaran_edit_' . $nomor => 'required|integer',
            'barang_edit_' . $nomor => 'nullable|uuid|exists:persediaan,id_persediaan',
            'harga_edit_' . $nomor => 'required|integer',
            'jumlah_edit_' . $nomor => 'required|integer',
            'deskripsi_edit_' . $nomor => 'required|string',
            'tanggal_pengeluaran_edit_' . $nomor => 'required|date',
        ]);
        
        try {
            $pengeluaran = Pengeluaran::findOrFail($id);
            $sebelum = $pengeluaran->jumlah;
            $pengeluaran->jenis_pengeluaran = $validatedData['jenis_pengeluaran_edit_'.$nomor];
            $pengeluaran->barang = $validatedData['barang_edit_'.$nomor];
            $pengeluaran->harga = $validatedData['harga_edit_'.$nomor];
            $pengeluaran->jumlah = $validatedData['jumlah_edit_'.$nomor];
            $pengeluaran->deskripsi = $validatedData['deskripsi_edit_'.$nomor];
            $pengeluaran->tanggal_pengeluaran = $validatedData['tanggal_pengeluaran_edit_'.$nomor];
            $pengeluaran->save();

            $selisih = $validatedData['jumlah_edit_'.$nomor] - $request->jumlah;

            // Update jumlah persediaan berdasarkan selisih
            if ($validatedData['barang_edit_'.$nomor]) {
                $persediaan = Persediaan::find($validatedData['barang_edit_'.$nomor]);
                if ($persediaan) {
                    $selisih = $validatedData['jumlah_edit_'.$nomor] - $sebelum;
                    if($selisih < 0){
                        $persediaan->jumlah_persediaan -= abs($selisih);
                    }else{
                        $persediaan->jumlah_persediaan += $selisih;
                    }
                    $persediaan->save();
                }
            }

            return redirect()->route('pengeluaran')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('pengeluaran')->with('error','Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();
        return redirect()->route('pengeluaran')->with('success', 'Data berhasil dihapus!');
    }

    public function export()
    {
        $fileName = 'pengeluaran_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new PengeluaranExport, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new PengeluaranImport, $file);
        } catch (\Exception $e) {
            var_dump($e);
            die;
            return redirect()->route('pengeluaran')->with('error', 'Terjadi kesalahan dalam mengimpor file: ' . $e->getMessage());
        }

        return redirect()->route('pengeluaran')->with('success', 'Data berhasil diimpor!');
    }

    public function show()
    {
        $fileName = 'pengeluaran_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new PengeluaranExport, $fileName);
    }
}