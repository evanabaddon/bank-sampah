<!DOCTYPE html>
<html>
<head>
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
    <div class="container">
        <h3>
            Laporan Penjualan Sampah
            @if(request('bulan'))
                - Bulan: {{ \Carbon\Carbon::parse('2023-' . request('bulan') . '-01')->translatedFormat('F') }}
            @endif
            @if(request('tahun'))
                - Tahun: {{ request('tahun') }}
            @endif
            @if(request('jenis_sampah_id'))
                - Jenis Sampah: {{ $jenisSampah->name }}
            @endif
        </h3>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Sampah</th>
                    <th>Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($model as $transaksi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ strftime('%d %B %Y', strtotime($transaksi->tanggal)) }}</td>
                        <td>
                            @foreach ($transaksi->detailTransaksiPenjualans as $detailTransaction)
                                {{ $detailTransaction->jenisSampah->name }}: {{ $detailTransaction->jumlah_kg }} kg x {{ $detailTransaction->formatRupiah('total_harga') }}<br>
                            @endforeach
                        </td>
                        <td class="right-align">{{ $transaksi->formatRupiah('total_harga') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
