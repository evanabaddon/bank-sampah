<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiBank extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'id_transaksi_bank',
        'id_jenis_sampah',
        'berat',
        'harga',
    ];
    public function transaksiBankSampah()
    {
        return $this->belongsTo(TransaksiBank::class, 'id_transaksi_bank', 'id');
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'id_jenis_sampah', 'id_jenis_sampah');
    }
}
