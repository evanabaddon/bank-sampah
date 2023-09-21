<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class JenisSampah extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $fillable = ['name', 'harga'];
}
