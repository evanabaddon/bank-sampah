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
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 200px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                    <th>Aksi</th>
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
                                        <td>
                                            {!! Form::open([
                                                'route' => [ 'nasabah.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                            ]) !!}
                                            <div class="btn-group">
                                                @if ($item && $item->status === 'belum')
                                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#confirmModal-{{ $item->id }}"><b>Bayar</b></a>
                                                    <a href="{{ route('tagihan.edit',  $item->id) }}" class="btn btn-primary">Edit</a>
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
                                        <td class="text-center" colspan="9">Data tidak ada</td>
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
