<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiBank extends Model
{
    use HasFactory;
    use HasFormatRupiah;
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
        return $this->belongsTo(JenisSampah::class, 'id_jenis_sampah', 'id');
    }
}
