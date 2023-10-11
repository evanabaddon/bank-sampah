<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengepul extends Model
{
    use HasFactory;

    protected $table = 'pengepuls';

    protected $fillable = [
        'name',
        'alamat',
        'no_hp',
        'user_id'
    ];

    // relasi ke transaksi penjualan sampah
    public function transaksiPenjualan()
    {
        return $this->hasMany(TransaksiPenjualan::class);
    }
}
