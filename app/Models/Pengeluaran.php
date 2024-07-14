<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected $dates = [
        'tanggal_pengeluaran',
    ];

    public function persediaan()
    {
        return $this->belongsTo(Persediaan::class, 'barang', 'id_persediaan');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
