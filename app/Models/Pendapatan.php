<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'pendapatan';
    protected $primaryKey = 'id_pendapatan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'jenis_pendapatan',
        'barang',
        'harga',
        'jumlah',
        'deskripsi',
        'tanggal_pendapatan',
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
