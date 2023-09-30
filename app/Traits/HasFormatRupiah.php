<?php

namespace App\Traits;

trait HasFormatRupiah
{
    public function formatRupiah($field, $prefix = null)
    {
        $prefix = $prefix ?? 'Rp ';
        // if decimal convert to float if not as is
        $value = ($this->$field) ? $this->$field : (float) $field;
        return $prefix . number_format($value, 0, ',', '.');
    }
}

?>