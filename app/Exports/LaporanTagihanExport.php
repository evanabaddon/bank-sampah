<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanTagihanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $models;
    protected $counter = 0;

    public function __construct($models)
    {
        $this->models = $models;
    }

    public function collection()
    {
        return $this->models['model'];
    }

    public function headings(): array
    {
        return [
            'No',
            'Invoice',
            'Nama Nasabah',
            'Tanggal Tagihan',
            'Tanggal Jatuh Tempo',
            'Kategori Layanan',
            'Total Tagihan',
            'Status',
            'Operator'
        ];
    }

    // tampilkan nama nasabah berdasarkan nasabah_id dan kategori layanan berdasarkan kategori_layanan_id pada tabel nasabah
    public function map($model): array
    {
        // invoice 'PPC/' . $item->id . '/' . $item->nasabah_id . '/' . date('my', strtotime($item->tanggal_tagihan))
        return [
            // nomor urut
            ++$this->counter,
            // format invoice
            'PPC/' . $model->id . '/' . $model->nasabah_id . '/' . date('my', strtotime($model->tanggal_tagihan)),        
            $model->nasabah->name,
            $model->tanggal_tagihan,
            $model->tanggal_jatuh_tempo,
            $model->nasabah->kategoriLayanan->name,
            $model->jumlah_tagihan,
            $model->status,
            // tampilkan nama operator berdasarkan user_id pada tabel users cek null
            $model->user->name ?? '-'
        ];
    }

}
