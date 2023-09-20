<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBank extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'id_nasabah',
        'total_harga',
    ];

    public function detailTransaksiSampah()
    {
        return $this->hasMany(DetailTransaksiSampah::class, 'id_transaksi_bank', 'id_transaksi_bank');
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id');
    }
}
