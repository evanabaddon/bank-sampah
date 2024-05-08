<?php

namespace App\Exports;

use App\Models\Nasabah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;

class NasabahExport implements FromCollection, WithHeadings, WithMapping
{
    protected $models;
    protected $counter = 0;

    public function __construct()
    {
        $this->models = Nasabah::all();
    }

    public function collection()
    {
        return $this->models;
    }

    public function headings(): array
    {
        // Tentukan judul kolom yang diinginkan
        return [
            'No',
            'Kode Nasabah',
            'Nama',
            'Alamat',
            'RT',
            'RW',
            'No HP',
            'Layanan BSP',
            'Layanan PPC',
            'Kategori Layanan ID',
            'Saldo',
        ];
    }

    // tampilkan nama nasabah berdasarkan nasabah_id dan kategori layanan berdasarkan kategori_layanan_id pada tabel nasabah
    public function map($model): array
    {
        return [
            ++$this->counter,    
            $model->kodenasabah,    
            $model->name,
            $model->alamat,
            $model->rt,
            $model->rw,
            $model->nohp,
            $model->is_bsp == 1 ? 'Aktif' : 'Tidak Aktif',
            $model->is_ppc == 1 ? 'Aktif' : 'Tidak Aktif',
            $model->kategoriLayanan->name,
            $model->saldo,
        ];
    }
}