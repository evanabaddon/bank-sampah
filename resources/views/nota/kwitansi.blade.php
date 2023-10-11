<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Bayar</title>
    <style type="text/css">
		html, body {
			height: 100%;
			margin: 0;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            max-width: 220px;
            margin: 0 auto;
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
            font-size: 8px;
        }

        .table {
            width: 100%;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #e4e4e4;
            padding: 4px;
            text-align: left;
            font-size: 8px;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .stempel {
            text-align: center;
        }

        .stempel img {
            width: 100px;
            height: 100px;
        }

        .customer-info {
            text-align: center;
        }

        .customer-info strong {
            font-size: 10px;
        }

        .customer-info p {
            font-size: 8px;
            margin-top: 0px;
        }

        .customer-info a {
            text-decoration: none;
			color: #000;
        }

        .customer-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Container -->
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset(''.settings()->get('app_logo')) }}" alt="Logo">
        </div>

        <!-- Header -->
        <div class="header">
            <strong>{{ settings('app_name') }}</strong>
            <p style="font-size: 8px; margin: 0px" class="mt-0">{{ settings('app_address') }}</p>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <p>Petugas : {{ auth()->user()->name }}</p>
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
                <th>Deskripsi</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>Tagihan {{ $tagihan->nasabah->name .' Bulan ' . date('m', strtotime($tagihan->tanggal_tagihan)) }}</td>
                <td>{{ 'Rp. ' . number_format($tagihan->jumlah_tagihan, 0, ',', '.') . ',-' }}</td>
            </tr>
        </table>

        <!-- Stempel Lunas -->
        <div class="stempel">
            <img src="{{ asset(''.settings()->get('app_stempel')) }}" alt="Stempel Lunas">
        </div>

        <!-- Customer Info -->
        <div class="customer-info">
            <strong>Terimakasih</strong>
            <p>Telah Menggunakan Layanan Kami</p>
            <strong>{{ settings('app_name') }}</strong>
            <p>Telp. {{ settings('app_phone') }}</p>
            <p><a href="{{ settings('app_website') }}">{{ settings('app_website') }}</a></p>
        </div>
    </div>
    <!-- /Container -->
</body>
</html>
