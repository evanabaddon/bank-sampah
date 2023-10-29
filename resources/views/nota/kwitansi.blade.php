<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Bayar</title>
    <style type="text/css">
        html, body {
            height: 100%;
            margin: 20px;
            justify-content: center;
            align-items: center;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            max-width: 100%; /* Adjust the maximum width for responsiveness */
            margin: 0;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
        }

        .header {
            text-align: center;
        }

        .header strong {
            font-size: 14px;
        }

        .invoice-number {
            font-size: 10px;
        }

        .invoice-number strong {
            font-size: 12px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
        }

        .invoice-info p {
            font-size: 10px;
        }

        .table {
            width: 100%;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #e4e4e4;
            padding: 4px;
            text-align: left;
            font-size: 10px;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .stempel {
            text-align: center;
        }

        .stempel img {
            max-width: 100%; /* Make the image responsive */
            height: auto;
        }

        .customer-info {
            text-align: center;
        }

        .customer-info strong {
            font-size: 10px;
        }

        .customer-info p {
            font-size: 10px;
            margin-top: 0px;
        }

        .customer-info a {
            text-decoration: none;
            color: #000;
        }

        .customer-info a:hover {
            text-decoration: underline;
        }

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }

        /* Badge for 'belum' status */
        .badge-danger {
            background-color: #dc3545; /* Red color */
            color: #fff;
        }

        /* Badge for 'lunas' status */
        .badge-success {
            background-color: #28a745; /* Green color */
            color: #fff;
        }

        /* Media Query for Small Screens (Mobile Devices) */
        @media screen and (max-width: 600px) {
            .container {
                padding: 5px; /* Adjust padding for smaller screens */
            }

            .invoice-info p, .customer-info p, .customer-info a {
                font-size: 10px; /* Increase font size for better readability */
            }

            .table th, .table td {
                font-size: 10px; /* Increase font size for better readability */
            }

            .logo img {
                width: 40px; /* Decrease the logo size for smaller screens */
                height: 40px;
            }

            .stempel img {
                width: 80px; /* Decrease stempel image size for smaller screens */
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Container -->
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/'.settings()->get('app_logo')) }}" alt="Logo">
        </div>

        <!-- Header -->
        <div class="header">
            <strong>{{ settings('app_name') }}</strong>
            <p style="font-size: 10px; margin: 0px" class="mt-0">{{ settings('app_address') }}</p>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <p>Petugas : {{ $tagihan->user->name }}</p>
            <p>Tanggal: {{ now()->format('d F Y') }}</p>
        </div>

        <!-- Invoice Number -->
        <div class="invoice-number">
			<strong>Bukti Bayar</strong>
            <p>INVOICE: {{ 'PPC/' . $tagihan->id . '/' . $tagihan->nasabah_id  . '/' . date('my', strtotime($tagihan->tanggal_tagihan)) }}</p>
        </div>

        <!-- Table Total -->
        <table class="table">
            <tr>
                <th style="text-align: center">Deskripsi</th>
                <th style="text-align: center">Total</th>
                <th style="text-align: center">Status</th>
            </tr>
            <tr>
                <td>Tagihan {{ $tagihan->nasabah->name .' Bulan ' . date('F Y', strtotime($tagihan->tanggal_tagihan)) }}</td>
                <td style="text-align: center">{{ 'Rp. ' . number_format($tagihan->jumlah_tagihan, 0, ',', '.') . ',-' }}</td>
                <td style="text-align: center"><span class="badge badge-{{ $tagihan->status == 'belum' ? 'danger' : 'success' }}">{{ $tagihan->status == 'belum' ? 'Belum Lunas' : 'Lunas' }}</span></td>
            </tr>
        </table>

        <!-- Customer Info -->
        <div class="customer-info">
            <strong>Terimakasih</strong>
            <p>Telah Menggunakan Layanan Kami</p>
            <strong>{{ settings('app_name') }}</strong>
            <p>Telp. {{ settings('app_phone') }}</p>
            <p><a href="{{ settings('app_website') }}">{{ settings('app_website') }}</a></p>
        </div>
        <!-- Customer Info -->
        <hr>
        <div class="customer-info">
            <strong>Riwayat Tagihan</strong>
            <p>Daftar Riwayat Tagihan</p>
            <table class="table">
                <tr>
                    <th style="text-align: center">Bulan</th>
                    <th style="text-align: center">Total</th>
                    <th style="text-align: center">Status</th>
                </tr>
                @foreach($listtagihan as $bill)
                    <tr>
                        <td>{{ date('F', strtotime($bill->tanggal_tagihan)) }}</td>
                        <td style="text-align: center">{{ 'Rp. ' . number_format($bill->jumlah_tagihan, 0, ',', '.') . ',-' }}</td>
                        <td style="text-align: center"><span class="badge badge-{{ $bill->status == 'belum' ? 'danger' : 'success' }}">{{ $bill->status == 'belum' ? 'Belum Lunas' : 'Lunas' }}</span></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>
