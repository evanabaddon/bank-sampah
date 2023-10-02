<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldo'; // Nama tabel yang sesuai dengan nama migrasi
    protected $fillable = ['saldo']; // Kolom yang dapat diisi secara massal
}
