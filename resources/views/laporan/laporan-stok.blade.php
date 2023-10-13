@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Laporan
        <small>Data Stok Sampah</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header" style="text-align: center;">
                    <h3 class="box-title">
                        Laporan Stok Sampah
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
                                    <th>Jenis Sampah</th>
                                    <th>Jumlah (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($model as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->stok }}</td>
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
                            <a href="{{ route('laporan.stok.cetak-pdf', request()->all()) }}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection

