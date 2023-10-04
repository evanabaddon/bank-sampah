@extends('layouts.app')

@section('content')
<section class="content-header">
   
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">90<small>%</small></span>
                </div> 
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">90<small>%</small></span>
                </div> 
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">90<small>%</small></span>
                </div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Scan QR Code Nasabah</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="reader"></div>
                        </div>
                    </div>
                </div>
                <div class="box-footer no-padding">
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tagihan Belum Terbayar</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 100px;">
                            <div class="input-group-btn">
                                <a href="{{ route('tagihan.index') }}" class="btn btn-block btn-info">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>RT</th>
                                <th>RW</th>
                                <th>No. HP</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nasabahTerakhir as $key => $nasabah)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $nasabah->name }}</td>
                                    <td>{{ $nasabah->alamat }}</td>
                                    <td>{{ $nasabah->rt }}</td>
                                    <td>{{ $nasabah->rw }}</td>
                                    <td>{{ $nasabah->nohp }}</td>
                                    <td>{{ $nasabah->formatRupiah('saldo') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaksi Bank Sampah Terakhir</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 100px;">
                            <div class="input-group-btn">
                                <a href="{{ route('transaksi-bank.index') }}" class="btn btn-block btn-info">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>RT</th>
                                <th>RW</th>
                                <th>No. HP</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nasabahTerakhir as $key => $nasabah)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $nasabah->name }}</td>
                                    <td>{{ $nasabah->alamat }}</td>
                                    <td>{{ $nasabah->rt }}</td>
                                    <td>{{ $nasabah->rw }}</td>
                                    <td>{{ $nasabah->nohp }}</td>
                                    <td>{{ $nasabah->formatRupiah('saldo') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    
                </div>
            </div>
        </div>
    </div>
    
    
</section>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // Buat variabel untuk menandai apakah pemindaian sudah berhasil
    let qrScanned = false;

    function onScanSuccess(decodedText, decodedResult) {
        // Jika pemindaian sudah berhasil, berhenti pemindaian
        if (qrScanned) {
            return;
        }
        
        $('#result').val(decodedText);
        let id = decodedText;

        // Kirim hasil pemindaian QR code ke fungsi validasiQr di server
        $.ajax({
            url: "{{ route('validasi-qr', '') }}/" + id, // Menambahkan id ke URL
            type: 'GET',
            success: function(response) {
                if (response.status == 'success') {
                    qrScanned = true; // Tandai pemindaian sudah berhasil
                    alert('Berhasil');
                    window.location.href = "{{ route('nasabah.show', '') }}/" + response.nasabah;
                } else {
                    alert('Gagal atau QR Code tidak valid');
                }
            },
            error: function(error) {
                alert('Terjadi kesalahan saat mengirim permintaan ke server.');
            }
        });
    }




    function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    // console.warn(`Code scan error = ${error}`);
    }


    let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250} },
    /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endsection


