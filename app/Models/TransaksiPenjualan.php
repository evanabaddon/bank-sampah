<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'tanggal',
        'jenis_sampah_id',
        'jumlah_kg',
        'total_harga',
        'user_id',
        'id_pengepul'
    ];

    // Definisikan relasi dengan model JenisSampah jika diperlukan
    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }

    public function detailTransaksiPenjualans()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'transaksi_penjualan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class); // relasi ke model User
    }

    // relasi ke pengepul
    public function pengepul()
    {
        return $this->belongsTo(Pengepul::class, 'id_pengepul', 'id'); // relasi ke model Pengepul
    }
}
