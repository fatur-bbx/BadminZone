<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendapatan;
use App\Models\Persediaan;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PendapatanSeeder extends Seeder
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

        for ($i = 1; $i <= 300; $i++) {
            $jenis_pendapatan = rand(1, 2);

            if ($jenis_pendapatan == 1) {
                $barang_id = $persediaan_ids[array_rand($persediaan_ids)];
                $barang = Persediaan::find($barang_id);
                $harga = $barang->harga_pcs;
            } else {
                $barang_id = null;
                $harga = rand(1000, 50000);
            }

            Pendapatan::create([
                'id_pendapatan' => Str::uuid(),
                'jenis_pendapatan' => $jenis_pendapatan,
                'barang' => $barang_id,
                'harga' => $harga,
                'jumlah' => rand(1, 50),
                'deskripsi' => $jenis_pendapatan == 1 ? 'Barang ' . $barang_id : 'Lapangan ' . $i,
                'tanggal_pendapatan' => now(),
                'created_at' => $this->randomDate('2020-01-01', now()->toDateString()),
                'updated_at' => now()
            ]);
        }
    }
}
