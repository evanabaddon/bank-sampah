<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLayanan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $fillable = ['name', 'harga'];

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'kategori_layanan_id');
    }
    
}
