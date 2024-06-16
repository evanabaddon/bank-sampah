<!DOCTYPE html>
<html>
<head>
    <title>Kartu Anggota</title>
    <style>
        /* Gaya CSS untuk kartu anggota */
        .kartu-anggota {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #000000;
            background-color: #fcfcfc;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .logo img {
            width: 100px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
            color: #333333;
            margin-bottom: 15px;
        }

        p {
            font-size: 14px;
            color: #555555;
            margin: 10px 0;
        }

        img.qr-code {
            width: 200px;
            height: 200px;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="kartu-anggota">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/'.settings()->get('app_logo')) }}" alt="Logo">
        </div>

        <!-- Header -->
        <div class="header">
            <strong>{{ settings('app_name') }}</strong>
            <p style="font-size: 12px; margin: 0;">{{ settings('app_address') }}</p>
        </div>

        <!-- Informasi anggota -->
        <h2>{{ $nasabah->name }}</h2>
        <p>No. Anggota: {{ $nasabah->kodenasabah }}</p>
        <p>Alamat: {{ $nasabah->alamat }}</p>
        <p>RT: {{ $nasabah->rt }} / RW: {{ $nasabah->rw }}</p>

        <!-- Tampilkan QR code menggunakan tag img -->
        <div>
            {!! QrCode::size(250)->generate($nasabah->kodenasabah) !!}
        </div>
    </div>

    <!-- Script untuk mencetak otomatis saat halaman dimuat -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
