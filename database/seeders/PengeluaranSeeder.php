<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;
use App\Models\Persediaan;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    public function randomDate($startDate, $endDate) {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }

    public function run()
    {
        $persediaan_ids = Persediaan::pluck('id_persediaan')->toArray();

        for ($i = 1; $i <= 750; $i++) {
            $jenis_pengeluaran = rand(1, 2);

            if ($jenis_pengeluaran == 2) {
                $barang_id = $persediaan_ids[array_rand($persediaan_ids)];
                $barang = Persediaan::find($barang_id);
                $harga = $barang->harga_pcs;
                $deskripsi = 'Penambahan stok barang';
            } else {
                $barang_id = null;
                $harga = rand(1000, 50000);
                $deskripsi = 'Pembersihan lapangan ' . $i;
            }
            $tanggal_sekarang = $this->randomDate('2020-01-01', now()->toDateString());
            Pengeluaran::create([
                'id_pengeluaran' => Str::uuid(),
                'jenis_pengeluaran' => $jenis_pengeluaran,
                'barang' => $barang_id,
                'harga' => $harga,
                'jumlah' => rand(1, 50),
                'deskripsi' => $deskripsi,
                'tanggal_pengeluaran' => $tanggal_sekarang,
                'created_at' => $tanggal_sekarang,
                'updated_at' => $tanggal_sekarang
            ]);
        }
    }
}
