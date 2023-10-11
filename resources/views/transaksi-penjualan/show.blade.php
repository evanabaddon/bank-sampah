@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Detail Transaksi Penjualan
        <small>Data Detail Transaksi Penjualan Sampah</small>
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
                    <th>Tanggal Transaksi</th>
                    <td>{{ $transaksiPenjualan->tanggal }}</td>
                </tr>
                <tr>
                    <th>Pengepul</th>
                    <td>{{ $transaksiPenjualan->pengepul ? $transaksiPenjualan->pengepul->name : '-' }}</td>
                <tr>
                    <th>Operator</th>
                    <td>{{ $transaksiPenjualan->user->name }}</td>
                </tr>
                <tr>
                    <th>Detail Transaksi</th>
                    <td>
                        @if ($transaksiPenjualan->detailTransaksiPenjualans)
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
                                   
                                    @foreach ($transaksiPenjualan->detailTransaksiPenjualans as $detail)
                                    
                                        <tr>
                                            <td>{{ $detail->jenisSampah->name }}</td>
                                            <td>{{ $detail->jumlah_kg }}</td>
                                            <td>{{ $detail->formatRupiah('total_harga') }}</td>
                                            <td>{{ $transaksiPenjualan->formatRupiah($detail->jumlah_kg * $detail->total_harga) }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Tidak ada detail transaksi.</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>{{ $transaksiPenjualan->formatRupiah('total_harga') }}</td>
                </tr>
            </table>
        </div>
        <div class="box-footer">
            <a href="{{ route('transaksi-penjualan.index') }}" class="btn btn-default">Kembali</a>
        </div>
    </div>
</section>
@endsection
