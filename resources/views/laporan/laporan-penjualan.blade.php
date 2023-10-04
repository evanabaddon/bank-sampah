@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Laporan
        <small>Data Penjualan Sampah</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header" style="text-align: center;">
                    <h3 class="box-title">
                        Laporan Penjualan Sampah
                        @if(request('bulan'))
                            - Bulan: {{ \Carbon\Carbon::parse('2023-' . request('bulan') . '-01')->translatedFormat('F') }}
                        @endif
                        @if(request('tahun'))
                            - Tahun: {{ request('tahun') }}
                        @endif
                        @if(request('jenis_sampah_id'))
                            - Jenis Sampah: {{ $jenisSampah->name }}
                        @endif
                    </h3>
                    
                </div>
                    
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Jenis Sampah</th>
                                    <th>Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($model as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strftime('%d %B %Y', strtotime($item->tanggal)) }}</td>
                                        <td>
                                            @foreach ($item->detailTransaksiPenjualans as $detailTransaction)
                                                {{ $detailTransaction->jenisSampah->name }}: {{ $detailTransaction->jumlah_kg }} kg x {{ $detailTransaction->formatRupiah('total_harga') }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->formatRupiah('total_harga') }}</td>
                                    </tr>
                                   
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('laporan.index') }}" class="btn btn-default">Kembali</a>
                            <a href="{{ route('laporan.transaksi.penjualan.cetak-pdf', request()->all()) }}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection


