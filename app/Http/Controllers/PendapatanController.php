<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendapatan;

class PendapatanController extends Controller
{
    public function index()
    {
        $pendapatan = Pendapatan::all();
        return response()->json($pendapatan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pendapatan' => 'required|integer',
            'barang' => 'nullable|uuid|exists:persediaan,id_persediaan',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'deskripsi' => 'required|string',
            'tanggal_pendapatan' => 'required|date',
        ]);

        $pendapatan = Pendapatan::create($request->all());
        return response()->json($pendapatan, 201);
    }

    public function show($id)
    {
        $pendapatan = Pendapatan::findOrFail($id);
        return response()->json($pendapatan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_pendapatan' => 'sometimes|integer',
            'barang' => 'sometimes|uuid|exists:persediaan,id_persediaan',
            'harga' => 'sometimes|integer',
            'jumlah' => 'sometimes|integer',
            'deskripsi' => 'sometimes|string',
            'tanggal_pendapatan' => 'sometimes|date',
        ]);

        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->update($request->all());
        return response()->json($pendapatan);
    }

    public function destroy($id)
    {
        $pendapatan = Pendapatan::findOrFail($id);
        $pendapatan->delete();
        return response()->json(null, 204);
    }
}
