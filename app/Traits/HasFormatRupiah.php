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

    public static function formatRupiahStatic($value, $prefix = 'Rp ')
    {
        $value = is_numeric($value) ? $value : (float) str_replace(',', '', $value);
        return $prefix . number_format($value, 0, ',', '.');
    }

}

?>