<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Nasabah extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;

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

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'kodenasabah' => 10,
            'nohp' => 10,
            'alamat' => 10,
            'rt' => 10,
            'rw' => 10,
        ],
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
