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
            Laporan Stok Sampah
            
            @if(request('jenis_sampah_id'))
                - Jenis Sampah: {{ $jenisSampah->name }}
            @endif
        </h3>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis Sampah</th>
                    <th>Jumlah (Kg)</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($model as $transaksi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $transaksi->name }}</td>
                        <td class="right-center">{{ $transaksi->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
