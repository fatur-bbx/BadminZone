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
        $peralatan_badminton = ['Raket', 'Shuttlecock', 'Net', 'Sepatu Badminton', 'Kaos Badminton', 'Tas Badminton'];
        $cemilan = ['Keripik', 'Cokelat', 'Permen', 'Biskuit', 'Kacang', 'Wafer'];
        $minuman = ['Air Mineral', 'Minuman Isotonik', 'Jus Buah', 'Teh Botol', 'Kopi Susu', 'Susu UHT'];
        $barang = array_merge($peralatan_badminton, $cemilan, $minuman);

        foreach ($barang as $item) {
            Persediaan::create([
                'id_persediaan' => Str::uuid(),
                'nama_barang' => $item,
                'harga_pcs' => rand(1000, 50000),
                'jumlah_persediaan' => rand(1, 100),
                'created_at' => $this->randomDate('2020-01-01', now()->toDateString()),
                'updated_at' => now()
            ]);
        }
    }
}
