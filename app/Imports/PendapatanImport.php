<?php

namespace App\Imports;

use App\Models\Pendapatan;
use App\Models\Persediaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendapatanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                $jenis_pendapatan = strtolower($row['jenis_pendapatan']) === 'non-operasional' ? 2 : 1;
                $barang = null;
                if (!empty($row['barang'])) {
                    $persediaan = Persediaan::where('nama_barang', $row['barang'])->first();
                    if ($persediaan) {
                        $barang = $persediaan->id_persediaan;
                    } else {
                        $newPersediaan = Persediaan::create([
                            'id_persediaan' => Str::uuid(),
                            'nama_barang' => $row['barang'],
                            'harga_pcs' => 0,
                            'jumlah_persediaan' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $barang = $newPersediaan->id_persediaan;
                    }
                }
                $harga = is_numeric($row['harga']) ? (float)$row['harga'] : 0;
                $jumlah = is_numeric($row['jumlah']) ? (int)$row['jumlah'] : 0;
                Pendapatan::updateOrCreate(
                    ['id_pendapatan' => Str::uuid()],
                    [
                        'jenis_pendapatan' => $jenis_pendapatan,
                        'barang' => $barang,
                        'harga' => $harga,
                        'jumlah' => $jumlah,
                        'deskripsi' => $row['deskripsi'],
                        'tanggal_pendapatan' => $row['tanggal_pendapatan'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        });
    }
}
