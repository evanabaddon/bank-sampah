<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPenjualan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $fillable = [
        'transaksi_penjualan_id',
        'jenis_sampah_id',
        'jumlah_kg',
        'total_harga',
        // Tambahkan kolom lain yang bisa diisi
    ];

    // Definisikan relasi dengan model JenisSampah jika diperlukan
    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }

    public function transaksiPenjualan()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'transaksi_penjualan_id');
    }
}
