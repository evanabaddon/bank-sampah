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
                    <td>{{ $model->nasabah->name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ $model->created_at }}</td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>{{ $model->formatRupiah('jumlah') }}</td>
                </tr>
                <tr>
                    <th>Operator</th>
                    <td>{{ $model->user->name }}</td>
                </tr>
                
            </table>
        </div>
        <div class="box-footer">
            <a href="{{ route('transaksi-penarikan.index') }}" class="btn btn-default">Kembali</a>
        </div>
    </div>
</section>
@endsection
