<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persediaan;

class PersediaanController extends Controller
{
    public function index()
    {
        $persediaan = Persediaan::all();
        return response()->json($persediaan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'harga_pcs' => 'required|integer',
            'jumlah_persediaan' => 'required|integer',
        ]);

        $persediaan = Persediaan::create($request->all());
        return response()->json($persediaan, 201);
    }

    public function show($id)
    {
        $persediaan = Persediaan::findOrFail($id);
        return response()->json($persediaan);
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
        return response()->json($persediaan);
    }

    public function destroy($id)
    {
        $persediaan = Persediaan::findOrFail($id);
        $persediaan->delete();
        return response()->json(null, 204);
    }
}
