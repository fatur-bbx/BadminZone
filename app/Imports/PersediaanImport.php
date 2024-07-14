<?php

namespace App\Imports;

use App\Models\Persediaan;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PersediaanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Persediaan([
            'id_persediaan' => Str::uuid()->toString(),
            'nama_barang' => $row['nama_barang'],
            'harga_pcs' => $row['harga_pcs'],
            'jumlah_persediaan' => $row['jumlah_persediaan'],
        ]);
    }
}
