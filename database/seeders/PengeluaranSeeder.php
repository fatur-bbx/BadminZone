<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;
use App\Models\Persediaan;
use Illuminate\Support\Str;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        $barangA = Persediaan::where('nama_barang', 'Barang A')->first()->id_persediaan;
        $barangB = Persediaan::where('nama_barang', 'Barang B')->first()->id_persediaan;

        Pengeluaran::create([
            'id_pengeluaran' => Str::uuid()->toString(),
            'jenis_pengeluaran' => 1,
            'barang' => $barangA,
            'harga' => 50000,
            'jumlah' => 10,
            'deskripsi' => 'Pengeluaran untuk keperluan X',
            'tanggal_pengeluaran' => now(),
        ]);

        Pengeluaran::create([
            'id_pengeluaran' => Str::uuid()->toString(),
            'jenis_pengeluaran' => 2,
            'barang' => $barangB,
            'harga' => 30000,
            'jumlah' => 5,
            'deskripsi' => 'Pengeluaran untuk keperluan Y',
            'tanggal_pengeluaran' => now(),
        ]);

        Pengeluaran::create([
            'id_pengeluaran' => Str::uuid()->toString(),
            'jenis_pengeluaran' => 2,
            'barang' => null, // Pengeluaran tanpa barang
            'harga' => 20000,
            'jumlah' => 3,
            'deskripsi' => 'Pengeluaran umum',
            'tanggal_pengeluaran' => now(),
        ]);
    }
}
