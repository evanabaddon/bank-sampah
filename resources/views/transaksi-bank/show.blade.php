@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Detail Transaksi Bank
        <small>Data Detail Transaksi Bank Sampah</small>
    </h1>
</section>
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Detail Transaksi</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped">
                <tr>
                    <th>Nasabah</th>
                    <td>{{ $transaksiBank->nasabah->name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ \Carbon\Carbon::parse($transaksiBank->created_at)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>{{ $transaksiBank->formatRupiah('total_harga') }}</td>
                </tr>
                <tr>
                    <th>Operator</th>
                    <td>{{ $transaksiBank->user->name }}</td>
                </tr>
                <tr>
                    <th>Detail Transaksi</th>
                    <td>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jenis Sampah</th>
                                    <th>Berat (Kg)</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiBank->detailTransaksiBank as $detail)
                                    <tr>
                                        <td>{{ $detail->jenisSampah->name }}</td>
                                        <td>{{ $detail->berat }}</td>
                                        <td>{{ $detail->jenisSampah->formatRupiah('harga') }}</td>
                                        <td>{{ $detail->formatRupiah($detail->berat * $detail->jenisSampah->harga) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <a href="{{ route('transaksi-bank.index') }}" class="btn btn-default">Kembali</a>
        </div>
    </div>
</section>
@endsection
