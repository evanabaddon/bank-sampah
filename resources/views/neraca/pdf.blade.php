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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debet (Pemasukan)</th>
                <th>Kredit (Pengeluaran)</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
            $rowNumber = 1;
            @endphp

            @foreach ($pemasukan as $transaksi)
            <tr>
                <td>{{ $rowNumber++ }}</td>
                <td>
                    @if ($transaksi->sumber == 'Tagihan')
                    {{ $transaksi->tanggal_tagihan }}
                    @elseif ($transaksi->sumber == 'Penjualan')
                    {{ $transaksi->tanggal }}
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    @if ($transaksi->sumber == 'Tagihan')
                    Tagihan {{ optional($transaksi->nasabah)->name }} Bulan {{ date('F Y', strtotime($transaksi->tanggal_bayar)) }}
                    @elseif ($transaksi->sumber == 'Penjualan')
                    Penjualan Sampah
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    @if ($transaksi->sumber == 'Tagihan')
                    Rp {{ number_format($transaksi->jumlah_tagihan, 0, ',', '.') }},-
                    @elseif ($transaksi->sumber == 'Penjualan')
                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }},-
                    @else
                    N/A
                    @endif
                </td>
                <td></td>
                <td></td>
            </tr>
            @endforeach

            @foreach ($pengeluaran as $transaksi)
            <tr>
                <td>{{ $rowNumber++ }}</td>
                <td>{{ $transaksi->tanggal }}</td>
                <td>{{ $transaksi->deskripsi }}</td>
                <td></td>
                <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }},-</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: left;">Total</th>
                <th style="text-align: left;">Rp {{ number_format($totalDebet, 0, ',', '.')  }},-</th>
                <th style="text-align: left;">Rp {{ number_format($totalKredit, 0, ',', '.') }},-</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: left;">Laba / Rugi</th>
                <th style="text-align: left;">Rp {{ number_format($saldo, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    
    
</body>
</html>
