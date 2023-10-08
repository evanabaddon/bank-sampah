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
            Laporan Bank Sampah / BSP
            @if(request('kategori_layanan_id'))
                - Layanan: {{ $kategoriLayanan->name }}
            @endif
            @if(request('status'))
                - Status: {{ request('status') }}
            @endif
            @if(request('bulan'))
                - Bulan: {{ \Carbon\Carbon::parse('2023-' . request('bulan') . '-01')->translatedFormat('F') }}
            @endif
            @if(request('tahun'))
                - Tahun: {{ request('tahun') }}
            @endif
            @if(request('nama'))
                - Nama Nasabah: {{ request('nama') }}
            @endif
            @if(request('jenis_sampah_id'))
                - Jenis Sampah: {{ $jenisSampah->name }}
            @endif
        </h3>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Nasabah</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Sampah</th>
                    <th>Jumlah Transaksi</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($model as $transaksi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $transaksi->nasabah->name }}</td>
                        <td>{{ strftime('%d %B %Y', strtotime($transaksi->created_at)) }}</td>
                        <td>
                            @foreach ($transaksi->detailTransaksiBank as $detailTransaction)
                                {{ $detailTransaction->jenisSampah->name }}: {{ $detailTransaction->berat }} kg<br>
                            @endforeach
                        </td>
                        <td class="right-align">{{ $transaksi->formatRupiah('total_harga') }}</td>
                        <td>{{ $transaksi->user->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
