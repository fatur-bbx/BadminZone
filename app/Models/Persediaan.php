<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    use HasFactory;

    protected $table = 'persediaan';
    protected $primaryKey = 'id_persediaan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_barang',
        'harga_pcs',
        'jumlah_persediaan',
    ];
}
