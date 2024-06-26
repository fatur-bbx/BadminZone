<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::with('persediaan')->get();
        return view('dashboard.pengeluaran', compact('pengeluaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pengeluaran' => 'required|integer',
            'barang' => 'nullable|uuid|exists:persediaan,id_persediaan',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'deskripsi' => 'required|string',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        Pengeluaran::create($request->all());
        return redirect()->route('pengeluaran')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_pengeluaran' => 'sometimes|integer',
            'barang' => 'sometimes|uuid|exists:persediaan,id_persediaan',
            'harga' => 'sometimes|integer',
            'jumlah' => 'sometimes|integer',
            'deskripsi' => 'sometimes|string',
            'tanggal_pengeluaran' => 'sometimes|date',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($request->all());
        return redirect()->route('pengeluaran')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();
        return redirect()->route('pengeluaran')->with('success', 'Data berhasil dihapus!');
    }
}