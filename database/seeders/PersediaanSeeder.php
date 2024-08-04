<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persediaan;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PersediaanSeeder extends Seeder
{
    public function randomDate($startDate, $endDate) {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }

    public function run()
    {
        $barang_dan_harga = [
            'Teh Botol' => 35000,
            'Keripik' => 35400,
            'Permen' => 21000,
            'Biskuit' => 20000,
            'Air Mineral' => 33400,
            'Susu UHT' => 30000,
            'Shuttlecock' => 15500,
            'Cokelat' => 15250,
            'Minuman Isotonik' => 43000,
            'Kopi Susu' => 30300,
            'Kaos Badminton' => 24000,
            'Tas Badminton' => 18300,
            'Net' => 31000,
            'Wafer' => 28600,
            'Kacang' => 14000,
            'Raket' => 19000,
            'Sepatu Badminton' => 28500,
            'Jus Buah' => 34000
        ];

        $tanggal_sekarang = $this->randomDate('2020-01-01', now()->toDateString());

        foreach ($barang_dan_harga as $nama_barang => $harga_pcs) {
            Persediaan::create([
                'id_persediaan' => Str::uuid(),
                'nama_barang' => $nama_barang,
                'harga_pcs' => $harga_pcs,
                'jumlah_persediaan' => rand(1, 100),
                'created_at' => $tanggal_sekarang,
                'updated_at' => $tanggal_sekarang
            ]);
        }
    }
}
