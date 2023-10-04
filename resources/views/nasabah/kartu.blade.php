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
            border: 2px solid #3498db;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    
        h2 {
            font-size: 24px;
            color: #333;
        }
    
        p {
            font-size: 18px;
            color: #777;
        }
    
        img.qr-code {
            width: 150px;
            height: 150px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="kartu-anggota" style="text-align: center">
        <!-- Informasi anggota lainnya seperti nama, foto, dll. -->
        <h2>{{ $nasabah->name }}</h2>
        <p>No. Anggota: {{ $nasabah->kodenasabah }}</p>
        
        <!-- Tampilkan QR code menggunakan tag img -->
        <div style="text-align: center;">
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
