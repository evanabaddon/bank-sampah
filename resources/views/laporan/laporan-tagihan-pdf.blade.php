<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Tagihan</title>
    <style>
        /* Gaya CSS Anda untuk laporan PDF */
        body {
            font-family: Arial, sans-serif;
        }
        /* Menambahkan aturan CSS untuk mode landscape */
        @page {
            size: landscape;
        }
        h3 {
            font-size: 16px; /* Ukuran font untuk judul (header) h3 */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px; /* Ukuran font untuk tabel */
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3>Laporan Tagihan</h3>
    @if ($kategoriLayanan)
        <p>Layanan: {{ $kategoriLayanan->name }}</p>
    @endif
    @if (request('status'))
        <p>Status: {{ request('status') }}</p>
    @endif
    @if (request('bulan'))
        <p>Bulan: {{ \Carbon\Carbon::parse('2023-' . request('bulan') . '-01')->translatedFormat('F') }}</p>
    @endif
    @if (request('tahun'))
        <p>Tahun: {{ request('tahun') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Nama Nasabah</th>
                <th>Tanggal Tagihan</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Kategori Layanan</th>
                <th>Total Tagihan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ 'PPC/' . $item->id . '/' . $item->nasabah_id . '/' . date('my', strtotime($item->tanggal_tagihan)) }}</td>
                    <td>{{ $item->nasabah->name }}</td>
                    <td>{{ $item->tanggal_tagihan }}</td>
                    <td>{{ $item->tanggal_jatuh_tempo }}</td>
                    <td>{{ $item->nasabah->kategoriLayanan->name }}</td>
                    <td>{{ $item->formatRupiah('jumlah_tagihan') }}</td>
                    <td>
                        @if ($item->status == 'belum')
                            Belum Bayar
                        @else
                            Terbayar
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
