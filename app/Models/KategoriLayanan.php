<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class KategoriLayanan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;

    protected $fillable = ['name', 'harga'];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'harga' => 10,
        ],
    ];

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'kategori_layanan_id');
    }
    
}
