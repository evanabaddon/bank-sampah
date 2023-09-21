@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Transaksi Bank
        <small>Data Transaksi Bank Sampah</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <a href="{{ route('transaksi-bank.create') }}" class="btn btn-primary">Tambah Transaksi Bank</a>
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
                                    <th>Nama Nasabah</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Transaksi</th>
                                    <th>Operator</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nasabah->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->formatRupiah('total_harga') }}</td>
                                        <td>{{ $item->operator_name }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [ 'nasabah.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                            ]) !!}
                                            <div class="btn-group">
                                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#confirmModal-{{ $item->id }}"><b>Bayar</b></a>
                                                    <a href="{{ route('tagihan.edit',  $item->id) }}" class="btn btn-primary">Edit</a>
                                                
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
