<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPeminjaman extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'data_peminjaman';

    protected $fillable = [
        'tgl_peminjaman',
        'tgl_pengembalian',
        'nama_peminjam',
        'kode_barang',
        'kode_ruangan',
        'jumlah',
        'status',
    ];

    protected $casts = [
        'kode_barang' => 'array',
        'kode_ruangan' => 'array',
    ];

    public function dataBarang()
    {
        return $this->hasMany(DataBarang::class, 'id', 'kode_barang');
    }

    public function dataRuangan()
    {
        return $this->hasMany(DataRuangan::class, 'id', 'kode_ruangan');
    }

    protected $dates = ['deleted_at'];
}

