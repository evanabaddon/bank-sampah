<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaran extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = ['deskripsi', 'jumlah', 'tanggal', 'user_id'];

    /**
     * Get the user that owns the TransaksiPengeluaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
