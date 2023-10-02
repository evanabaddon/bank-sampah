<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBank extends Model
{
    use HasFactory;
    use HasFormatRupiah;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_operator');
    }

    public function detailTransaksiBank()
    {
        return $this->hasMany(DetailTransaksiBank::class, 'id_transaksi_bank', 'id');
    }

    // Event deleting untuk menghapus detail transaksi bank
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($transaksiBank) {
            // Hapus semua detail transaksi bank yang terkait
            $transaksiBank->detailTransaksiBank()->delete();
        });
    }
}
