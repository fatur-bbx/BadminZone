<?php

namespace App\Exports;

use App\Models\Pendapatan;
use App\Models\Persediaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendapatanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $pendapatan = Pendapatan::orderBy('updated_at', 'desc')->get();
        
        $pendapatan->each(function ($item, $key) {
            $item->row_number = $key + 1;
        });

        return $pendapatan->map(function ($item) {
            $barang = null;
            if($item->barang != null){
                $temp_barang = Persediaan::where('id_persediaan', $item->barang)->first();
                $barang = $temp_barang->nama_barang;
            }

            return [
                'row_number' => $item->row_number,
                'jenis_pendapatan' => $item->jenis_pendapatan,
                'barang' => $barang,
                'harga' => $item->harga,
                'jumlah' => $item->jumlah,
                'deskripsi' => $item->deskripsi,
                'tanggal_pendapatan' => $item->tanggal_pendapatan,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No.',
            'Jenis Pendapatan',
            'Barang',
            'Harga',
            'Jumlah',
            'Deskripsi',
            'Tanggal Pendapatan',
            'Tanggal Dibuat',
            'Tanggal Diupdate',
        ];
    }
}
