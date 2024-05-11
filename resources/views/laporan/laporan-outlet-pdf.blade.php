<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Tagihan Outlet</title>
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
    <h3>Laporan Tagihan Outlet @if(request('user_id'))
        - {{ $outlet->name }}
        @endif</h3>
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
                <th>Kategori Layanan</th>
                <th>Tanggal Tagihan</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Bayar</th>
                <th>Total Tagihan</th>
                <th>Komisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($model as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{  'PPC/' . $item->id . '/' . $item->nasabah_id . '/' . date('my', strtotime($item->tanggal_tagihan)) }}</td>
                    <td>{{ $item->nasabah->name }}</td>
                    <td>{{ $item->nasabah->kategoriLayanan->name }}</td>
                    <td>{{ $item->tanggal_tagihan }}</td>
                    <td>{{ $item->tanggal_jatuh_tempo }}</td>
                    <td>{{ $item->tanggal_bayar }}</td>
                    <td>{{ $item->formatRupiah('jumlah_tagihan') }}</td>
                    <td>{{ is_numeric($komisi) ? App\Traits\HasFormatRupiah::formatRupiahStatic($komisi) : $komisi }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="9">Data tidak ada</td>
                </tr>
            @endforelse
                <tr>
                    <td colspan="6" style="text-align: right;"><strong>Total Setoran:</strong></td>
                    <td>{{ is_numeric($totalJumlahTagihan) ? App\Traits\HasFormatRupiah::formatRupiahStatic($totalJumlahTagihan) : $totalJumlahTagihan }}</td>
                    <td style="text-align: right;"><strong>Total Komisi:</strong></td>
                    <td>{{ is_numeric($totalKomisi) ? App\Traits\HasFormatRupiah::formatRupiahStatic($totalKomisi) : $totalKomisi }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>
