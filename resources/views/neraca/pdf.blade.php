<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: landscape; /* Mengatur orientasi landscape */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000; /* Menambahkan garis pada tabel */
        }

        th, td {
            border: 1px solid #000; /* Menambahkan garis pada sel tabel */
            padding: 8px;
        }

        td.text-right {
            text-align: right; /* Mengatur rata kanan pada sel */
        }
    </style>
    
    <title>Laporan Neraca Keuangan</title>
</head>
<body>
    <h3>Laporan Neraca Keuangan</h3>
    @php
    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    @endphp

    <p>Bulan: {{ $namaBulan[$bulanSelected] }}</p>
    <p>Tahun: {{ $tahunSelected }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debet (Pemasukan)</th>
                <th>Kredit (Pengeluaran)</th>
            </tr>
        </thead>
        <tbody>
            @php $rowNumber = 1; @endphp
            @foreach ($pemasukan as $transaksi)
            <tr>
                <td>{{ $rowNumber++ }}</td>
                <td>{{ strftime('%d %B %Y', strtotime($transaksi->tanggal_tagihan)) }}</td>
                <td>{{ 'Tagihan ' . $transaksi->nasabah->name . ' Bulan ' . $namaBulan[$bulanSelected] . ' ' . $tahunSelected }}</td>
                <td class="text-right">Rp {{ number_format($transaksi->jumlah_tagihan, 2, ',', '.') }}</td>
                <td></td>
            </tr>
            @endforeach
    
            @foreach ($pengeluaran as $transaksi)
            <tr>
                <td>{{ $rowNumber++ }}</td>
                <td>{{ strftime('%d %B %Y', strtotime($transaksi->tanggal)) }}</td>
                <td>{{ $transaksi->deskripsi }}</td>
                <td></td>
                <td class="text-right">Rp {{ number_format($transaksi->jumlah, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Debet (Pemasukan)</th>
                <th>Kredit (Pengeluaran)</th>
                <th>Laba / Rugi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-right">Rp {{ number_format($totalDebet, 2, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalKredit, 2, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalDebet - $totalKredit, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    
</body>
</html>
