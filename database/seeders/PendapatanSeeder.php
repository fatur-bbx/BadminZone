<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendapatan;
use App\Models\Persediaan;
use App\Models\invoices;
use App\Models\User;
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
        $user = User::inRandomOrder()->first(); // Ambil satu user secara acak

        for ($i = 1; $i <= 1000; $i++) {
            $jenis_pendapatan = rand(1, 2);

            if ($jenis_pendapatan == 1) {
                $barang_id = $persediaan_ids[array_rand($persediaan_ids)];
                $barang = Persediaan::find($barang_id);
                $harga = $barang->harga_pcs;
            } else {
                $barang_id = null;
                $lapangan = rand(1, 2);
                $harga = $lapangan == 1 ? 50000 : 100000;
            }
            
            $tanggal_sekarang = $this->randomDate('2020-01-01', now()->toDateString());
            $pendapatan = Pendapatan::create([
                'id_pendapatan' => Str::uuid(),
                'jenis_pendapatan' => $jenis_pendapatan,
                'barang' => $barang_id,
                'harga' => $harga,
                'jumlah' => rand(1, 50),
                'deskripsi' => $jenis_pendapatan == 1 ? 'Barang ' . $barang->nama_barang : 'Lapangan ' . $lapangan,
                'tanggal_pendapatan' => $tanggal_sekarang,
                'created_at' => $tanggal_sekarang,
                'updated_at' => $tanggal_sekarang
            ]);

            $today = now()->format('Y-m-d');
            $invoiceCountToday = invoices::whereDate('created_at', $today)->count() + 1;
            $invoiceNumber = str_pad($invoiceCountToday, 4, '0', STR_PAD_LEFT);

            $invoiceName = $invoiceNumber . '/' . now()->format('Ymd') . '/' . $user->name;

            $invoiceData = [
                'nama_faktur' => $invoiceName,
                'handle_faktur' => $user->name, // Menggunakan name dari User
                'id_pendapatan' => $pendapatan->id_pendapatan,
                'email_handle_faktur' => $user->email, // Menggunakan email dari User
                'created_at' => now(),
            ];

            invoices::create($invoiceData);
        }
    }
}