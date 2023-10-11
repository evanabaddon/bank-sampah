@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Tagihan
        <small>Data Tagihan</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border"> 
                    <div class="row">
                        {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                            <div class="col-sm-3">
                                <input type="text" name="q" class="form-control pull-right" placeholder="Cari Nasabah" value="{{ request('q') }}">
                            </div>
                            @if(Auth::user()->role == 'admin')
                                <div class="col-sm-2">
                                    {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::selectRange('tahun', $tahunMin, $tahunMax, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                                </div>
                            
                                <div class="col-sm-2">
                                    {!! Form::select('kategori_layanan_id', $kategoriLayanan, request('kategori_layanan_id'), ['class' => 'form-control', 'placeholder'=>'Pilih Kategori Layanan']) !!}
                                </div>
                                <div class="col-sm-2">
                                    <select name="status" class="form-control pull-left">
                                        <option value="">Status</option>
                                        <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Bayar</option>
                                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Terbayar</option>
                                    </select>
                                </div>
                            @endif
                            <div class="col-sm-1">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-filter"></i>  Filter</button>
                            </div>
                        {!! Form::close() !!}
                    </div> 
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice</th>
                                    <th>Nama Nasabah</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Kategori Layanan</th>
                                    <th>Total Tagihan</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Operator</th>
                                    <th style="width: 200px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{  'PPC/' . $item->id . '/' . $item->nasabah_id . '/' . date('my', strtotime($item->tanggal_tagihan)) }}</td>
                                        <td>{{ $item->nasabah->name }}</td>
                                        <td>{{ $item->tanggal_tagihan }}</td>
                                        <td>{{ $item->tanggal_jatuh_tempo }}</td>
                                        <td>{{ $item->nasabah->kategoriLayanan->name }}</td>
                                        <td>{{ $item->formatRupiah('jumlah_tagihan') }}</td>
                                        <td>
                                            @if ($item->status == 'belum')
                                                <span class="badge bg-red">Belum Bayar</span>
                                            @else
                                                <span class="badge bg-green">Terbayar</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->tanggal_bayar }}</td>
                                        <td>{{ $item->user ? $item->user->name : 'User Tidak Ditemukan' }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [ 'nasabah.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                            ]) !!}
                                            <div class="btn-group">
                                                @if ($item && $item->status === 'belum')
                                                    
                                                    <a href="#" class="btn btn-block btn-success" data-toggle="modal" data-target="#confirmModal-{{ $item->id }}"><b>Bayar</b></a>
                                                @elseif ($item && $item->status === 'lunas')
                                                    <a href="{{ route('print.nota', ['tagihan_id' => $item->id]) }}" class="btn btn-primary" target="_blank">Cetak Nota</a>
                                                    <a href="{{ route('kirim.nota', ['tagihan_id' => $item->id]) }}" class="btn btn-success" target="_blank">Kirim Nota</a>
                                                @endif
                                            </div>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    <!-- Modal Konfirmasi Pembayaran -->
                                    <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel-{{ $item->id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="confirmModalLabel-{{ $item->id }}">Konfirmasi Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin melakukan transaksi pembayaran untuk tagihan ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
                                                    @if ($item)
                                                    <a href="{{ route('update.and.print.nota', ['tagihan_id' => $item->id]) }}" class="btn btn-primary">Yakin</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="11">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $models->links() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection
