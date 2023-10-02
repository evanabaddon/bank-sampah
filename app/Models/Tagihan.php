<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    // fillable
    protected $fillable = [
        'nasabah_id',
        'user_id',
        'tanggal_tagihan',
        'tanggal_jatuh_tempo',
        'jumlah_tagihan',
        'jumlah_bayar',
        'tanggal_bayar',
        'status',
        'keterangan',
    ];

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'nasabah_id');
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }

    // kategoriLayanan
    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriLayanan::class, 'kategori_layanan_id');
    }
    
    // user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

