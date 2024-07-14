<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
