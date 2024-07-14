<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persediaan;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PersediaanExport;
use App\Imports\PersediaanImport;

class PersediaanController extends Controller
{
    public function index()
    {
        $persediaan = Persediaan::orderBy('updated_at', 'desc')->get();
        $title = "Persediaan";
        $subtitle = "Halaman ini menampilkan daftar semua persediaan yang telah dicatat dalam sistem. Setiap entri persediaan mencakup informasi detail seperti nama barang, harga barang, jumlah, dan harga.";
        return view('dashboard.persediaan', compact('persediaan', 'title', 'subtitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'harga_pcs' => 'required|integer',
            'jumlah_persediaan' => 'required|integer',
        ]);

        $data = $request->all();
        $data['id_persediaan'] = Str::uuid()->toString();

        Persediaan::create($data);
        return redirect()->route('persediaan')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'sometimes|string',
            'harga_pcs' => 'sometimes|integer',
            'jumlah_persediaan' => 'sometimes|integer',
        ]);

        $persediaan = Persediaan::findOrFail($id);
        $persediaan->update($request->all());
        return redirect()->route('persediaan')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $persediaan = Persediaan::findOrFail($id);
        $persediaan->delete();
        return redirect()->route('persediaan')->with('success', 'Data berhasil dihapus!');
    }

    public function export()
    {
        $fileName = 'persediaan_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new PersediaanExport, $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new PersediaanImport, $file);
        } catch (\Exception $e) {
            var_dump($e);
            die;
            return redirect()->route('persediaan')->with('error', 'Terjadi kesalahan dalam mengimpor file: ' . $e->getMessage());
        }

        return redirect()->route('persediaan')->with('success', 'Data berhasil diimpor!');
    }

    public function show()
    {
        $fileName = 'persediaan_' . auth()->user()->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new PersediaanExport, $fileName);
    }
}
