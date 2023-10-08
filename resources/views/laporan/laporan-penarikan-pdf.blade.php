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
            Laporan Penarikan 
            
            @if(request('nama'))
                - Nasabah : {{ request('nama') }}
            @endif
        </h3>

        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Nasabah</th>
                    <th>Total Penarikan</th>
                    <th>Sisa Saldo</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($model as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->formatLocalized('%d %B %Y %H:%M:%S') }}</td>
                        <td>{{ $item->nasabah->name }}</td>
                        <td>{{ $item->formatRupiah('jumlah') }}</td>
                        <td>{{ $item->formatRupiah('saldo') }}</td>
                        <td>{{ $item->user ? $item->user->name : 'User Tidak Ditemukan' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="9">Data tidak ada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
