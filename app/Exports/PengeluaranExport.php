<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use App\Models\Persediaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengeluaranExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $pengeluaran = Pengeluaran::orderBy('updated_at', 'desc')->get();

        $pengeluaran->each(function ($item, $key) {
            $item->row_number = $key + 1;

            if ($item->jenis_pengeluaran == 1) {
                $item->jenis_pengeluaran = 'Operasional';
            } elseif ($item->jenis_pengeluaran == 2) {
                $item->jenis_pengeluaran = 'Non-Operasional';
            }

            if (!is_null($item->barang)) {
                $persediaan = Persediaan::find($item->barang);
                $item->barang = $persediaan ? $persediaan->nama_barang : null;
            }
        });

        return $pengeluaran->map(function ($item) {
            return [
                'row_number' => $item->row_number,
                'jenis_pengeluaran' => $item->jenis_pengeluaran,
                'barang' => $item->barang,
                'harga' => $item->harga,
                'jumlah' => $item->jumlah,
                'deskripsi' => $item->deskripsi,
                'tanggal_pengeluaran' => $item->tanggal_pengeluaran,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No.',
            'Jenis Pengeluaran',
            'Barang',
            'Harga',
            'Jumlah',
            'Deskripsi',
            'Tanggal Pengeluaran',
            'Tanggal Dibuat',
            'Tanggal Diupdate',
        ];
    }
}
