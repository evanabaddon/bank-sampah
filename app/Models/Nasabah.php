<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $fillable = [
        'name',
        'kodenasabah',
        'nohp',
        'alamat',
        'rt',
        'rw',
        'is_bsp',
        'is_ppc',
        'kategori_layanan_id',
        'saldo',
        'pin',
    ];

    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriLayanan::class, 'kategori_layanan_id');
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'nasabah_id');
    }
}
