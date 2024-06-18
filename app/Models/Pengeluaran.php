<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'jenis_pengeluaran',
        'barang',
        'harga',
        'jumlah',
        'deskripsi',
        'tanggal_pengeluaran',
    ];

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'barang', 'id_persediaan');
    }
}
