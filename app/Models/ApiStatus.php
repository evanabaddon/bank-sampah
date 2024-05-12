<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_status',
        'device_status',
    ];
}
