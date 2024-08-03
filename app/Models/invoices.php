<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class invoices extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $primaryKey = 'id_faktur';
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_faktur',
        'handle_faktur',
        'id_pendapatan',
        'email_handle_faktur',
        'created_at',
    ];

    // Mengatur agar tidak ada kolom updated_at
    public $timestamps = false;

    // Relasi ke model Pendapatan
    public function pendapatan()
    {
        return $this->belongsTo(Pendapatan::class, 'id_pendapatan');
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
