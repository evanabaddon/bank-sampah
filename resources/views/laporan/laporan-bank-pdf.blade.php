<!DOCTYPE html>
<html>
<head>
    <style>
        /* Gaya CSS untuk laporan PDF */
        /* Misalnya, Anda dapat mengatur ukuran font, warna teks, dll. sesuai kebutuhan Anda */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            font-size: 24px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .right-align {
            text-align: right;
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
