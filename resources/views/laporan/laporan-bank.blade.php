@extends('layouts.app_blank')

@section('content')

<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">
                <div class="box-header" style="text-align: center;">
                    <h3 class="box-title">
                        Laporan Bank Sampah
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
                        @if(request('nama'))
                            - Nama Nasabah: {{ request('nama') }}
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
                                    <th>Nama Nasabah</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Jenis Sampah</th>
                                    <th>Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($model as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nasabah->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @foreach ($item->detailTransaksiBank as $detailTransaction)
                                                {{ $detailTransaction->jenisSampah->name }}: {{ $detailTransaction->berat }} kg<br>
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
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection


