<?php

namespace App\Traits;

trait HasFormatRupiah
{
    public function formatRupiah($field, $prefix = null)
    {
        $prefix = $prefix ?? 'Rp ';
        return $prefix . number_format($this->attributes[$field], 0, ',', '.');
    }
}

?>