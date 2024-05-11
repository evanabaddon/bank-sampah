@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Laporan
        <small>Data Laporan Tagihan Outlet</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header" style="text-align: center;">
                    <h3 class="box-title">
                        Laporan Tagihan / PPC Outlet
                        @if(request('user_id'))
                        - {{ $outlet->name }}
                        @endif
                        @if(request('kategori_layanan_id'))
                            - Layanan: {{ $kategoriLayanan->name }}
                        @endif
                        @if(request('status'))
                            - Status: {{ request('status') }}
                        @endif
                        @if(request('bulan'))
                            - Bulan: {{ \Carbon\Carbon::parse('2023-' . request('bulan') . '-01')->translatedFormat('F') }}
                        @endif
                        @if(request('tahun'))
                            - Tahun: {{ request('tahun') }}
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
                                    <th>Invoice</th>
                                    <th>Nama Nasabah</th>
                                    <th>Kategori Layanan</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Total Tagihan</th>
                                    <th>Komisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($model as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{  'PPC/' . $item->id . '/' . $item->nasabah_id . '/' . date('my', strtotime($item->tanggal_tagihan)) }}</td>
                                        <td>{{ $item->nasabah->name }}</td>
                                        <td>{{ $item->nasabah->kategoriLayanan->name }}</td>
                                        <td>{{ $item->tanggal_tagihan }}</td>
                                        <td>{{ $item->tanggal_jatuh_tempo }}</td>
                                        <td>{{ $item->tanggal_bayar }}</td>
                                        <td>{{ $item->formatRupiah('jumlah_tagihan') }}</td>
                                        <td>{{ is_numeric($komisi) ? App\Traits\HasFormatRupiah::formatRupiahStatic($komisi) : $komisi }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9">Data tidak ada</td>
                                    </tr>
                                @endforelse
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><strong>Total Setoran:</strong></td>
                                        <td>{{ is_numeric($totalJumlahTagihan) ? App\Traits\HasFormatRupiah::formatRupiahStatic($totalJumlahTagihan) : $totalJumlahTagihan }}</td>
                                        <td style="text-align: right;"><strong>Total Komisi:</strong></td>
                                        <td>{{ is_numeric($totalKomisi) ? App\Traits\HasFormatRupiah::formatRupiahStatic($totalKomisi) : $totalKomisi }}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('laporan.index') }}" class="btn btn-default">Kembali</a>
                            <a href="{{ route('laporan.outlet.cetak-pdf', request()->all()) }}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</a>
                            {{-- <a href="{{ route('laporan.tagihan.cetak-excel', request()->all()) }}" class="btn btn-success" target="_blank"><i class="fa fa-file-excel-o"></i>  Excel</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection


