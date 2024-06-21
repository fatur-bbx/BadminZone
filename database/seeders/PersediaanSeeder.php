<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Persediaan;
use Illuminate\Support\Str;

class PersediaanSeeder extends Seeder
{
    public function run()
    {
        Persediaan::create([
            'id_persediaan' => Str::uuid()->toString(),
            'nama_barang' => 'Barang A',
            'harga_pcs' => 10000,
            'jumlah_persediaan' => 50,
        ]);

        Persediaan::create([
            'id_persediaan' => Str::uuid()->toString(),
            'nama_barang' => 'Barang B',
            'harga_pcs' => 20000,
            'jumlah_persediaan' => 30,
        ]);

        Persediaan::create([
            'id_persediaan' => Str::uuid()->toString(),
            'nama_barang' => 'Barang C',
            'harga_pcs' => 15000,
            'jumlah_persediaan' => 20,
        ]);
    }
}
