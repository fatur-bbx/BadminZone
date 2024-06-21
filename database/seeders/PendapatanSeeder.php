<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pendapatan;
use App\Models\Persediaan;
use Illuminate\Support\Str;

class PendapatanSeeder extends Seeder
{
    public function run()
    {
        $barangA = Persediaan::where('nama_barang', 'Barang A')->first()->id_persediaan;
        $barangC = Persediaan::where('nama_barang', 'Barang C')->first()->id_persediaan;

        Pendapatan::create([
            'id_pendapatan' => Str::uuid()->toString(),
            'jenis_pendapatan' => 1,
            'barang' => $barangA,
            'harga' => 70000,
            'jumlah' => 20,
            'deskripsi' => 'Pendapatan dari penjualan A',
            'tanggal_pendapatan' => now(),
        ]);

        Pendapatan::create([
            'id_pendapatan' => Str::uuid()->toString(),
            'jenis_pendapatan' => 2,
            'barang' => $barangC,
            'harga' => 60000,
            'jumlah' => 15,
            'deskripsi' => 'Pendapatan dari penjualan B',
            'tanggal_pendapatan' => now(),
        ]);

        Pendapatan::create([
            'id_pendapatan' => Str::uuid()->toString(),
            'jenis_pendapatan' => 1,
            'barang' => null,
            'harga' => 50000,
            'jumlah' => 10,
            'deskripsi' => 'Pendapatan lapangan 1',
            'tanggal_pendapatan' => now(),
        ]);
    }
}
