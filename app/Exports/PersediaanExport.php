<?php

namespace App\Exports;

use App\Models\Persediaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersediaanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $persediaan = Persediaan::orderBy('updated_at', 'desc')->get();
        
        $persediaan->each(function ($item, $key) {
            $item->row_number = $key + 1;
        });

        return $persediaan->map(function ($item) {
            return [
                'row_number' => $item->row_number,
                'nama_barang' => $item->nama_barang,
                'harga_pcs' => $item->harga_pcs,
                'jumlah_persediaan' => $item->jumlah_persediaan,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No.',
            'nama_barang',
            'harga_pcs',
            'jumlah_persediaan',
            'Tanggal Dibuat',
            'Tanggal Diupdate',
        ];
    }
}
