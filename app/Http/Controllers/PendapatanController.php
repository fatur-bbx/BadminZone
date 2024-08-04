<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendapatan;
use App\Models\invoices;
use App\Models\Persediaan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendapatanExport;
use App\Imports\PendapatanImport;

// use Illuminate\Support\Facades\Http;

class PendapatanController extends Controller
{
    public function index()
    {
        $pendapatan = Pendapatan::with('persediaan')->orderBy('tanggal_pendapatan','desc')->get();
        $persediaan = Persediaan::orderBy('updated_at', 'desc')->get();
        $title = "Pendapatan";
        foreach($pendapatan as $p){
            $invoices = invoices::where("id_pendapatan", $p->id_pendapatan)->first();
            if($invoices){
                $p['invoice'] = $invoices->id_faktur;
            }else{
                $p['invoice'] = 0;
            }
        }
        $subtitle = "Halaman ini menampilkan daftar semua pendapatan yang telah dicatat dalam sistem. Setiap entri pendapatan mencakup informasi detail seperti jenis pendapatan, barang terkait, harga, jumlah, deskripsi, dan tanggal pendapatan.";
        return view('dashboard.pendapatan', compact('pendapatan', 'title', 'subtitle', 'persediaan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_pendapatan_tambah' => 'required|integer',
            'barang_tambah' => 'nullable|uuid|exists:persediaan,id_persediaan',
            'harga_tambah' => 'required|integer',
            'jumlah_tambah' => 'required|integer',
            'deskripsi_tambah' => 'required|string',
            'tanggal_pendapatan_tambah' => 'required|date',
        ]);

        try {
            // Insert data pendapatan
            $dataToInsert = [
                'jenis_pendapatan' => $validatedData['jenis_pendapatan_tambah'],
                'barang' => $validatedData['barang_tambah'],
                'harga' => $validatedData['harga_tambah'],
                'jumlah' => $validatedData['jumlah_tambah'],
                'deskripsi' => $validatedData['deskripsi_tambah'],
                'tanggal_pendapatan' => $validatedData['tanggal_pendapatan_tambah'],
            ];

            $pendapatan = Pendapatan::create($dataToInsert);

            // Update persediaan jika barang_tambah tidak null
            if ($validatedData['barang_tambah']) {
                $persediaan = Persediaan::find($validatedData['barang_tambah']);
                if ($persediaan) {
                    $persediaan->jumlah_persediaan += $validatedData['jumlah_tambah'];
                    $persediaan->save();
                }
            }

            // Hitung nomor invoice hari ini
            $today = now()->format('Y-m-d');
            $invoiceCountToday = invoices::whereDate('created_at', $today)->count() + 1;
            $invoiceNumber = str_pad($invoiceCountToday, 4, '0', STR_PAD_LEFT);

            // Buat nama invoice
            $invoiceName = $invoiceNumber . '/' . now()->format('Ymd') . '/' . auth()->user()->name;

            $invoiceData = [
                'nama_faktur' => $invoiceName,
                'handle_faktur' => auth()->user()->email,
                'id_pendapatan' => $pendapatan->id_pendapatan,
                'email_handle_faktur' => auth()->user()->email,
                'created_at' => now(),
            ];

            invoices::create($invoiceData);

            return redirect()->route('pendapatan')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('pendapatan')->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $nomor = $request->input('nomor');
        $validatedData = $request->validate([
            'jenis_pendapatan_edit_' . $nomor => 'required|integer',
            'barang_edit_' . $nomor => 'nullable|uuid|exists:persediaan,id_persediaan',
            'harga_edit_' . $nomor => 'required|integer',
            'jumlah_edit_' . $nomor => 'required|integer',
            'deskripsi_edit_' . $nomor => 'required|string',
            'tanggal_pendapatan_edit_' . $nomor => 'required|date',
        ]);

        try {
            $pendapatan = Pendapatan::findOrFail($id);
            $sebelum = $pendapatan->jumlah;
            $pendapatan->jenis_pendapatan = $validatedData['jenis_pendapatan_edit_' . $nomor];
            $pendapatan->barang = $validatedData['barang_edit_' . $nomor];
            $pendapatan->harga = $validatedData['harga_edit_' . $nomor];
            $pendapatan->jumlah = $validatedData['jumlah_edit_' . $nomor];
            $pendapatan->deskripsi = $validatedData['deskripsi_edit_' . $nomor];
            $pendapatan->tanggal_pendapatan = $validatedData['tanggal_pendapatan_edit_' . $nomor];
            $pendapatan->save();

            $selisih = $validatedData['jumlah_edit_' . $nomor] - $request->jumlah;

            // Update jumlah persediaan berdasarkan selisih
            if ($validatedData['barang_edit_' . $nomor]) {
                $persediaan = Persediaan::find($validatedData['barang_edit_' . $nomor]);
                if ($persediaan) {
                    $selisih = $validatedData['jumlah_edit_' . $nomor] - $sebelum;
                    if ($selisih < 0) {
                        $persediaan->jumlah_persediaan -= abs($selisih);
                    } else {
                        $persediaan->jumlah_persediaan += $selisih;
                    }
                    $persediaan->save();
                }
            }

            return redirect()->route('pendapatan')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('pendapatan')->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->delete();
        return redirect()->route('pendapatan')->with('success', 'Data berhasil dihapus!');
    }

    public function export()
    {
        $fileName = 'pendapatan_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new PendapatanExport, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new PendapatanImport, $file);
        } catch (\Exception $e) {
            var_dump($e);
            die;
            return redirect()->route('pendapatan')->with('error', 'Terjadi kesalahan dalam mengimpor file: ' . $e->getMessage());
        }

        return redirect()->route('pendapatan')->with('success', 'Data berhasil diimpor!');
    }

    public function show()
    {
        $fileName = 'pendapatan_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new PendapatanExport, $fileName);
    }
}
