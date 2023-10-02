<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenarikan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    
    protected $table = 'transaksi_penarikans'; // Sesuaikan dengan nama tabel Anda

    protected $fillable = [
        'nasabah_id',
        'jumlah',
        'user_id',
    ];

    // Definisikan relasi dengan model Nasabah jika diperlukan
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
